<?php

namespace App\Services;

use App\Models\categories;
use App\Models\products;
use App\Models\sub_categories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryServices
{
    public function getAllCategory()
    {

        $categories = categories::orderBy('id', 'ASC')->paginate(10);
        return $categories;
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
                while (file_exists("image/category/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/category', $image);
            }
        }
        try {
            DB::beginTransaction();

            $category = categories::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $status,
                'image' => $image,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $category;
    }

    public function update(Request $request, $id)
    {
        if ($request->status === 'Còn bánh') {
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
                    while (file_exists("image/category/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/category', $image);
                }
            }
        } else {
            $category = categories::find($id);
            $image = $category->image;
        }
        try {
            DB::beginTransaction();

            $category = categories::find($id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $status,
                'image' => $image,
            ]);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        // dd($category);
        return $category;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $category = categories::find($id);
            if ($category->subCategories()->exists()) {
                return false;
            } else {
                $category->delete();
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $category;
    }
}
