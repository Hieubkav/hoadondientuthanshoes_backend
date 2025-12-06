<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class InvoiceUpdateRequest extends BaseFormRequest
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
            'seller_tax_code' => ['sometimes', 'string', 'max:50'],
            'invoice_code' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('invoices', 'invoice_code')->ignore($this->route('invoice')),
            ],
            // Giới hạn đồng bộ với cột DB (varchar 255) để tránh lỗi khi insert/update
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }
}
