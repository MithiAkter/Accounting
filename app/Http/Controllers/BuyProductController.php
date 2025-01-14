<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class BuyProductController extends Controller
{
    public function buyProduct(Request $request)
    {
        $customers = Customer::latest()->get();
        // $products = Product::latest()->get();
        $product = Product::where('id', $request->id)->first();
        return view('products.buy', compact('customers', 'product'));
    
}

    // }
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_qty' => 'required|integer|min:1', // Ensure product_qty is at least 1
            'customer_id' => 'required|exists:customers,id', // Ensure a valid customer ID
            'product_id' => 'required|exists:products,id', // Ensure a valid product ID
            'payment' => 'required|numeric|min:0', // Ensure payment is non-negative
        ], [
            'product_qty.min' => 'Enter Sufficient Product Value', // Custom error message
        ]);
    
        $product = DB::table('products')->where('id', $request->product_id)->first();
    
        if ($product) {
            // Calculate the new stock after the order
            $new_qty = $product->product_qty - $request->product_qty;
    
            // Check if sufficient stock is available
            if ($new_qty >= 0) {
                // Update the product quantity in stock
                DB::table('products')->where('id', $request->product_id)->update(['product_qty' => $new_qty]);
    
                // Calculate the total price and the due payment
                $total_price = $product->per_unit_price * $request->product_qty;
                $due_payment = $total_price - $request->payment;
    
                // Insert the buyproduct record
                $data = [
                    'product_id' => $request->product_id,
                    'customer_id' => $request->customer_id,
                    'product_qty' => $request->product_qty,
                    'payment' => $request->payment,
                    'due_payment' => $due_payment, // Store the calculated due payment
                ];
               DB::table('buyproduct')->insert($data);
                $data1 = [
                    'product_id' => $request->product_id,
                    'customer_id' => $request->customer_id,
                    'new_payment' => $request->payment,
                    'due_payment' => $due_payment, // Store the calculated due payment
                ];
                DB::table('payment')->insert($data1);
    
                $notification = [
                    'messege' => 'Buy Product Inserted Successfully',
                    'alert-type' => 'success',
                ];
            } else {
                // If insufficient stock, send an error notification
                $notification = [
                    'messege' => 'Insufficient stock available',
                    'alert-type' => 'error',
                ];
            }
        } else {
            // If product not found, send an error notification
            $notification = [
                'messege' => 'Product not found',
                'alert-type' => 'error',
            ];
        }
    
        return Redirect()->route('all.product')->with($notification)->with('updated_stock', $new_qty ?? 0);
    }

    public function index()
{
    // Get the buyproduct records, along with related product and customer data
    $buyproducts = DB::table('buyproduct')
        ->join('products', 'buyproduct.product_id', '=', 'products.id')
        ->join('customers', 'buyproduct.customer_id', '=', 'customers.id')
        ->select('buyproduct.*', 'products.product_name', 'products.per_unit_price', 'customers.name')
        ->get();

    // Loop through each record and calculate the due payment
    foreach ($buyproducts as $buyproduct) {
        // Calculate the total price for the product
        $total_price = $buyproduct->per_unit_price * $buyproduct->product_qty;
        
        // Calculate the due payment
        $buyproduct->due_payment = $total_price - $buyproduct->payment;
    }

    // Pass the buyproducts collection to the view
    return view('products.index_buyproduct', compact('buyproducts'));
}

    

public function paymentIndex()
{
    // Get all products and customers to display in the dropdowns
    $products = Product::all();
    $customers = Customer::all();

    return view('products.payment', compact('products', 'customers'));
}

public function processPayment(Request $request)
{
    $request->validate([
        'payment_new' => 'required|numeric|min:0',
        'product_id' => 'required|exists:products,id',
        'customer_id' => 'required|exists:customers,id',
    ]);

    $product = Product::find($request->product_id);
    $customer = Customer::find($request->customer_id);

    $buyProduct = DB::table('buyproduct')
        ->where('product_id', $request->product_id)
        ->where('customer_id', $request->customer_id)
        ->first();

    if ($buyProduct) {
        $totalPrice = $product->per_unit_price * $buyProduct->product_qty;
        $previousDuePayment = $totalPrice - $buyProduct->payment;

        if ($request->payment_new <= $previousDuePayment && $request->payment_new > 0) {
            $newDuePayment = $previousDuePayment - $request->payment_new;

            DB::table('buyproduct')
                ->where('id', $buyProduct->id)
                ->update([
                    'payment' => $buyProduct->payment + $request->payment_new,
                    'due_payment' => $newDuePayment,
                ]);

            // Insert into the `payment` table
            DB::table('payment')->insert([
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'due_payment' => $newDuePayment,
                'new_payment' => $request->payment_new,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('message', 'Payment processed successfully!');
        } else {
            return redirect()->back()->with('error', 'The payment exceeds the due amount or is invalid!');
        }
    }

    return redirect()->back()->with('error', 'Buy product record not found!');
}

public function getDuePayment(Request $request)
{
    // Get the product and customer
    $product = Product::find($request->product_id);
    $customer = Customer::find($request->customer_id);

    // Fetch the buyproduct record
    $buyproduct = DB::table('buyproduct')
        ->where('product_id', $request->product_id)
        ->where('customer_id', $request->customer_id)
        ->first();

    if ($buyproduct) {
        $total_price = $product->per_unit_price * $buyproduct->product_qty;
        $due_payment = $total_price - $buyproduct->payment;

        return response()->json([
            'due_payment' => number_format($due_payment, 2),
        ]);
    }


    return response()->json(['due_payment' => 0]);
}


}
