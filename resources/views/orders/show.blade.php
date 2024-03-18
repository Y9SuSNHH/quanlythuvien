@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.order.title_singular') }}
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('orders.index') }}">
                        {{ trans('global.back_to_list') }} quản lý
                    </a>
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
{{--                        <tr>--}}
{{--                            <th>--}}
{{--                                {{ trans('cruds.product.fields.quantity') }}--}}
{{--                            </th>--}}
{{--                            <td>--}}
{{--                                {{ $product->quantity }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
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
