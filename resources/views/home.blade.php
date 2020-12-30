@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @foreach(json_decode(\App\Http\Controllers\OrderController::getOrders(),true) as $order)
                    <form action="{{route('order')}}" method="get">
                        <input type="text" value="{{ $order['id'] }}" style="display: none" name="id">
                        <button class="card" style="width: 15rem;height: 2rem;font-size: 1rem;">
                            {{$order['number']}}
                        </button>
                        <br>
                    </form>
                @endforeach
            </div>

            <div class="col col-md-8">
                @if(isset($_GET['id']))
                    <div class="card">
                        @php
                            $order = \App\Http\Controllers\OrderController::getOrderCard($_GET['id']);
                            $lastName = isset($order['lastName']) ? $order['lastName'] : '';
                            $firstName = isset($order['firstName']) ? $order['firstName'] : '';
                            $patronymic = isset($order['patronymic']) ? $order['patronymic'] : '';
                            $comment = isset($order['managerComment']) ? $order['managerComment'] : '';
                            $name = $lastName . " " . $firstName . " " . $patronymic;
                            $deliveryType =  $order['delivery']['name'];
                        @endphp
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    @if($comment != '')
                                        <p>Комментарий менеджера:
                                        <p>{{$comment}} </p></p>
                                    @endif
                                </div>
                                <div class="col">
                                    <div><p><b>Заказ № </b>{{ $order['number'] }}</p>
                                    </div>
                                    <div><p><b>Покупатель: </b>{{ $name }}</p></div>
                                    <div><p><b>Способ доставки: </b>{{ $deliveryType }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <table class="table table-bordered">
                                    @foreach($order['items'] as $item)
                                        <tr>
                                            <td class='product'><img
                                                    src='{{isset( $item['image']) ?  $item['image'] : '' }}'
                                                    alt=''
                                                    width='40px' height='40px'></td>
                                            <td class='product'>{{ $item['offer']['displayName'] }}</td>
                                            <td class='product'>
                                                @foreach($item['properties'] as $property)
                                                    <p>{{$property['name']}} : {{$property['value']}}</p>
                                                @endforeach
                                            </td>
                                            <td class='product'>{{ $item['initialPrice'] }}</td>
                                            <td class='product'>{{ $item['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row">
                                <form action="{{ route('processingOrder') }}" method="get" class="row ">
                                    @csrf
                                    <input type="text" name="id" value="{{$order['id']}}"
                                           style="display: none">
                                    <input type="text" name="site" value="{{$order['site']}}"
                                           style="display: none">
                                    <input type="text" name="track"
                                           value="{{isset($order['delivery']['data']['trackNumber']) ? $order['delivery']['data']['trackNumber'] : ''}}"
                                           style="display: none">

                                    <input type="submit" name="collect" value="Собрать заказ"
                                           id="collectOrder" class="col">
                                    <input type="submit" name="label_sdek " value="Ярлык СДЭК"
                                           id="label_sdek" class="col">

                                    <input type="submit" name="label_garant" value="Ярлык гарант"
                                           id="label_garant" class="col">

                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
