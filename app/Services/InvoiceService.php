<?php

namespace App\Services;

use App\Models\Invoice;
use App\Repositories\InvoiceRepository;

class InvoiceService extends BaseService
{
    public function __construct(
        private InvoiceRepository $invoices,
    ) {
    }

    /**
     * Get paginated invoices.
     */
    public function list(int $perPage = 15)
    {
        return $this->invoices->paginate($perPage);
    }

    /**
     * Create a new invoice.
     */
    public function create(array $data): Invoice
    {
        return $this->invoices->create($data);
    }

    /**
     * Get an invoice by id.
     */
    public function find(int|string $id): Invoice
    {
        return $this->invoices->findOrFail($id);
    }

    /**
     * Update an invoice.
     */
    public function update(Invoice $invoice, array $data): Invoice
    {
        $this->invoices->update($invoice->id, $data);

        return $invoice->refresh();
    }

    /**
     * Delete an invoice.
     */
    public function delete(Invoice $invoice): bool
    {
        return $this->invoices->delete($invoice->id);
    }
}
