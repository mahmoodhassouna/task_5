<?php

namespace App\Http\Controllers;

use App\Models\CloseWallet;
use App\Models\Wallet;
use App\Models\WithdrawCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WithdrawCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $totalAmount = Wallet::where('id',$id)->select('totalAmount')->first();
        return view('wallets.withdrawMoney',[
            'wallet_id'=>$id,
            'totalAmount1'=>$totalAmount,
        ]);
    }
    function saveImage($photo, $folder)
    {
        //save photo in folder
        $file_extension = $photo->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = $folder;
        $photo->move($path, $file_name);

        return $file_name;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'withdrawAmount'=> 'required|numeric',
                'withdrawDate'=> 'required|max:40',
                'reason'=> 'required|max:150',
                'attachFile'=> 'required|mimes:jpg,png,webp,svg,jpeg|max:10000',
                'wallet_id'=> 'required|exists:wallets,id',
            ] ,[]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 200,
                    'errors' => $validator->messages()
                ]);
            } else {

                $file_name = $this->saveImage($request->attachFile, 'images/withdraw');

                WithdrawCash::insert([
                    'withdrawAmount' => $request->post('withdrawAmount'),
                    'withdrawDate' => $request->post('withdrawDate'),
                    'reason' => $request->post('reason'),
                    'attachFile' => $file_name,
                    'wallet_id' => $request->post('wallet_id'),

                ]);

                $wallet = Wallet::where('id',$request->post('wallet_id'))->first();
                if($request->post('withdrawAmount') > $wallet->totalAmount){
                    return response()->json([
                        'status' => 444,
                        'msg' => "المبلغ المدخل اكبر من المبلغ الاجمالي ",
                    ]);
                }
                if ($request->post('withdrawAmount') > $wallet->highestAmountCanWithdrawn) {
                    return response()->json([
                        'status' => 445,
                        'msg' => "المبلغ المدخل اكبر من المبلغ الاقصى للسحب ",
                    ]);
                }

                $totalAmount = $wallet->totalAmount - $request->post('withdrawAmount');

                $wallet->update([
                    'totalAmount'=>$totalAmount,
                ]);
                DB::commit();
                return response()->json([
                    'status' => 400,
                    'msg' => "تم السحب بنجاح ",
                ]);

            }

        }catch (Exception $ex){
            DB::rollback();
            return $ex;
            return response()->json([
                'status' => 401,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }


    public function storeWithdrawWithClose(Request $request){

        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'withdrawAmount'=> 'required|numeric',
                'withdrawDate'=> 'required|max:40',
                'reason'=> 'required|max:150',
                'attachFile'=> 'required|mimes:jpg,png,webp,svg,jpeg|max:10000',
                'wallet_id'=> 'required|exists:wallets,id',
            ] ,[]
            );

            if ($validator->fails()) {

               // return redirect()->back();

            } else {

                $file_name = $this->saveImage($request->attachFile, 'images/withdraw');

                WithdrawCash::insert([
                    'withdrawAmount' => $request->post('withdrawAmount'),
                    'withdrawDate' => $request->post('withdrawDate'),
                    'reason' => $request->post('reason'),
                    'attachFile' => $file_name,
                    'wallet_id' => $request->post('wallet_id'),

                ]);

                $wallet = Wallet::where('id', $request->post('wallet_id'))->first();

                if ($request->post('withdrawAmount') > $wallet->highestAmountCanWithdrawn) {
                      //return redirect()->route('closeWallet');

                }
                if ($request->post('withdrawAmount') > $wallet->totalAmount) {
                      //return redirect()->route('closeWallet');

                }


                    $totalAmount = $wallet->totalAmount - $request->post('withdrawAmount');

                    CloseWallet::insert([
                        'wallet_id' => $request->post('wallet_id'),
                        'closeDate' => $request->post('withdrawDate'),
                        'reason' => $request->post('reason'),
                    ]);

                    $wallet->update([
                        'totalAmount' => $totalAmount,
                        'status' => 0,
                        'baseAmount' => 0,
                    ]);
                    DB::commit();
                    return redirect()->route('main');
                }

        }catch (Exception $ex){
            DB::rollback();
            return redirect()->route('main');
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawCash  $withdrawCash
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawCash $withdrawCash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawCash  $withdrawCash
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawCash $withdrawCash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WithdrawCash  $withdrawCash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawCash $withdrawCash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawCash  $withdrawCash
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawCash $withdrawCash)
    {
        //
    }
}
