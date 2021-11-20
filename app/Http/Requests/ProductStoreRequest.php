<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|max:255',
            'code' => 'required|max:20|unique:products,code,' . $this->product?->id,
            'barcode' => 'required|max:20|unique:products,barcode,' . $this->product?->id,
            'description' => '',
            'price' => ''
        ];
    }
}
