<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Constants\OrderStatusConstant;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

final class OrderController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $query = Order::with(['confirmable', 'createdUser', 'products']);
        if (Gate::denies('order_management_access')) {
            $query->where('created_user_id', auth()->user()->id);
        }
        $orders = $query->get()->sortBy('status');

        return view('orders.index', compact('orders'));
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $carts = session()->get('carts', []);

        $createdUser   = auth()->user();
        $createdUserId = $createdUser?->id;

        $order = Order::query()->create([
            'created_user_id' => $createdUserId,
            'status'          => OrderStatusConstant::NEW,
        ]);

        $productIds = Arr::pluck($carts, 'id');
        $order->products()->sync($productIds);
        session()->forget(['carts']);

        return redirect()->route('orders.index')->with('status', 'ordered-products');
    }

    public function show(Order $order): View
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return view('orders.edit', compact('order'));
    }

    public function destroy(Order $order): \Illuminate\Http\RedirectResponse
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($order->canDelete()) {
            $order->delete();
        }

        return back();
    }

    public function update(Order $order, Request $request): \Illuminate\Http\RedirectResponse
    {
        $status     = $request->get('status');

        if ($status) {
            if ($status == OrderStatusConstant::SHIPPED) {
                if ($order->products->where('quantity', 0)->first()) {
                    return back()->with('order-products-unshipped');
                }

                foreach ($order->products as $product) {
                    /* @var Product $product */
                    --$product->quantity;
                    $product->save();
                }
            }
            if ($status == OrderStatusConstant::COMPLETED) {
                foreach ($order->products as $product) {
                    /* @var Product $product */
                    ++$product->quantity;
                    $product->save();
                }
            }
        }

        $order->fill($request->only(['status', 'rent_no_date', 'note']))->save();

        return redirect()->route('orders.index')->with('order-products-completed');
    }
}
