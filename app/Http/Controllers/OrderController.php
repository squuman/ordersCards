<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use CdekSDK\Common;
use CdekSDK\Requests;
use Spipu\Html2Pdf\Html2Pdf;

require __DIR__ . '/../../../vendor/autoload.php';

class OrderController extends Controller
{
    public static function getOrders()
    {
        $retail = new RetailController('https://woolandmania.retailcrm.ru/', 'reRgbsJe5jCAMxf5C2R6l2bHylafqIBm');
        $orders = $retail->getOrders([
            'extendedStatus' => [
                'send-to-assembling'
            ]
        ]);

        return json_encode($orders);
    }

    public static function getOrderCard($id)
    {
        $retail = new RetailController('https://woolandmania.retailcrm.ru/', 'reRgbsJe5jCAMxf5C2R6l2bHylafqIBm');
        $order = $retail->getOrder($id);

        $order['delivery']['name'] = isset($order['delivery']['code']) ?
            $retail->getDeliveryName($order['delivery']['code']) : 'Способ доставки не указан';
        $items = $order['items'];
        foreach ($items as &$item) {
            $item['propertiesText'] = '';
            $product = $retail->getProduct($item['offer']['id']);
            $item['image'] = $product['imageUrl'];
        }
        $order['items'] = $items;
        return $order;
    }

    public static function processingOrder()
    {
        if (isset($_GET['label_garant'])) {
            return view('/lables/garant');
        } elseif(isset($_GET['label_sdek'])) {
            $client = new \CdekSDK\CdekClient('5cc34c499246b1bf4dfbd09aeb9dde79','2738004a08b638a28645ddf6a754bb62');

            $request = new Requests\PrintLabelsRequest([
                'PrintFormat' => Requests\PrintLabelsRequest::PRINT_FORMAT_A5,
            ]);
                $request->addOrder(Common\Order::withDispatchNumber('1222417983'));

            $response = $client->sendPrintLabelsRequest($request);

            if ($response->hasErrors()) {
                print_r("error");
            }

            Storage::put('file.pdf',(string)$response->getBody());
            return response()->file(storage_path() . '\app\file.pdf');

        } elseif (isset($_GET['collect'])) {
            $retail = new RetailController('https://woolandmania.retailcrm.ru/', 'reRgbsJe5jCAMxf5C2R6l2bHylafqIBm');
            $orderEdit = $retail->orderEdit([
                'id' => $_GET['id'],
                'status' => 'assembling-complete',
                'site' => $_GET['site']
            ]);

            Artisan::call('cache:clear');
            return Redirect::route('home');
        } else {
            return false;
        }
    }

    public static function collectOrder($orderParams)
    {
        $retail = new RetailController('https://woolandmania.retailcrm.ru/', 'reRgbsJe5jCAMxf5C2R6l2bHylafqIBm');
        $orderEdit = $retail->orderEdit([
            'id' => $_GET['id'],
            'status' => 'assembling-complete',
            'site' => $_GET['site']
        ]);

        Artisan::call('cache:clear');
        return Redirect::route('home');

    }

}
