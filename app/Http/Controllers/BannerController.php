<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\banners;
use App\Services\BannerServices;
use Exception;

class BannerController extends Controller
{
    protected $bannerServices;
    public function __construct(BannerServices $bannerServices)
    {
        $this->bannerServices = $bannerServices;
    }

    public function index()
    {
        $banners = $this->bannerServices->getAllBanners();

        return view('backend.banner.index', compact('banners'));
    }

    public function create()
    { 
        return view('backend.banner.create');
    }
    public function store(CreateBannerRequest $request)
    {
        try {
            $result = $this->bannerServices->store($request);
            if ($result) {
                return redirect()->route('banner')->with('success', 'Bạn đã thêm mới tấm banner thành công.');
            } else {
                return redirect()->back()->with('error', 'Thêm mới đã thất bại.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $banner = banners::find($id);

        return view('backend.banner.edit', compact('banner'));
    }
    public function update(UpdateBannerRequest $request, $id)
    {
        try {
            $result = $this->bannerServices->update($request, $id);
            if ($result) {
                return redirect()->route('banner')->with('success', 'Bạn đã sửa đổi thông tin banner thành công.');
            } else {
                return redirect()->back()->with('error', 'Bạn đã sửa đổi thông tin banner không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
    public function delete($id)
    {
        try {
            $result = $this->bannerServices->delete($id);
            if ($result) {
                return redirect()->route('banner')->with('success', 'Xóa banner thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin banner không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
}
