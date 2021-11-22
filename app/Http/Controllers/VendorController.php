<?php


namespace App\Http\Controllers;


use App\Models\Order;
use App\Services\VendorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class VendorController
 * @package App\Http\Controllers
 */
class VendorController extends Controller
{
    private $vendorService;

    public function __construct(VendorService  $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function getOrders(Request $request)
    {
        $vendor_id = $request->input('vendor_id');
        $response_format = $request->input('format');
        $result = $this->vendorService->getVendorOrders($vendor_id);
        if ($response_format == 'xml') {
            return response()->xml($this->xmlFormat($result[0]->first()));
        }
        return response()->json($this->toJsonFormat($result[0]->first()));
    }

    private function xmlFormat(Order $order)
    {
        return [
            'orders' => [
                'order' => [
                    'order_number' => $order->id,
                    'customer_data' => [
                        'first_name' => $order->first_name,
                        'last_name' => $order->last_name,
                        'address1' => $order->address_1,
                        'address2' =>
                        $order->address_2,
                        'city' => $order->city,
                        'state' => $order->state,
                        'zip' => $order->postal_code,
                        'country' => $order->country,
                    ],
                    'items' => [
                        'item' => $this->generateItems($order->items->toArray()),
                    ]
                ]
            ]
        ];
    }

    public function toJsonFormat($orders)
    {
        return [
            'data' => [
                'orders' => $this->generateJsonStruct($orders)
            ]
        ];
    }

    private function generateJsonStruct($order)
    {
        return [
            "external_order_id" => $order->id,
            "buyer_first_name" => $order->first_name,
            "buyer_last_name" => $order->last_name,
            "buyer_shipping_address_1" => $order->address_1,
            "buyer_shipping_address_2" => $order->address_2,
            "buyer_shipping_city" => $order->city,
            "buyer_shipping_state" => $order->state,
            "buyer_shipping_postal" => $order->postal_code,
            "buyer_shipping_country" => $order->country,
            "print_line_items" => $this->generateJsonItems($order->items->toArray())
        ];
    }

    private function generateJsonItems(array $lineItems)
    {
        $items = [];
        foreach ($lineItems as $item) {
            $items['external_ order_line_item_id'] = $item['id'];
            $items['product_id'] = $item['product_id'];
            $items['quantity'] = $item['quantity'];
        }

        return $items;
    }

    private function generateItems(array $lineItems)
    {

        $items = [];
        foreach ($lineItems as $item) {
            $items['order_line_item_id'] = $item['id'];
            $items['product_id'] = $item['product_id'];
            $items['quantity'] = $item['quantity'];
        }

        return $items;
    }
}
