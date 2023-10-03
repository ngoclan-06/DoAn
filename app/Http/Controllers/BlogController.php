<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\blog;
use App\Services\BlogServices;
use Exception;

class BlogController extends Controller
{
    protected $blogServices;
    public function __construct(BlogServices $blogServices)
    {
        $this->blogServices = $blogServices;
    }

    public function index()
    {
        $blogs = $this->blogServices->getAllBlog();

        return view('backend.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.blog.create');
    }
    public function store(CreateBlogRequest $request)
    {
        //dd($request);
        try {
            $result = $this->blogServices->store($request);
            if ($result) {
                return redirect()->route('blog')->with('success', 'Bạn đã thêm mới bài viết thành công.');
            } else {
                return redirect()->back()->with('error', 'Thêm mới đã thất bại.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $blog = blog::find($id);

        return view('backend.blog.edit', compact('blog'));
    }
    public function update(UpdateBlogRequest $request, $id)
    {
        try {
            $result = $this->blogServices->update($request, $id);
            if ($result) {
                return redirect()->route('blog')->with('success', 'Bạn đã sửa đổi thông tin bài viết thành công.');
            } else {
                return redirect()->back()->with('error', 'Bạn đã sửa đổi thông tin bài viết không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
    public function delete($id)
    {
        try {
            $result = $this->blogServices->delete($id);
            if ($result) {
                return redirect()->route('blog')->with('success', 'Xóa banner thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin banner không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
}
