<?php

namespace App\Http\Controllers;

use App\Models\AddCash;
use App\Models\CloseWallet;
use App\Models\Wallet;
use App\Models\WithdrawCash;
use Illuminate\Http\Request;

class DisplayWalletController extends Controller
{

    public function index($id){
        $addCash = AddCash::where('wallet_id',$id)->get();
        $withdrawCash = WithdrawCash::where('wallet_id',$id)->get();
        $wallet = Wallet::find($id);
        $closeDate = CloseWallet::where('wallet_id',$id)->first();
               // dd($withdrawCash->walletName);
        return view('wallets.displayWallet',[
            'cash'=>$addCash,
            'withdraw'=>$withdrawCash,
            'data'=>$wallet,
            'closeDate'=>$closeDate,
        ]);
    }
}
