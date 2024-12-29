<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesRequest;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private $productRepo, $categoryRepo, $salesRepo, $customerRepo;

    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo, SalesRepository $salesRepo, CustomerRepository $customerRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->salesRepo = $salesRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index(Request $request)
    {
        try {
            $categories = $this->categoryRepo->getCategory();
            $customers = $this->customerRepo->getCustomers();
            $term = $request->input('search');
            $products = $this->productRepo->getProducts()
                ->select('products.id', 'products.name', 'products.image', 'products.qty', 'products.price', 'products.category_id')
                ->where('products.name', 'LIKE', "%{$term}%")
                ->orWhere('products.code', 'LIKE', "%{$term}%")
                ->limit(10)
                ->get();
            if ($request->ajax()) {
                return response()->json([
                    'products' => $products
                ]);
            }
            // dd($products);
            return view('sales.index', ['products' => $products, 'categories' => $categories,'customers'=>$customers]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong', 'type' => 'error']);
        }
    }

    public function storeSales(SalesRequest $request)
    {
        try {
            $data = $this->salesRepo->storeSalesProduct($request->validated());
            return response()->json(['message' => 'Sales order added successfully!', 'type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }
}
