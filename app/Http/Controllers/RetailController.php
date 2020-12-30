<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require __DIR__ . '/../../../vendor/autoload.php';

class RetailController extends Controller
{
    private $client;

    public function __construct(string $url, string $apiKey)
    {
        $this->client = new \RetailCrm\ApiClient(
            $url,
            $apiKey,
            \RetailCrm\ApiClient::V5
        );
    }

    public function getOrders($filter = [])
    {
        $orders = [];
        $ordersRequest = $this->client->request->ordersList($filter, 1, 100);
        $totalPageCount = $ordersRequest['pagination']['totalPageCount'];

        for ($i = 1; $i <= $totalPageCount; $i++) {
            $ordersRequest = $this->client->request->ordersList($filter, $i, 100);
            foreach ($ordersRequest['orders'] as $order) {
                $orders[] = $order;
            }
        }
        return $orders;
    }

    public function getOrder($id)
    {
        $ordersRequest = $this->client->request->ordersGet($id, 'id');

        return $ordersRequest['order'];
    }

    public function getDeliveryName($code)
    {
        $deliveryTypes = $this->client->request->deliveryTypesList();
        foreach ($deliveryTypes['deliveryTypes'] as $type) {
            if ($type['code'] == $code) {
                return $type['name'];
            }
        }
        return 'none';
    }

    public function getProduct($offerId)
    {
        $storeProducts = $this->client->request->storeProducts([
            'offerIds' => [$offerId]
        ], 1, 100);

        foreach ($storeProducts['products'] as $product) {
            foreach ($product['offers'] as $offer) {
                if ($offer['id'] == $offerId) {
                    return $product;
                }
            }
        }
        return ['error' => 'none'];
    }

    public function orderEdit($array)
    {
        $orderEdit = $this->client->request->ordersEdit($array, 'id', $array['site']);
        if ($orderEdit->isSuccessful()) {
            return true;
        } else {
            return $orderEdit;
        }
    }

}
