<?php

namespace App\Repositories;

use App\Models\Invoice;

/**
 * Invoice Repository
 */
class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Invoice();
    }
}
