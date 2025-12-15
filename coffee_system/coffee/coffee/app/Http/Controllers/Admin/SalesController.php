<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        // Base query: only completed orders
        $baseOrders = Order::with('product')->where('status', 'completed');

        // Today's sales
        $todaySales = $baseOrders->whereDate('created_at', Carbon::today())
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Weekly revenue
        $weeklyRevenue = $baseOrders->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Monthly revenue
        $monthlyRevenue = $baseOrders->whereMonth('created_at', Carbon::now()->month)
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Total orders (all completed)
        $totalOrders = $baseOrders->count();

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $baseOrders->get()->sum(function($order) {
            return $order->product->price * $order->quantity;
        }) / $totalOrders : 0;

        return view('admin.stock.sales', compact(
            'todaySales',
            'weeklyRevenue',
            'monthlyRevenue',
            'totalOrders',
            'averageOrderValue'
        ));
    }
}
/* LAHI NI SYA ELOQUENT QUERY NI SIYA ANG NAAS BABAW FILTERING THE COLLECTION ANG PAMAAGI SA PAG KUAN SA SALE & REVENUE
public function index()
    {
        // Base query: only completed orders
        $baseOrders = Order::with('product')->where('status', 'completed');

        // Today's sales
        $todaySales = $baseOrders->whereDate('created_at', Carbon::today())
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Weekly revenue
        $weeklyRevenue = $baseOrders->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Monthly revenue
        $monthlyRevenue = $baseOrders->whereMonth('created_at', Carbon::now()->month)
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });

        // Total orders (all completed)
        $totalOrders = $baseOrders->count();

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $baseOrders->get()->sum(function($order) {
            return $order->product->price * $order->quantity;
        }) / $totalOrders : 0;

        return view('admin.stock.sales', compact(
            'todaySales',
            'weeklyRevenue',
            'monthlyRevenue',
            'totalOrders',
            'averageOrderValue'
        ));
*/