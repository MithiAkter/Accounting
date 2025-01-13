<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\BuyProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyProductController extends Controller
{
    public function buyProduct(Request $request)
    {
        $customers = Customer::latest()->get();
        // $products = Product::latest()->get();
        $product = Product::where('id', $request->id)->first();
        return view('products.buy', compact('customers', 'product'));
    
}
    // public function store(Request $request){

    //     // dd($request->all());
    //     $data=array();
    //     $data['product_id']=$request->product_id;
    //     $data['customer_id']=$request->customer_id;
    //     $data['product_qty']=$request->product_qty;
        
    //     $product=DB::table('buyproduct')->insert($data);
    //     $notification = array(
    //         'messege'=>'Buy Product Inserted Successfully',
    //         'alert-type'=>'success'
    //         );
    //         return Redirect()->back()->with($notification);

    // }
//     public function store(Request $request)
// {

//     $product = DB::table('products')->where('id', $request->product_id)->first();

//     if ($product) {

//         $new_qty = $product->product_qty - $request->product_qty;


//         if ($new_qty >= 0) {

//             DB::table('products')->where('id', $request->product_id)->update(['product_qty' => $new_qty]);


//             $data = [
//                 'product_id' => $request->product_id,
//                 'customer_id' => $request->customer_id,
//                 'product_qty' => $request->product_qty
//             ];
//             DB::table('buyproduct')->insert($data);


//             $notification = array(
//                 'messege' => 'Buy Product Inserted Successfully',
//                 'alert-type' => 'success'
//             );
//         } else {

//             $notification = array(
//                 'messege' => 'Insufficient stock available',
//                 'alert-type' => 'error'
//             );
//         }
//     } else {
       
//         $notification = array(
//             'messege' => 'Product not found',
//             'alert-type' => 'error'
//         );
//     }

    
//     return Redirect()->back()->with($notification);
// }



public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'product_qty' => 'required|integer|min:1', // Ensure product_qty is at least 1
        'customer_id' => 'required|exists:customers,id', // Ensure a valid customer ID
        'product_id' => 'required|exists:products,id', // Ensure a valid product ID
    ], [
        'product_qty.min' => 'Enter Sufficient Product Value', // Custom error message
    ]);

    $product = DB::table('products')->where('id', $request->product_id)->first();

    if ($product) {
        $new_qty = $product->product_qty - $request->product_qty;

        if ($new_qty >= 0) {
            // Update the stock in the database
            DB::table('products')->where('id', $request->product_id)->update(['product_qty' => $new_qty]);

            // Insert the buyproduct record
            $data = [
                'product_id' => $request->product_id,
                'customer_id' => $request->customer_id,
                'product_qty' => $request->product_qty,
                'payment' => $request->payment,
            ];
            DB::table('buyproduct')->insert($data);

            // Prepare success message
            $notification = [
                'messege' => 'Buy Product Inserted Successfully',
                'alert-type' => 'success',
            ];
        } else {
            // Prepare error message if there's not enough stock
            $notification = [
                'messege' => 'Insufficient stock available',
                'alert-type' => 'error',
            ];
        }
    } else {
        // Handle the case if the product does not exist
        $notification = [
            'messege' => 'Product not found',
            'alert-type' => 'error',
        ];
    }

    // Redirect back with notification and pass the updated stock
    return Redirect()->back()->with($notification)->with('updated_stock', $new_qty);
}


    public function index(){
        $buyproducts = DB::table('buyproduct')
        ->join('products','buyproduct.product_id','products.id')
        ->join('customers','buyproduct.customer_id','customers.id')
        ->select('buyproduct.*','products.product_name','products.per_unit_price','customers.name')
        ->get();
        return view('products.index_buyproduct',compact('buyproducts'));
    }
}
