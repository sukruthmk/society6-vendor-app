<?php


namespace App\Services;


use App\Exceptions\InvalidRequestException;
use App\Repositories\interfaces\VendorInterface;
use Illuminate\Support\Facades\Hash;

use App\Models\Vendor;
use App\Models\Order;
use phpDocumentor\Reflection\Types\Null_;

class VendorService
{
    /**
     * VendorService constructor.
     */
    public function __construct()
    {
    }


    /**
     * @param int $id
     */
    public function getVendorOrders(int $id)
    {
        $vendor = Vendor::with('productTypes')->findOrFail($id);
        // For the sake of this excersise 
        // we will consider each product is mapped to only one vendor
        $productTypeId = $vendor->productTypes[0]->id;
        $orders
            = Order::with([
                'user',
                'items' => function ($q) use ($productTypeId) {
                    $q->where('shipped_at', Null);
                    $q->where('product_id', $productTypeId);
                }
            ])->get();
        return $orders;
    }
}
