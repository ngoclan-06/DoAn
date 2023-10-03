<?php

namespace App\Services;

use App\Models\categories;
use App\Models\order;
use App\Models\sub_categories;
use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeAdminServices
{
    public function countCategories()
    {
        $conutCategories = Categories::count();

        if ($conutCategories) {
            return $conutCategories;
        }
        return 0;
    }
    public function countSubCategories()
    {
        $conutSubCategories = Sub_categories::count();

        if ($conutSubCategories) {
            return $conutSubCategories;
        }
        return 0;
    }
    public function countProducts()
    {
        $conutProducts = products::count();

        if ($conutProducts) {
            return $conutProducts;
        }
        return 0;
    }

    public function countOrder()
    {
        $countOrder = order::where('status', 'delivered')->whereNull('deleted_at')->count();

        if ($countOrder) {
            return $countOrder;
        }
        return 0;
    }

    public function countAccountAdmin()
    {
        $countAdmin = User::where('role', '1')->count();
        if ($countAdmin) {
            return $countAdmin;
        }
        return 0;
    }

    public function updateProfile(Request $request, $id)
    {
        if ($request->image != null) {
            $image = $request->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                    $image = Str::random(5) . "_" . $filename;
                    while (file_exists("image/user/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/user', $image);
                }
            }
        }else{
            $profile = User::find($id);
            $image = $profile->image;
        }
        try {
            DB::beginTransaction();
            $profile = User::find($id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'image' => $image,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $profile;
    }
}
