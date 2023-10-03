<?php

namespace App\Services;

use App\Models\products;
use App\Models\sub_categories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategoryServices
{
    public function getAllCategory()
    {

        $subcategory = sub_categories::orderBy('id', 'ASC')->paginate(10);
        return $subcategory;
    }

    public function store(Request $request)
    {
        if ($request->status == 'Active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $image = $request->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                $image = Str::random(5) . "_" . $filename;
                while (file_exists("image/subcategory/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/subcategory', $image);
            }
        }
        try {
            DB::beginTransaction();

            $subcategory = sub_categories::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $status,
                'image' => $image,
                'categories_id' => $request->parent_category,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $subcategory;
    }

    public function update(Request $request, $id)
    {
        if ($request->status == 'Active') {
            $status = 1;
        } else {
            $status = 0;
        }
        if ($request->image != null) {
            $image = $request->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                    $image = Str::random(5) . "_" . $filename;
                    while (file_exists("image/subcategory/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/subcategory', $image);
                }
            }
        } else {
            $subcategory = sub_categories::find($id);
            $image = $subcategory->image;
        }
        try {
            DB::beginTransaction();

            $subcategory = sub_categories::find($id);
            $subcategory->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $status,
                'image' => $image,
                'parent_category' => $request->parent_category,
            ]);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $subcategory;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $subcategory = sub_categories::find($id);
            if ($subcategory->products()->exists()) {
                return false;
            } else {
                $subcategory->delete();
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $subcategory;
    }
}
