<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Order;
use App\Models\RejectedOrders;
use App\Models\Wallet;
use App\Models\WithdrawAddCash;
use App\Models\WithdrawCash;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::where('status',1)->select('id','walletName')->get();
        return view('orders.orders',[
            'wallets'=>$wallets,
        ]);
    }

    public function orders()
    {
        $orders = Order::with('wallet')->get();
        return response()->json([
            'orders'=>$orders,
        ]);
    }
    public function acceptOrder($id)
    {
        $order = Order::find($id);
        if (!$order){
            return response()->json([
                'status'=>400,
                'msg'=>'الطلب غير موجود'
            ]);
        }else{
            $order->update(['orderCase'=>'مقبول']);
            return response()->json([
                'status'=>200,
                'msg'=>'الطلب مقبول'
            ]);
        }

    }

    public function rejectedOrder(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'reason'=> 'required|max:150',
                'order_id'=> 'required|exists:orders,id',
            ] ,[]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {

                $order = Order::find($request->post('order_id'));
                if (!$order){
                    return response()->json([
                        'status'=>400,
                        'msg'=>'الطلب غير موجود'
                    ]);
                }
                    $order->update(['orderCase'=>'مرفوض','CloseReason'=>$request->post('reason')]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'msg'=>'الطلب مرفوض'
                    ]);
            }

        }catch (Exception $ex){
            DB::rollback();
            return response()->json([
                'status' => 401,
                'msg' => '  فشلت العملية برجاءالمحاوله مجددا',
            ]);
        }
    }

    public function paymentOrder(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [

                'order_id'=> 'required|exists:orders,id',
                'wallet_id'=> 'required|exists:wallets,id',
                'date'=> 'required',
            ] ,[]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {

                $order = Order::find($request->post('order_id'));
                $wallet = Wallet::find($request->post('wallet_id'));
                if (!$order){
                    return response()->json([
                        'status'=>400,
                        'msg'=>'الطلب غير موجود'
                    ]);
                }

                if ($wallet->highestAmountCanWithdrawn < $order->projectAmount){
                    return response()->json([
                        'status' => 000,
                        'msg' => "مبلغ المشروع اكبر من الحد الاقصى للسحب من المحفظة ",
                    ]);
                }
                if ($wallet->totalAmount < $order->projectAmount){
                    return response()->json([
                        'status' => 000,
                        'msg' => "مبلغ المشروع اكبر من المبلغ الاجمالي للمحفظة ",
                    ]);
                }
                if ($order->projectAmount <= 0){
                    return response()->json([
                        'status' => 000,
                        'msg' => "يرجى ادخال مبلغ للمشروع",
                    ]);
                }

                if ($order->wallet_id != null){
                    return response()->json([
                        'status' => 000,
                        'msg' => "الطلب مدفوع بالفعل ",
                    ]);
                }

                $totalAmount = $wallet->totalAmount - $order->projectAmount;
                $installmentValue = $order->projectAmount / $order->repaymentFinancingAmountMonths;
                $installmentValue = number_format($installmentValue, 2, '.', '');
                $monthNumber = $order->repaymentFinancingAmountMonths;


                for ($i = 1; $i <= $monthNumber; $i++) {
                    $final = date("Y-m-d", strtotime("+".$i."month"));
                   Installment::insert([
                       'installmentDueDate'=>$final,
                       'installmentAmount'=>$installmentValue,
                       'installmentStatus'=>'غير مسدد',
                       'order_id'=>$request->post('order_id'),
                   ]);


                }

                WithdrawAddCash::insert([
                    'amount' => $order->projectAmount,
                    'date' => $request->post('date'),
                    'reason' => 'تم سحب المبلغ لتمويل مشروع'.$order->projectName,
                    'attachFile' => 's.png',
                    'wallet_id' => $request->post('wallet_id'),
                ]);

                $order->update([
                    'wallet_id'=>$request->post('wallet_id'),
                   // 'paymentCase'=>1,
                ]);

                $wallet->update([
                    'totalAmount'=>$totalAmount,
                ]);

                DB::commit();
                return response()->json([
                    'status'=>200,
                    'msg'=>'تم سحب المبلغ بنجاح'
                ]);
            }

        }catch (Exception $ex){
            DB::rollback();
            return response()->json([
                'status' => 401,
                'msg' => 'فشلت عملية السحب حاول فيما بعد',
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.addOrder');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'idNumber'=> 'required|digits:9|unique:orders,idNumber',
                'projectName'=> 'required|max:40',
                'beneficiaryName'=> 'required|max:40',
                'repaymentFinancingAmountMonths'=> 'required|max:40',
                'phone'=> 'required|max:10',
                'orderDate'=> 'required',
                'projectType'=> 'required',
                'projectAmount'=> 'required|numeric',
                'expectedProfit'=> 'required|numeric',
            ] ,[
                    'idNumber.unique'=>'رقم الهوية موجود بالفعل',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {


                    Order::insert([
                        'idNumber' => $request->post('idNumber'),
                        'projectName' => $request->post('projectName'),
                        'beneficiaryName' => $request->post('beneficiaryName'),
                        'repaymentFinancingAmountMonths' => $request->post('repaymentFinancingAmountMonths'),
                        'phone' => $request->post('phone'),
                        'orderDate' => $request->post('orderDate'),
                        'projectType' => $request->post('projectType'),
                        'projectAmount' => $request->post('projectAmount'),
                        'expectedProfit' => $request->post('expectedProfit'),
                        'orderCase' => 'قيد الدراسة',

                    ]);
                    return response()->json([
                        'status' => 200,
                        'msg' => "تمت اضافة الطلب بنجاح ",
                    ]);

                }


        }catch (Exception $ex){
            return $ex;
            return response()->json([
                'status' => 401,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(!$order){
            return response()->json([
                'status'=>400,
                'msg'=>'الطلب غير موجود'
            ]);
        }else{
            $order->delete();
            return response()->json([
                'status'=>200,
                'msg'=>'تم حذف الطلب'
            ]);
        }
    }
}
