<?php

namespace App\Http\Controllers;

use App\Services\CategoryServices;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\categories;
use Exception;

class CategoryController extends Controller
{
    protected $categoryServices;
    public function __construct(CategoryServices $categoryServices)
    {
        $this->categoryServices = $categoryServices;
    }

    public function index()
    {
        $categories = $this->categoryServices->getAllCategory();

        return view('backend.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(CreateCategoryRequest $createCategoryRequest)
    {
        try {
            $result = $this->categoryServices->store($createCategoryRequest);
            if ($result) {
                return redirect()->route('category')->with('success', 'Thêm mới danh mục thành công.');
            } else {
                return back()->with('error', 'Thêm mới danh mục không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $category = categories::find($id);
        return view('backend.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $result = $this->categoryServices->update($request, $id);
            if ($result) {
                return redirect()->route('category')->with('success', 'Bạn đã cập nhật thông tin danh mục thành công.');
            } else {
                return redirect()->back()->with('error', 'Cập nhật thông tin danh mục thất bại.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->categoryServices->delete($id);
            if ($result) {
                return redirect()->route('category')->with('success', 'Xóa danh mục thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin danh mục không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
}
