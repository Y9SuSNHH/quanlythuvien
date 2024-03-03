<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

final class OrderController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $orders = Order::with(['categories', 'tags', 'media'])->get();

//        dd($orders);
        return view('orders.index', compact('orders'));
    }

    public function store()
    {
//        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        return back()->with('status', 'password-updated');
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        dd($order->confirmable()->exists());
        if ($order->confirmable()->exists()) {
            $order->delete();
        }

        return back();
    }
}
