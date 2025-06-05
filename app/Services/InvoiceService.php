<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function createInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::create([
                'customer_id' => $data['customer_id'],
                'invoice_date' => $data['invoice_date'],
                'total_amount' => $data['total_amount'],
            ]);

            $this->storeItems($invoice, $data['items']);

            return $invoice;
        });
    }

    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $invoice->update([
                'customer_id' => $data['customer_id'],
                'invoice_date' => $data['invoice_date'],
                'total_amount' => $data['total_amount'],
            ]);

            $invoice->items()->delete();

            $this->storeItems($invoice, $data['items']);

            return $invoice;
        });
    }

    public function deleteInvoice(Invoice $invoice): void
    {
        $invoice->delete();
    }

    protected function storeItems(Invoice $invoice, array $items): void
    {
        foreach ($items as $item) {
            InvoiceItem::create([
                'invoice_id'      => $invoice->id,
                'product_id'      => $item['product_id'],
                'quantity'        => $item['quantity'],
                'price_type'      => $item['price_type'],
                'price_per_unit'  => $item['price_per_unit'],
                'total_price'     => $item['quantity'] * $item['price_per_unit'],
            ]);
        }
    }
}
