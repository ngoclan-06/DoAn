<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\categories;
use App\Models\sub_categories;
use App\Services\SubCategoryServices;
use Exception;

class SubCategoryController extends Controller
{
    protected $subCategoryServices;

    public function __construct(SubCategoryServices $subCategoryServices)
    {
        $this->subCategoryServices = $subCategoryServices;
    }

    public function index()
    {
        $categories = $this->subCategoryServices->getAllCategory();

        return view('backend.subcategory.index', compact('categories'));
    }

    public function create()
    {
        $category = categories::where('status', 1)->get();
        return view('backend.subcategory.create', compact('category'));
    }

    public function store(CreateSubCategoryRequest $request)
    {
        try {
            $result = $this->subCategoryServices->store($request);
            if ($result) {
                return redirect()->route('subcategory')->with('success', 'Bạn đã thêm mới danh mục thành công.');
            } else {
                return redirect()->back()->with('error', 'Thêm dnah mục thất bại.');
            }
        } catch (Exception $ex) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $subcategory = sub_categories::find($id);
        $categories = categories::all();
        return view('backend.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(UpdateSubCategoryRequest $request, $id)
    {
        try {
            $result = $this->subCategoryServices->update($request, $id);
            if ($result) {
                return redirect()->route('subcategory')->with('success', 'Bạn đã cập nhật thông tin danh mục thành công.');
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
            $result = $this->subCategoryServices->delete($id);
            if ($result) {
                return redirect()->route('subcategory')->with('success', 'Xóa danh mục thành công.');
            } else {
                return redirect()->back()->with('error', 'Không được phép xóa danh mục này.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
}
