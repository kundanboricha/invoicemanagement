<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_type' => 'required|in:single,bulk',
            'items.*.price_per_unit' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists'   => 'Selected customer does not exist.',

            'invoice_date.required' => 'Invoice date is required.',
            'invoice_date.date'     => 'Please provide a valid date.',

            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric'  => 'Total amount must be a number.',

            'items.required'     => 'Please add at least one product.',
            'items.array'        => 'Invalid product format.',
            'items.min'          => 'You must add at least one product item.',

            'items.*.product_id.required' => 'Please select a product.',
            'items.*.product_id.exists'   => 'One or more selected products are invalid.',

            'items.*.quantity.required' => 'Please enter quantity.',
            'items.*.quantity.integer'  => 'Quantity must be a whole number.',
            'items.*.quantity.min'      => 'Quantity must be at least 1.',

            'items.*.price_type.required' => 'Please select a price type.',
            'items.*.price_type.in'       => 'Invalid price type. Choose single or bulk.',

            'items.*.price_per_unit.required' => 'Price per unit is required.',
            'items.*.price_per_unit.numeric'  => 'Price must be a number.',
            'items.*.price_per_unit.min'      => 'Price cannot be negative.',
        ];
    }
}
