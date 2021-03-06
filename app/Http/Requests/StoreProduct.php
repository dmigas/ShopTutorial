<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name'          => 'required|unique:products|min:3|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required|numeric',
            'amount'        => 'required|numeric',
            'categories'    => 'required|exists:categories,id',
            'img'           => 'required|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }
}
