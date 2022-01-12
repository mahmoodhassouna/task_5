<?php

namespace App\Http\Controllers;

use App\Models\AddCash;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AddCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wallets.addCash');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $totalAmount = Wallet::where('id',$id)->select('totalAmount')->first();
        return view('wallets.addCash',[
            'wallet_id'=>$id,
            'totalAmount'=>$totalAmount,
        ]);
    }

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
         DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'additionAmount'=> 'required|numeric',
                'additionDate'=> 'required|max:40',
                'reason'=> 'required|max:150',
                'attachFile'=> 'required|mimes:jpg,png,webp,svg,jpeg|max:10000',
                'wallet_id'=> 'required|exists:wallets,id',
            ] ,[
                    'attachFile.required'=>'الصورة مطلوبة',
                    'attachFile.mimes'=>'صيغة الصورة غير صالحة',
                    'attachFile.max'=>'حجم الصورة لايتعدى 1 ميجا',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {

                    $file_name = $this->saveImage($request->attachFile, 'images/addCash');

                    AddCash::insert([
                        'additionAmount' => $request->post('additionAmount'),
                        'additionDate' => $request->post('additionDate'),
                        'reason' => $request->post('reason'),
                        'attachFile' => $file_name,
                        'wallet_id' => $request->post('wallet_id'),

                    ]);

                    $wallet = Wallet::where('id',$request->post('wallet_id'))->first();
                    $wallet->update([
                        'totalAmount'=>$wallet->totalAmount + $request->post('additionAmount'),
                    ]);
                      DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => "تمت الاضافة بنجاح ",
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddCash  $addCash
     * @return \Illuminate\Http\Response
     */
    public function show(AddCash $addCash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AddCash  $addCash
     * @return \Illuminate\Http\Response
     */
    public function edit(AddCash $addCash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddCash  $addCash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddCash $addCash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddCash  $addCash
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddCash $addCash)
    {
        //
    }
}
