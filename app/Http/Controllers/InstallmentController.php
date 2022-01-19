<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WithdrawAddCash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Payments;
use function PHPUnit\Framework\isEmpty;


class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('installments.installments');
    }

    public function insPyments(){
        $wallets = Wallet::where('status',1)->get();
        return view('installments.payments',compact('wallets'));
    }

    public function Payment(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [

                'installment_id'=> 'required|exists:installments,id',
                'wallet_id'=> 'required|exists:wallets,id',
                'paymentDate'=> 'required|date',
                'amountPaid'=> 'required|numeric',
            ] ,[]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {
                 $ins = Installment::find($request->installment_id);

               if ($request->amountPaid > ($ins->installmentAmount - $ins->amountPaid)){
                   return response()->json([
                       'status'=>000,
                       'msg'=>'قيمة الدفعة اكبر من قيمة القسط'
                   ]);
               }

                $amountPaid = $request->amountPaid + $ins->amountPaid;
                $amount =   $ins->installmentAmount - $amountPaid;
                $ins->update([
                    'amountPaid'=>$amountPaid,
                    'paymentDate'=>$request->paymentDate,
                    'installmentStatus'=>($amount < 0.009 ? 'مسدد':'مسدد جزئي'),
                ]);

                $wallet = Wallet::find($request->wallet_id);
                $total = $wallet->totalAmount + $request->amountPaid;
                $wallet->update([
                    'totalAmount'=>$total,
                ]);
                 $projectName = Order::find($ins->order_id);
                WithdrawAddCash::insert([
                    'amount' => $request->amountPaid,
                    'date' => $request->post('paymentDate'),
                    'reason' => ($amount < 0.009 ? 'تم تسديد قيمة قسط مشروع':'تم تسديد دفعة جزئية من قسط مشروع') . $projectName->projectName,
                    'attachFile' => 's.png',
                    'type' => 'اضافة',
                    'wallet_id' => $request->post('wallet_id'),
                ]);

                DB::commit();
                return response()->json([
                    'status'=>200,
                    'msg'=>'تم الدفع  بنجاح'
                ]);
            }

        }catch (Exception $ex){
            DB::rollback();
            return response()->json([
                'status' => 401,
                'msg' => 'فشلت عملية الدفع حاول فيما بعد',
            ]);
        }

    }

    public function search(Request $request)
    {
        $array1 = [];
        $array2 = [];
        if(isset($request->projectName)){
            $array1 += ['projectName'=>$request->projectName];
        }

        if(isset($request->beneficiaryName)){
            $array1 += ['beneficiaryName'=>$request->beneficiaryName];
        }

        if(isset($request->dateFrom)){
            $array2 += ['installmentDueDate','>=',$request->dateFrom];
        }

//Lead::whereBetween('created_at', [date('Y-m-d', strtotime($input['from'])), date('Y-m-d', strtotime($input['to']))])->get();
        if(!isset($request->dateTo) && !isset($request->dateFrom)){

                $ins = Installment::with('order')
                ->where('installmentStatus','!=','مسدد')
                ->whereMonth('installmentDueDate',Carbon::now()->month)
                ->whereHas('order',function($q) use ($array1) {
                $q->where($array1);
            })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }else if(isset($request->dateTo))
        {
            $ins = Installment::with('order')
                ->where('installmentStatus','!=','مسدد')
                ->where('installmentDueDate','<=',$request->dateTo)
                ->whereMonth('installmentDueDate',Carbon::now()->month)
                ->whereHas('order',function($q) use ($array1) {
                $q->where($array1);
            })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }else if(isset($request->dateFrom))
        {
            $ins = Installment::with('order')
                ->where('installmentStatus','!=','مسدد')
                ->where('installmentDueDate','>=',$request->dateFrom)
                ->whereMonth('installmentDueDate',Carbon::now()->month)
                ->whereHas('order',function($q) use ($array1) {
                    $q->where($array1);
                })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }else{
            $ins = Installment::with('order')
                ->where('installmentStatus','!=','مسدد')
                ->where('installmentDueDate','<=',$request->dateTo)
                ->where('installmentDueDate','>=',$request->dateFrom)
                ->whereHas('order',function($q) use ($array1) {
                    $q->where($array1);
                })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }

    }

    public function installments($order_id)
    {
        $installments = Installment::where('order_id',$order_id)->get();
        return response()->json([
            'installments'=>$installments
        ]);
    }

    public function installmentsDue()
    {
        $installments = Installment::whereMonth('installmentDueDate',Carbon::now()->month)

          ->where('installmentStatus','غير مسدد')
            ->orWhere('installmentStatus', 'مسدد جزئي')
            ->with('order')->get();
        return response()->json([
            'installmentsDue'=>$installments
        ]);
    }

    public function installmentSchedulingView()
    {
        return view('installments.installmentScheduling');
    }

    public function importExcel()
    {
        return view('installments.importExcel');
    }

    protected function paymentQuery($id, $msg, $status, $fileName){
        Payment::where('id',$id)->update([
            'reason'=>$msg,
            'status'=>$status,
            'fileName'=>$fileName,
            'iteration'=>1,
        ]);
    }

    protected function returnErrors()
    {
        $lastFileName = DB::table('payment')->latest('fileName')->first();

        $countOfSuccess = Payment::where('status',1)->where('fileName',$lastFileName->fileName)->count();
        $countOfFail = Payment::where('status',0)->where('fileName',$lastFileName->fileName)->count();
        $messagesFail = Payment::where('status',0)->where('fileName',$lastFileName->fileName)->get();

        return response()->json([
            'status' => 200,
            'countOfSuccess' => $countOfSuccess,
            'countOfFail' => $countOfFail,
            'messagesFail' => $messagesFail,
            'msg' => 'العملية تمت بنجاح',
        ]);
    }

    protected function serchAboutFileName($fileName){
        $pay = Payment::where('fileName',$fileName)->get();
       if($pay->isEmpty()){
           return true;
       }
       return false;
    }

    public function import(Request $request)
    {
     //  DB::beginTransaction();
        try{

            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:xls,xlsx',

            ] ,[
                    'file.required'=>'يرجى اختيار الملف',
                    'file.mimes'=>'xls,xlsx صيغة الملف يجب ان تكون ',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            }else {

                $file = $request->file('file');

                $filename = $file->getClientOriginalName();
                $pay = Payment::where('iteration',1)->get();



                        if(InstallmentController::serchAboutFileName($filename))
                        {
                            Excel::import(new Payments(),$file);
                            $pay2 = Payment::where('iteration',0)->get();

                            foreach ($pay2 as $item){

                            $ins = Installment::with('order')
                                ->whereHas('order',function($q) use ($item) {
                                    $q->where('idNumber',$item->idNumber);
                                })->get();

                            if ($ins->isEmpty()){

                                InstallmentController::paymentQuery($item->id,'القسط غير موجود في جدول الاقساط', 0, $filename);

                            }else{
                                foreach ($ins as $it){

                                    $d1 =  Carbon::createFromFormat('Y-m-d', $it->installmentDueDate)->format('d-m-Y');
                                    $d2 =  Carbon::createFromFormat('Y-m-d', $item->paymentDate)->format('d-m-Y');

                                    if($d1 == $d2){

                                        $amountPaid = $it->amountPaid + $item->amountPaid;

                                        if($item->amountPaid <= ($it->installmentAmount - $it-> amountPaid) ){

                                            InstallmentController::paymentQuery($item->id,'تم دفع القسط', 1, $filename);

                                            $amount =  $it->installmentAmount - $amountPaid;
                                            $it->update([
                                                'amountPaid'=> $amountPaid,
                                                'paymentDate'=> $d1,
                                                'installmentStatus'=>($amount < 0.009 ? 'مسدد':'مسدد جزئي'),
                                            ]);


                                        }else if($it->installmentAmount == $it-> amountPaid){
                                            InstallmentController::paymentQuery($item->id,'القسط مسدد مسبقا', 0, $filename);
                                        }else{
                                            InstallmentController::paymentQuery($item->id,'المبلغ المدفوع اكبر من قيمة القسط', 0, $filename);

                                        }
                                        break;
                                    }

                                    InstallmentController::paymentQuery($item->id,'القسط غير مستحق بهذا اليوم', 0, $filename);
                                }
                            }

                        }

                     //   DB::commit();

                        return InstallmentController::returnErrors();
                        }else{
                            return response()->json([
                                'status'=>401,
                                'msg'=>'عذرا تم رفع الملف سابقا',
                            ]);
                        }

                    }




        }catch (Exception $ex){
           // DB::rollback();
            return response()->json([
                'status' => 401,
                'msg' => 'فشلت العملية حاول مجددا',
            ]);
        }

    }


    public function installmentScheduling()
    {
        $installments = Installment::with('order')->where('installmentStatus','غير مسدد')->get();
        return response()->json([
            'installmentScheduling'=>$installments
        ]);
    }

    public function installmentsPayment()
    {
        $installments = Installment::with('order')->where('installmentStatus','!=','مسدد')->get();
        return response()->json([
            'installmentPayments'=>$installments
        ]);
    }

    public function installmentsData($installment_id)
    {
        $installments = Installment::find($installment_id);
        return response()->json([
            'installmentData'=>$installments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        DB::beginTransaction();

        try{
            $validator = Validator::make($request->all(), [

                'installment_id'=> 'required|exists:installments,id',
                'orderr_id'=> 'required|exists:orders,id',
                'installmentAmount'=> 'nullable|numeric',
                'newData'=> 'nullable|date',
            ] ,[]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            }else {


                $totalAmount = 0;
                $installment = Installment::select('installmentAmount')->where('order_id', $request->orderr_id)->where('id', '>=', $request->installment_id)->get();
                $ins = Installment::find($request->installment_id);
                $ins2 = Installment::where('order_id', $request->orderr_id)->where('id', '>', $ins->id);
                $time = strtotime($request->post('newData'));

                if (isset($request->newData) && isset($request->installmentAmount)) {

                    if ($request->newData <= Carbon::now()) {
                        return response()->json([
                            'err' => 'التاريخ غير صالح'
                        ]);
                    }

                    foreach ($installment as $item) {
                        $totalAmount += $item->installmentAmount;
                    }
                    if ($request->installmentAmount > $totalAmount) {
                        return response()->json([
                            'status' => 400,
                            'msg' => 'قيمة القسط اكبر من المبلغ المتبقي عليك',
                        ]);
                    }
//
//                    $totalAmount -= $request->installmentAmount;
//
//                    $ins->update(['installmentAmount' => $request->installmentAmount,
//                        'installmentDueDate' => $request->newData
//                    ]);
//
//                    $totalAmount = $totalAmount / $ins2->count();
//                    $totalAmount = number_format($totalAmount, 2, '.', '');
//                    if ($totalAmount <= 0) {
//                        Installment::where('order_id', $request->orderr_id)->where('id', '>', $ins->id)->delete();
//                    }
//
//                    foreach ($ins2 as $key => $t) {
//                        $key += 1;
//                        $final = date("Y-m-d", strtotime("+" . $key . "month", $time));
//                        $t->installmentDueDate = $final;
//                        $t->installmentAmount = $totalAmount;
//                        $t->save();
//
//                    }

                    $totalAmount -= $request->installmentAmount;

                    $ins->update(['installmentAmount' => $request->installmentAmount,
                    'installmentDueDate'=>$request->post('newData')
                    ]);
                    Installment::where('order_id', $request->orderr_id)->where('id', '>', $ins->id)->delete();
                    $newRowValue = ceil($totalAmount / $request->installmentAmount);
                    for ($i=1; $i<=$newRowValue; $i++){
                        $installmentAmount = $totalAmount / $newRowValue;
                        $installmentAmount = number_format($installmentAmount, 2, '.', '');
                        $ins2->create([
                            'installmentAmount'=>$installmentAmount ,
                            'installmentDueDate'=>date("Y-m-d", strtotime("+" . $i . "month", $time)),
                            'amountPaid'=>0,
                            'installmentStatus'=>'غير مسدد',
                            'order_id'=>$ins->order_id,
                        ]);

                    }

                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'تم اعادة جدولة الاقساط بنجاح'
                    ]);

                } else if (isset($request->newData)) {

                    if ($request->newData <= Carbon::now()) {
                        return response()->json([
                            'err' => 'التاريخ غير صالح'
                        ]);
                    }

                    $ins->update([
                        'installmentDueDate' => $request->newData
                    ]);


//                    foreach ($ins2 as $key => $t) {
//                        $key += 1;
//                        $final = date("Y-m-d", strtotime("+" . $key . "month", $time));
//                        $t->installmentDueDate = $final;
//                        $t->save();
//
//                    }
                    $itration = $ins2->count();

                    for ($i=1; $i<=$itration; $i++){

                        $final = date("Y-m-d", strtotime("+" . $i . "month", $time));
                        $ins2->update([
                            'installmentDueDate'=>$final
                        ]);
                    }

                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'تم اعادة جدولة الاقساط بنجاح'
                    ]);


                } else if (isset($request->installmentAmount)) {

                    foreach ($installment as $item) {
                        $totalAmount += $item->installmentAmount;
                    }


                    if ($request->installmentAmount > $totalAmount) {

                        return response()->json([
                            'status' => 400,
                            'msg' => 'قيمة القسط اكبر من المبلغ المتبقي عليك',
                        ]);
                    }

                    $totalAmount -= $request->installmentAmount;

                    $ins->update(['installmentAmount' => $request->installmentAmount]);

                   // $totalAmount = $totalAmount / $ins2->count();
                   // $totalAmount = number_format($totalAmount, 2, '.', '');

                  //  if ($totalAmount <= 0) {
                        Installment::where('order_id', $request->orderr_id)->where('id', '>', $ins->id)->delete();
                  //  }

                    ///test

                    $newRowValue = ceil($totalAmount / $request->installmentAmount);
                    // return $totalAmount;

                    for ($i=1; $i<=$newRowValue; $i++){
                        $installmentAmount = $totalAmount / $newRowValue;
                        $installmentAmount = number_format($installmentAmount, 2, '.', '');
                        $ins2->create([
                            'installmentAmount'=>$installmentAmount ,
                            'installmentDueDate'=>date("Y-m-d", strtotime("+" . $i . "month", strtotime($ins->installmentDueDate))),
                            'amountPaid'=>0,
                            //'paymentDate'=>'k',
                            'installmentStatus'=>'غير مسدد',
                            'order_id'=>$ins->order_id,
                        ]);
                    }
//                    foreach ($ins2 as $t) {
//                        $t->installmentAmount = $totalAmount;
//                        $t->save();
//                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'تم اعادة جدولة الاقساط بنجاح'
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'msg' => 'قم بادخال بيانات لاعادة الجدولة'
                    ]);
                }

            }
        }catch (Exception $ex){

            DB::rollback();

            return response()->json([
                'status' => 401,
                'msg' => 'فشلت العملية حاول مجددا',
            ]);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
