<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentShowController extends Controller
{
    // public function index(){
    //     return view('products.payment_show');
    // }
    public function showPaymentDetails($customerId, $productId)
{
    // Fetch payment details with associated customer, product, quantity data, and per_unit_price
    $payments = DB::table('payment')
        ->join('customers', 'payment.customer_id', '=', 'customers.id')
        ->join('products', 'payment.product_id', '=', 'products.id')
        ->join('buyproduct', 'payment.product_id', '=', 'buyproduct.product_id') // Join with the buyproduct table for product_qty
        ->select(
            'payment.due_payment',
            'payment.new_payment',
            'customers.name as customer_name',
            'products.product_name as product_name',
            'products.per_unit_price', // Add per_unit_price from products table
            'buyproduct.product_qty' // Add product_qty from buyproduct table
        )
        ->where('payment.customer_id', $customerId)
        ->where('payment.product_id', $productId)
        ->get();

    // Check if payments exist
    if ($payments->isEmpty()) {
        return redirect()->route('some_default_route')->with('error', 'No payment details found for the given customer and product.');
    }

    // Return the view with payment details
    return view('products.payment_show', compact('payments'));
}
}
