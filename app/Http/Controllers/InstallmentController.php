<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $installments = Installment::where('installmentStatus','غير مسدد')->get();
        return response()->json([
            'installmentScheduling'=>$installments
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

            $totalAmount = 0;
            $installment= Installment::select('installmentAmount')->where('order_id',$request->orderr_id)->where('id','>=',$request->installment_id)->get();
            $ins = Installment::find($request->installment_id);
            $ins2= Installment::where('order_id',$request->orderr_id)->where('id','>',$ins->id)->get();
            $time = strtotime($request->post('newData'));

           if(isset($request->newData) && isset($request->installmentAmount))
           {
               if($request->newData <= Carbon::now()){
                   return response()->json([
                       'err'=>'التاريخ غير صالح'
                   ]);
               }

               foreach ($installment as $item)
               {
                   $totalAmount+=$item->installmentAmount;
               }
               if($request->installmentAmount > $totalAmount)
               {
                   return response()->json([
                       'status'=>400,
                       'msg'=>'قيمة القسط اكبر من المبلغ المتبقي عليك',
                   ]);
               }

               $totalAmount -= $request->installmentAmount;

               $ins->update(['installmentAmount'=>$request->installmentAmount,
                   'installmentDueDate'=>$request->newData
               ]);

               $totalAmount = $totalAmount / $ins2->count();

               if($totalAmount <= 0)
               {
                   Installment::where('order_id',$request->orderr_id)->where('id','>',$ins->id)->delete();
               }

               foreach ($ins2 as $key =>$t)
               {
                   $key+=1;
                   $final = date("Y-m-d", strtotime("+".$key."month",$time));
                   $t->installmentDueDate = $final;
                   $t->installmentAmount = $totalAmount;
                   $t->save();

               }
               DB::commit();
               return response()->json([
                   'status'=>200,
                   'msg'=>'تم اعادة جدولة الاقساط بنجاح'
               ]);

           }
           else if(isset($request->newData))
           {

               if($request->newData <= Carbon::now())
               {
                   return response()->json([
                       'err'=>'التاريخ غير صالح'
                   ]);
               }

               $ins->update([
                   'installmentDueDate'=>$request->newData
               ]);


               foreach ($ins2 as $key =>$t){
                   $key+=1;
                   $final = date("Y-m-d", strtotime("+".$key."month",$time));
                   $t->installmentDueDate = $final;
                   $t->save();

               }

               DB::commit();
               return response()->json([
                   'status'=>200,
                   'msg'=>'تم اعادة جدولة الاقساط بنجاح'
               ]);


           }
           else if(isset($request->installmentAmount))
           {

               foreach ($installment as $item)
               {
                   $totalAmount+=$item->installmentAmount;
               }


               if($request->installmentAmount > $totalAmount){

                   return response()->json([
                       'status'=>400,
                       'msg'=>'قيمة القسط اكبر من المبلغ المتبقي عليك',
                   ]);
               }

               $totalAmount -= $request->installmentAmount;

               $ins->update(['installmentAmount'=>$request->installmentAmount]);

               $totalAmount = $totalAmount / $ins2->count();

               // return $totalAmount;
               if($totalAmount <= 0){
                   Installment::where('order_id',$request->orderr_id)->where('id','>',$ins->id)->delete();
               }

               foreach ($ins2 as $t){
                   $t->installmentAmount = $totalAmount;
                   $t->save();
               }



               DB::commit();
               return response()->json([
                   'status'=>200,
                   'msg'=>'تم اعادة جدولة الاقساط بنجاح'
               ]);
           }
           else{
               return response()->json([
                   'status'=>400,
                   'msg'=>'قم بادخال بيانات لاعادة الجدولة'
               ]);
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
