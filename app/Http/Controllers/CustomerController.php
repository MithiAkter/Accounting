<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::latest()->get();
        return view('customers.index', compact('customer'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();
            // Toastr::success('Customer Section Added Successfully', 'Success');
            // return redirect()->back();
            $notification = array(
                'messege'=>'Customer Added Successfully',
                'alert-type'=>'success'
                 );
                return Redirect()->back()->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $customer = Customer::find($id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->status = $request->status;
            $customer->save();
            $notification = array(
                'messege'=>'Customer Updated Successfully',
                'alert-type'=>'success'
                 );
                return Redirect()->back()->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::find($id);
            $customer->delete();
            $notification = array(
                'messege'=>'Customer Deleted Successfully',
                'alert-type'=>'success'
                 );
                return Redirect()->back()->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
