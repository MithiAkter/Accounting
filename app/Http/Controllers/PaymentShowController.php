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
        // Fetch the payment, customer, and product details
        $payments = DB::table('payment')
            ->join('customers', 'payment.customer_id', '=', 'customers.id')
            ->join('products', 'payment.product_id', '=', 'products.id')
            ->select(
                'payment.due_payment',
                'payment.new_payment',
                'customers.name as customer_name',
                'products.product_name as product_name'  // Ensure this matches the actual column name in the products table
            )
            ->where('payment.customer_id', $customerId)
            ->where('payment.product_id', $productId)
            ->get();
    
        // Pass the data to the view
        return view('products.payment_show', compact('payments'));
    }

}
