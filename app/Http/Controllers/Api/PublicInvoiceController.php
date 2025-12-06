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
            'seller_tax_code.required' => 'Vui lòng nhập mã số thuế bên bán.',
            'invoice_code.required' => 'Vui lòng nhập mã nhận hóa đơn.',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors()->toArray());
        }

        $invoice = Invoice::where('seller_tax_code', $request->seller_tax_code)
            ->where('invoice_code', $request->invoice_code)
            ->first();

        if (!$invoice) {
            return $this->notFound('Không tìm thấy hóa đơn. Vui lòng kiểm tra lại thông tin.');
        }

        return $this->success(
            new InvoiceResource($invoice),
            'Tìm thấy hóa đơn thành công!'
        );
    }
}
