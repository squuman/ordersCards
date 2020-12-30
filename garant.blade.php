<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <style type="text/css">
        body {
            padding: 0;
            margin: 0;
            width: 200mm;
            font-family: Arial, Tahoma, Verdana, Helvetica, sans-serif;
            font-weight: bold;
        }

        div {
            float: left;
            overflow: hidden;
        }

        .label {
            height: 56.8mm;
            width: 98mm; /*этикетка размером 59.4x105mm 10шт*/
            border: 1px solid #000;
        }

        .bb {
            margin: 4mm 2mm;
        }

        .d1 {
            height: 16mm;
            width: 57mm;
            font-size: 27pt;
            padding-left: 3mm;
        }

        .d1n {
            height: 10mm;
            width: 57mm;
            font-size: 20pt;
        }

        .d1cu {
            height: 5mm;
            width: 57mm;
            font: normal 13pt Times, Georgia, serif;
            line-height: 12pt;
        }

        .d2 {
            height: 16mm;
            width: 30.5mm;
            font-weight: normal;
            font-size: 18pt;
            text-align: right;
            line-height: 23pt;
        }

        .d3 {
            height: 6mm;
            width: 88mm;
            padding-top: 1mm;
            font: normal 14pt Times, Georgia, serif;
            text-align: center;
        }

        .d3-2 {
            height: 10mm;
            width: 88mm;
            font: normal 12pt Times, Georgia, serif;
        }

        .d1, .d2, .d3-2, .d8-2, .d8 {
            border-bottom: 0.5mm solid #777;
        }

        .d3-2, .d8-1, .d8-2 {
            color: #555;
        }

        .cu {
            font: normal 13pt Times, Georgia, serif;
            line-height: 12pt;
        }

        .con {
            font: normal 8pt Times, Georgia, serif;
        }

        .time {
            font-weight: normal;
            font-size: 14pt;
        }

        .d4 {
            height: 12mm;
            width: 40mm;
        }

        .d5 {
            height: 12mm;
            width: 19mm;
            font-size: 16pt;
        }

        .d6 {
            height: 12mm;
            width: 16mm;
            font-size: 16pt;
        }

        .d7 {
            height: 12mm;
            width: 25mm;
            font-size: 25pt;
        }

        .d1, .d4, .d5, .d6, .d8 {
            border-right: 0.5mm solid #777;
        }

        .d4, .d5, .d6, .d7 {
            text-align: center;
            line-height: 40pt;
        }

        .d8-1 {
            height: 10mm;
            width: 65mm;
            font: normal 12pt Times, Georgia, serif;
            text-align: right;
        }

        .d8-2 {
            padding: 0 0 0 3;
            height: 10mm;
            width: 65mm;
            font: normal 11pt Times, Georgia, serif;
        }

        .d8 {
            height: 16mm;
            width: 22.5mm;
            line-height: 23pt;
            font-weight: normal;
            font-size: 21pt;
            text-align: center;
            padding-top: 4mm;
        }

        .d9 {
            height: 9mm;
            width: 24.5mm;
            font-weight: normal;
            font-size: 21pt;
            text-align: center;
            padding-top: 3mm;
            border-right: 0.5mm solid #777;
        }

        .d10 {
            height: 20mm;
            width: 54mm;
            border-right: 0.5mm solid #777;
            border-bottom: 0.5mm solid #777;
            padding-left: 6mm;
        }

        .d11 {
            height: 20mm;
            width: 30mm;
            font: normal 8pt Arial, Georgia, serif;
            text-align: right;
            border-bottom: 0.5mm solid #777;
        }

        .d12 {
            height: 8mm;
            width: 60mm;
            font-weight: normal;
            font-size: 18pt;
            text-align: center;
            border-right: 0.5mm solid #777;
        }

        .d15 {
            height: 20mm;
            width: 30mm;
            font: bold 14pt Arial, Georgia, serif;
            text-align: right;
            border-bottom: 0.5mm solid #777;
        }

        .d14 {
            height: 8mm;
            width: 25mm;
            font-size: 21pt;
            text-align: center;
        }

    </style>
</head>
<body>
@php
    $order = \App\Http\Controllers\OrderController::getOrderCard($_GET['id']);
@endphp
@if(!isset($order['delivery']['service']['code']))
    <!DOCTYPE html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
    </head>
    Неверный тип доставки. Выберите "Экспресс-Гарант"
    </html>
@elseif($order['delivery']['service']['code'] == 'post')
    <div class="label">
        <div class="bb">
            <div class="d1">
                <div class="d1n">{{ $order['customFields']['exg_id'] }}&nbsp;<span
                        class="con">{{ $order['number'] }}</span></div>
                <div class="d1cu">Экспресс-Гарант</div>
            </div>
            <div class="d2"><b>{{ date('d.m.y',strtotime($order['delivery']['date'])) }}</b><br><span
                    class="time">00-00</span></div>
            <div class="d10">
                <img
                    src="https://lk.ex-garant.ru/inc/barcode/barcode.php?encode=CODE39&bdata={{ $order['customFields']['exg_id'] }}&height=70&width=200scale=1bgcolor=FFFFFFcolor=000000&type=png&text=0">
            </div>
            <div class="d11">{{ $order['delivery']['address']['index'] }}; {{ $order['delivery']['address']['region'] }}
                ; {{ $order['delivery']['address']['city'] }}; {{ $order['delivery']['address']['street'] }},
                д. {{ $order['delivery']['address']['building'] }},
                кв. {{ $order['delivery']['address']['float'] }}</div>
            <div class="d12">Посылка</div>
            <div class="d14"></div>
            <div class="d3">{{ $order['firstName'] }}&nbsp;{{ $order['lastName'] }}</div>
        </div>
    </div>
@elseif($order['delivery']['service']['code'] == 'courier')
    <div class="label">
        <div class="bb">
            <div class="d1">
                <div class="d1n">{{ $order['customFields']['exg_id'] }}&nbsp;<span
                        class="con">{{ $order['number'] }}</span></div>
                <div class="d1cu">ИП Антипин Е.А.</div>
            </div>
            <div class="d2"><b>{{ date('d.m.y',strtotime($order['delivery']['date'])) }}</b><br><span class="time">{{ $order['delivery']['time']['from'] }}-{{ $order['delivery']['time']['to'] }}</span>
            </div>
            <div class="d10">
                <img
                    src="https://lk.ex-garant.ru/inc/barcode/barcode.php?encode=CODE39&bdata={{ $order['customFields']['exg_id'] }}&height=70&width=200scale=1bgcolor=FFFFFFcolor=000000&type=png&text=0">
            </div>
            <div class="d11">{{ $order['phone'] }}, {{ $order['email'] }}
                ; {{ $order['delivery']['address']['text'] }}</div>
            @php
                $q = 0;
                $w = 0;
                foreach ($order['items'] as $item) {
                    $q += $item['quantity'];
                }
                $w = $q * 0.3;
            @endphp
            <div class="d9"><b><i>{{ $w }}</i></b><span class="cu"> кг</span></div>
            <div class="d5">Ч</div>
            @if(strpos($order['delivery']['address']['city'],'Москва') !== false)
            <div class="d6">Мск</div>
            @elseif(strpos($order['delivery']['address']['city'],'Санкт-Петербург') !== false)
            <div class="d6">Спб</div>
            @else
            <div class="d6">-</div>
            @endif
            <div class="d7">1/1</div>
        </div>
    </div>
@elseif($order['delivery']['service']['code'] == 'boxberry')
    <div class="label">
        <div class="bb">
            <div class="d1">
                <div class="d1n">{{ $order['customFields']['exg_id'] }}&nbsp;<span
                        class="con">{{ $order['number'] }}</span></div>
                <div class="d1cu">ИП Антипин Е.А.</div>
            </div>
            <div class="d2"><b>{{ date('d.m.y',strtotime($order['delivery']['date'])) }}</b><br><span class="time">{{ $order['delivery']['time']['from'] }}-{{ $order['delivery']['time']['to'] }}</span>
            </div>
            <div class="d10">
                <img
                    src="https://lk.ex-garant.ru/inc/barcode/barcode.php?encode=CODE39&bdata={{ $order['customFields']['exg_id'] }}&height=70&width=200scale=1bgcolor=FFFFFFcolor=000000&type=png&text=0">
            </div>
            <div class="d11">{{ $order['phone'] }}, {{ $order['email'] }}
                ; {{ $order['delivery']['address']['text'] }}</div>
            @php
                $q = 0;
                $w = 0;
                foreach ($order['items'] as $item) {
                    $q += $item['quantity'];
                }
                $w = $q * 0.3;
            @endphp
            <div class="d9"><b><i>{{ $w }}</i></b><span class="cu"> кг</span></div>
            <div class="d5">ПВЗ</div>
            <div class="d6">Рег</div>
            <div class="d7">1/1</div>
        </div>
    </div>
</body>
</html>
@endif
