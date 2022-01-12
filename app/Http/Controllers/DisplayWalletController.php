<?php

namespace App\Http\Controllers;

use App\Models\AddCash;
use App\Models\CloseWallet;
use App\Models\Wallet;
use App\Models\WithdrawAddCash;
use App\Models\WithdrawCash;
use Illuminate\Http\Request;

class DisplayWalletController extends Controller
{

    public function index($id){
        $addCash = WithdrawAddCash::where(['wallet_id'=>$id,'type'=>'اضافة'])->get();
        $withdrawCash = WithdrawAddCash::where(['wallet_id'=>$id,'type'=>'سحب'])->get();
        $wallet = Wallet::find($id);

        return view('wallets.displayWallet',[
            'cash'=>$addCash,
            'withdraw'=>$withdrawCash,
            'data'=>$wallet,
        ]);
    }
}
