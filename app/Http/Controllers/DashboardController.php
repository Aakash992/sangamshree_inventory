<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalProduct = Product::count();
            $totalCustomer = Customer::count();
            $data = [
                'totalProduct' => $totalProduct,
                'totalCustomer' => $totalCustomer
            ];
            return view('dashboard.index')->with(['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }
}
