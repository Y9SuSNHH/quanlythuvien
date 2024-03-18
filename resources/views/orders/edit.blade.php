@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.cart.title') }}
            <a class="btn btn-default" href="{{ route('orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    @can('order_management_access')
                        @if($order->can_completed)
                            <form action="{{ route('orders.update', $order->id) }}" method="POST"
                                  style="display: inline-block;">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="status"
                                       value="{{\App\Constants\OrderStatusConstant::COMPLETED}}">
                                <input type="submit" class="btn btn-success" value="Đã trả hàng">
                            </form>
                        @endif
                        @if($order->can_shipped)
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="form-inline">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label class="required"
                                           for="no_rent_date">{{ trans('cruds.order.fields.no_rent_date') }}</label>
                                    <input type="number" class="form-control mx-sm-3" required step="1"
                                           id="no_rent_date" name="no_rent_date">
                                    <input type="hidden" name="status"
                                           value="{{\App\Constants\OrderStatusConstant::SHIPPED}}">
                                    <input type="submit" class="btn btn-info" value="Đã nhận hàng">
                                </div>
                            </form>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @foreach($order->products as $product)
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.product.title') }}
            </div>

            <div class="card-body">
                <div class="form-group">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.id') }}
                            </th>
                            <td>
                                {{ $product->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.name') }}
                            </th>
                            <td>
                                {{ $product->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.description') }}
                            </th>
                            <td>
                                {{ $product->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.quantity') }}
                            </th>
                            <td>
                                {{ $product->quantity }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.category') }}
                            </th>
                            <td>
                                @foreach($product->categories as $key => $category)
                                    <span class="label label-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        {{--                    <tr>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.product.fields.tag') }}--}}
                        {{--                        </th>--}}
                        {{--                        <td>--}}
                        {{--                            @foreach($product->tags as $key => $tag)--}}
                        {{--                                <span class="label label-info">{{ $tag->name }}</span>--}}
                        {{--                            @endforeach--}}
                        {{--                        </td>--}}
                        {{--                    </tr>--}}
                        <tr>
                            <th>
                                {{ trans('cruds.product.fields.photo') }}
                            </th>
                            <td>
                                @if($product->photo)
                                    <a href="{{ $product->photo->getUrl() }}" target="_blank"
                                       style="display: inline-block">
                                        <img src="{{ $product->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endsection
