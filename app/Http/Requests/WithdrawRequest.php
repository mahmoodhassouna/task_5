<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'withdrawAmount'=> 'required|numeric',
                'withdrawDate'=> 'required|max:40',
                'reason'=> 'required|max:150',
                'attachFile'=> 'required|mimes:jpg,png,webp,svg,jpeg|max:10000',
                'wallet_id'=> 'required|exists:wallets,id',
        ];
    }
}
