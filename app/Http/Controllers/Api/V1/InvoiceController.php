<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends ApiController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * List invoices.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->get('per_page', 15);
            $invoices = $this->invoiceService->list($perPage);

            return $this->success(
                InvoiceResource::collection($invoices),
                'Invoices retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Create an invoice.
     */
    public function store(InvoiceStoreRequest $request): JsonResponse
    {
        try {
            $invoice = $this->invoiceService->create($request->validated());

            return $this->created(
                new InvoiceResource($invoice),
                'Invoice created successfully'
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Show an invoice.
     */
    public function show(Invoice $invoice): JsonResponse
    {
        return $this->success(
            new InvoiceResource($invoice),
            'Invoice retrieved successfully'
        );
    }

    /**
     * Update an invoice.
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice): JsonResponse
    {
        try {
            $updated = $this->invoiceService->update($invoice, $request->validated());

            return $this->success(
                new InvoiceResource($updated),
                'Invoice updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Delete an invoice.
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        try {
            $this->invoiceService->delete($invoice);

            return $this->success(
                null,
                'Invoice deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
