<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder;

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

        //$array2+=['installmentStatus','غير مسدد'];


        if(isset($request->dateFrom)){
            $array2 += ['installmentDueDate','>=',$request->dateFrom];
        }




//Lead::whereBetween('created_at', [date('Y-m-d', strtotime($input['from'])), date('Y-m-d', strtotime($input['to']))])->get();
        if(!isset($request->dateTo) && !isset($request->dateFrom)){
            $ins = Installment::with('order')->where('installmentStatus','غير مسدد')->whereHas('order',function($q) use ($array1) {
                $q->where($array1);
            })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }else if(isset($request->dateTo))
        {
            $ins = Installment::with('order')

                ->where('installmentStatus','غير مسدد')
                ->where('installmentDueDate','<=',$request->dateTo)
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
                ->where('installmentStatus','غير مسدد')
                ->where('installmentDueDate','>=',$request->dateFrom)
                ->whereHas('order',function($q) use ($array1) {
                    $q->where($array1);
                })->get();

            return response()->json([
                'data'=>$ins,
                'status'=>200
            ]);
        }else{
            $ins = Installment::with('order')
             //   ->whereMonth('installmentDueDate',Carbon::now()->month)
                ->where('installmentStatus','غير مسدد')
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
        $installments = Installment::whereMonth('installmentDueDate',Carbon::now()->month)->with('order')->get();
        return response()->json([
            'installmentsDue'=>$installments
        ]);
    }

    public function installmentSchedulingView()
    {
        return view('installments.installmentScheduling');
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
