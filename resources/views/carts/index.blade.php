@extends('layouts.admin')
@section('content')
    @can('product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.product.title_singular') }} {{ trans('global.list') }}
        </div>
        <div class="card-body">
            @can('order_create')
                <form action="{{ route('orders.store') }}" method="POST" class="mb-2">
                    @method('POST')
                    @csrf
                    <input type="submit" class="btn btn btn-success" value="Đặt sách">
                </form>
            @endcan
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $key => $cart)
                        <tr data-entry-id="{{ $key }}">
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                @if($cart->photo)
                                    <a href="{{ $cart->photo->getUrl() }}" target="_blank"
                                       style="display: inline-block">
                                        <img src="{{ $cart->photo->getUrl('thumb') }}" alt="">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $cart->name ?? '' }}
                            </td>
                            <td>
                                @can('cart_delete')
                                    <form action="{{ route('carts.destroy', $key) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn btn-danger" value="{{ trans('global.delete') }} khỏi {{ trans('cruds.cart.title_singular') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
