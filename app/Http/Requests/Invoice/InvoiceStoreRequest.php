<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\BaseFormRequest;

class InvoiceStoreRequest extends BaseFormRequest
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
     */
    public function rules(): array
    {
        return [
            'seller_tax_code' => ['required', 'string', 'max:50'],
            'invoice_code' => ['required', 'string', 'max:100', 'unique:invoices,invoice_code'],
            // Giới hạn theo độ dài cột DB (varchar 255) để tránh lỗi truncate/overflow
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }
}
