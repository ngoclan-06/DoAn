<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\products;
use App\Models\sub_categories;
use App\Services\ProductServices;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $productServices;
    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    public function index()
    {
        $products = $this->productServices->getAllProducts();
        return view('backend.product.index', compact('products'))->with('i');
    }
    public function create()
    {
        $subcategories = sub_categories::where('status', 1)->get();
        return view('backend.product.create', compact('subcategories'));
    }

    public function store(CreateProductsRequest $request)
    {
        try {

            $result = $this->productServices->store($request);
            if ($result) {
                return redirect()->route('products')->with('success', 'Bạn đã thêm mới sản phẩm thành công.');
            } else {
                return redirect()->back()->with('error', 'Thêm sản phẩm thất bại.');
            }
        } catch (Exception $ex) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $product = products::find($id);
        $subcategories = sub_categories::all();
        return view('backend.product.edit', compact('product', 'subcategories'));
    }

    public function update(UpdateProductsRequest $request, $id)
    {
        try {
            $result = $this->productServices->update($request, $id);
            if ($result) {
                return redirect()->route('products')->with('success', 'Bạn đã sửa sản phẩm thành công.');
            } else {
                return redirect()->back()->with('error', 'Sửa sản phẩm thất bại.');
            }
        } catch (Exception $ex) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->productServices->delete($id);
            if ($result) {
                return redirect()->route('products')->with('success', 'Xóa sản phẩm thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin sản phẩm không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $result = $this->productServices->deleteSelected($request->all());
            if ($result) {
                return redirect()->route('products')->with('success', 'Xóa sản phẩm thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin sản phẩm không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function getProductsexpired()
    {
        $products = $this->productServices->getProductsexpired();
        return view('backend.product.index', compact('products'))->with('i');
    }

    public function getProductOutOfStock()
    {
        $products = $this->productServices->getProductOutOfStock();
        return view('backend.product.index', compact('products'))->with('i');
    }

    public function searchProduct(Request $request)
    {
        $products = products::orwhere('name', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        return view('backend.product.index', compact('products'))->with('i');
    }

    public function getProductSurvive()
    {
        $products = $this->productServices->getProductSurvive();
        return view('backend.product.index', compact('products'))->with('i');
    }
}
