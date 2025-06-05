<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'invoice_date' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['bail', 'required', 'exists:products,id'],
            'items.*.quantity' => ['bail', 'required', 'integer', 'min:1'],
            'items.*.price_type' => ['bail', 'required', 'in:single,bulk'],
            'items.*.price_per_unit' => ['bail', 'required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'Selected customer does not exist.',

            'invoice_date.required' => 'Invoice date is required.',
            'invoice_date.date' => 'Please provide a valid date.',

            'items.required' => 'At least one product must be added.',
            'items.array' => 'Invalid format for items.',
            'items.min' => 'You must add at least one product item.',

            'items.*.product_id.required' => 'Please select a product.',
            'items.*.product_id.exists' => 'Selected product is invalid.',

            'items.*.quantity.required' => 'Quantity is required.',
            'items.*.quantity.integer' => 'Quantity must be a whole number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',

            'items.*.price_type.required' => 'Price type is required.',
            'items.*.price_type.in' => 'Price type must be Single or Bulk.',

            'items.*.price_per_unit.required' => 'Price per unit is required.',
            'items.*.price_per_unit.numeric' => 'Price must be a number.',
            'items.*.price_per_unit.min' => 'Price must be at least 0.',

            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric' => 'Total must be a number.',
            'total_amount.min' => 'Total must be at least 0.',
        ];
    }
}
