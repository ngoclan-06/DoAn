<?php

namespace App\Services;

use App\Models\blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogServices
{
    public function getAllBlog()
    {

        $blog = blog::orderBy('id', 'ASC')->paginate(10);
        return $blog;
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
                while (file_exists("image/blog/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/blog', $image);
            }
        }
        try {
            DB::beginTransaction();

            $blog = blog::create([
                'name' => $request->name,
                'content' => $request->content,
                'status' => $status,
                'image' => $image,
                'user_id' => Auth()->user()->id,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $blog;
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
                    while (file_exists("image/blog/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/blog', $image);
                }
            }
        } else {
            $blog = blog::find($id);
            $image = $blog->image;
        }
        try {
            DB::beginTransaction();

            $blog = blog::find($id);
            $blog->update([
                'name' => $request->name,
                'content' => $request->content,
                'status' => $status,
                'image' => $image,
            ]);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $blog;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $blog = blog::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $blog;
    }
}
