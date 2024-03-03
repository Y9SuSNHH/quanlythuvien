<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class CartController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cart_acesss'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $carts = session()->get('carts', []);

        return view('carts.index', compact('carts'));
    }

    public function store(Product $product)
    {
        abort_if(Gate::denies('cart_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = session()->get('carts', []);

        if (empty($carts[$product->id])) {
            $carts[$product->id] = $product->toArray();

            $carts[$product->id]['quantity'] = 1;
        } else {
            $carts[$product->id] = $product->toArray();
            $carts[$product->id]['quantity']++;
        }
        session()->put('carts', $carts);

        dd(session()->get('carts'));

        return back()->with('status', 'cart-added-product');
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('cart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = session()->get('carts'.$product->id, []);

        dd($carts);
        return back();
    }
}
