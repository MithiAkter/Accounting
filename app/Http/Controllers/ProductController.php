<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $product=DB::table('products')->get();
        // ->join('categories','products.category_id','categories.id')->join('brands','products.brand_id','brands.id')
        // ->select('products.*','categories.category_name','brands.brand_name')
        // ->get();
        // return response()->json($product);
        return view ('products.index',compact('product'));
        // return view ('products.index');
    }
    public function create(){
        // $category=DB::table('categories')->get();
        // $brand=DB::table('brands')->get();
        // return view('products.create',compact('category','brand'));
        return view('products.create');
    }
    //subcattegory collected by ajax request
    // public function GetSubcat($category_id){
    //     $cat=DB::table("subcategories")->where("category_id",$category_id)->get();
    //     return json_encode($cat);
    // }
    public function store(Request $request){

        // dd($request->all());
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_qty']=$request->product_qty;
        $data['sell_qty']=$request->sell_qty;
        $data['per_unit_price']=$request->per_unit_price;

        if ($request->hasFile('product_img')) {
            $product_img = $request->file('product_img');
            $filename = time() . "_Products." . $product_img->getClientOriginalExtension();
            $path = 'public/media/product';
            $product_img->move(public_path($path), $filename);
            $fullPath = $path . '/' . $filename;
            $data['product_img'] = $fullPath;
        }
        $product=DB::table('products')->insert($data);
        $notification = array(
            'messege'=>'Product Inserted Successfully',
            'alert-type'=>'success'
             );
            return Redirect()->back()->with($notification);
   
    }
    public function DeleteProduct($id){
        $product=DB::table('products')->where('id',$id)->first();
        $image1=$product->product_img;
        unlink($image1);
        DB::table('products')->where('id',$id)->delete();
        $notification=array(
            'message'=>'Product Deleted Successfully',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function ViewProduct($id){
        $product=DB::table('products')
                ->where('products.id',$id)
                ->first();
                // ->join('categories','products.category_id','categories.id')
                // ->join('brands','products.brand_id','brands.id')
                // ->join('subcategories','products.subcategory_id','subcategories.id')
                // ->select('products.*','categories.category_name','brands.brand_name',
                //     'subcategories.subcategory_name')
                // ->where('products.id',$id)
                // ->first();
        // return response()->json($product);
        // return view ('admin.product.show_product',compact('product'));
        return view ('products.show');

    }
    public function EditProduct($id){
        $product=DB::table('products')->where('id',$id)->first();
        // return response()->json($product);;
        return view('products.edit',compact('product'));
    }
    

    public function UpdateProduct(Request $request, $id)
    {
        // dd($request->all());
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_qty']=$request->product_qty;
        $data['sell_qty']=$request->sell_qty;
        $data['per_unit_price']=$request->per_unit_price;
    
        // Check and handle image uploads
        if ($request->hasFile('product_img')) {
            $product_img = $request->file('product_img');
            $filename = time() . "_Products." . $product_img->getClientOriginalExtension();
            $path = 'public/media/product';
    
            // Move the image and get the full path
            $product_img->move(public_path($path), $filename);
            $data['product_img'] = $path . '/' . $filename;
    
            // Optional: Delete the old image if exists
            $oldImage = DB::table('products')->where('id', $id)->value('product_img');
            if ($oldImage && file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }
    
        // Update the database record
        $update = DB::table('products')->where('id', $id)->update($data);
    
        if ($update !== false) {
            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.product')->with($notification);
        } else {
            $notification = array(
                'message' => 'Failed to Update Product',
                'alert-type' => 'error'
            );
            return Redirect()->route('all.product')->with($notification);
        }
    }

}
