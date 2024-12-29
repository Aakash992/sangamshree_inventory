<?php

namespace App\Repository;

use App\Models\Sales;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\DB;

class SalesRepository
{
    private $sales;
    private $salesProduct;

    public function __construct(Sales $sales, SalesProduct $salesProduct)
    {
        $this->sales = $sales;
        $this->salesProduct = $salesProduct;
    }

    public function storeSalesProduct(array $data)
    {
        DB::beginTransaction();

        try {
            $salesOrder = $this->sales->create([
                'order_by' => $data['order_by'] ?? null,
                'customer_id' => $data['customer_id']
            ]);

            foreach ($data['products'] as $product) {
                // dd($data['products']);
                $this->salesProduct->create([
                    'sales_id' => $salesOrder->id,
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'payment_mode' => $product['payment_mode']
                ]);
            }

            DB::commit();
            return $salesOrder;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
