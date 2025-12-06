<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicInvoiceController extends ApiController
{
    /**
     * Lookup invoice by seller_tax_code and invoice_code (public endpoint, no auth required)
     */
    public function lookup(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'seller_tax_code' => 'required|string|max:50',
            'invoice_code' => 'required|string|max:100',
        ], [
            'seller_tax_code.required' => 'Vui long nhap ma so thue ben ban.',
            'invoice_code.required' => 'Vui long nhap ma nhan hoa don.',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors()->toArray());
        }

        $invoice = Invoice::where('seller_tax_code', $request->seller_tax_code)
            ->where('invoice_code', $request->invoice_code)
            ->first();

        if (!$invoice) {
            return $this->notFound('Khong tim thay hoa don. Vui long kiem tra lai thong tin.');
        }

        return $this->success(
            new InvoiceResource($invoice),
            'Tim thay hoa don thanh cong!'
        );
    }

}
