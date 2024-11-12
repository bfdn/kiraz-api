<?php

namespace App\Http\Requests\Api\OrderController\v1;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'order_no' => 'required|string',
            'payment_method' => 'required|integer',
            'order_status' => 'required|integer',
            'total_price' => 'required|numeric',
            'total_qty' => 'required|integer',
            'tax_total_price' => 'required|numeric',
            'name' => 'required|string',
            'company' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'notes' => 'required|string',
            'products' => 'required|array',
        ];
    }
}
