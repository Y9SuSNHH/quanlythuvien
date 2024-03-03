<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

final class CartController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('cart_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $carts = session()->get('carts', []);

        return view('carts.index', compact('carts'));
    }

    public function store(Product $product): \Illuminate\Http\RedirectResponse
    {
        abort_if(Gate::denies('cart_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = session()->get('carts', []);

        $carts[] = $product;

        session()->put('carts', $carts);

        return back()->with('status', 'cart-added-product');
    }

    public function destroy($key): \Illuminate\Http\RedirectResponse
    {
        abort_if(Gate::denies('cart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = session()->get('carts', []);
        Arr::forget($carts, $key);
        session()->put('carts', $carts);
        return back();
    }
}
