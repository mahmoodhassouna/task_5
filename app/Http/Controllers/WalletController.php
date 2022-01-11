<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Banks;
use App\Models\CloseWallet;
use App\Models\Wallet;

use App\Models\WithdrawCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Validator;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('wallets.wallets');
    }

    public function wallets()
    {
       $wallets = Wallet::with('bank')->get();
       return response()->json([
           'wallets'=>$wallets
       ]);
    }

    public function closeWallet(Request $request){
        DB::beginTransaction();
        try{
            $wallet = Wallet::where('id',$request->wallet_id)->first();
            if ($wallet->totalAmount > 1){
                return view('wallets.withdrawMoney',[
                    'wallet_id'=>$request->wallet_id,
                    'totalAmount'=>$wallet->totalAmount,
                    'totalAmount1'=>$wallet->totalAmount,
                    'action'=>'close',
                ]);
            }else{

              CloseWallet::insert([
                  'wallet_id'=>$request->post('wallet_id'),
                  'closeDate'=>$request->post('closeDate'),
                  'reason'=>$request->post('reason'),
              ]);

                $wallet->update([
                    'totalAmount'=>0,
                    'status'=>0,
                    'baseAmount'=>0,
                ]);
                DB::commit();
                return redirect()->route('main');
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Banks::select('id','bankName')->get();
        return view('wallets.addWallets',[
            'banks'=>$banks
        ]);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function saveImage($photo, $folder)
    {
        //save photo in folder
        $file_extension = $photo->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = $folder;
        $photo->move($path, $file_name);

        return $file_name;
    }

    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'walletName'=> 'required|max:40|unique:wallets,walletName',
                'baseAmount'=> 'required|numeric',
                'highestAmountCanWithdrawn'=> 'required|numeric',
                'totalAmount'=> 'required|numeric',
                'banks_id'=> 'required|numeric|exists:banks,id',
            ] ,[
                'walletName.unique'=>'اسم المحفظة مستخدم من قبل حاول استخدام اسم اخر',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {
                if (isset($request->attachWallet)){
                    $file_name = $this->saveImage($request->attachWallet, 'images/wallet');
                    Wallet::insert([
                        'walletName' => $request->post('walletName'),
                        'baseAmount' => $request->post('baseAmount'),
                        'highestAmountCanWithdrawn' => $request->post('highestAmountCanWithdrawn'),
                        'totalAmount' => $request->post('totalAmount'),
                        'banks_id' => $request->post('banks_id'),
                        'attachWallet' => $file_name,

                    ]);


                    return response()->json([
                        'status' => 200,
                        'msg' => "تمت اضافة المحفظة بنجاح ",
                    ]);
                }else{

                    Wallet::insert([
                        'walletName' => $request->post('walletName'),
                        'baseAmount' => $request->post('baseAmount'),
                        'highestAmountCanWithdrawn' => $request->post('highestAmountCanWithdrawn'),
                        'totalAmount' => $request->post('totalAmount'),
                        'banks_id' => $request->post('banks_id'),

                    ]);
                    return response()->json([
                        'status' => 200,
                        'msg' => "تمت اضافة المحفظة بنجاح ",
                    ]);

                }
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
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
