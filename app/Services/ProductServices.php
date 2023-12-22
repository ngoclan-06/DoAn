<?php

namespace App\Services;

use App\Models\cart;
use App\Models\ProductReview;
use App\Models\products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductServices
{
    public function getAllProducts()
    {
        $now = now();
        $products = products::orderBy('id', 'DESC')->where('expiry', '>=', $now)->where('quantity','>', '0')->paginate(10);
    //     $products = products::select('name', DB::raw('SUM(quantity) as total_quantity'))
    // ->where('expiry', '>=', $now)
    // ->groupBy('name')
    // ->orderBy('id', 'DESC')
    // ->paginate(10);

        return $products;

        // $now = now();

        // $products = products::select('*', \DB::raw('SUM(quantity) as total_quantity'))
        //     ->where('expiry', '>=', $now)
        //     ->groupBy('name', 'sub_categories_id')
        //     ->paginate(10);

        // return $products;

    }

    public function store(Request $request)
    {
        // if ($request->hot != null) {
        //     $hot = 1;
        // } else {
        //     $hot = 0;
        // }
        if ($request->status === 'Còn bán') {
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
                while (file_exists("image/product/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/product', $image);
            }
        }
        try {
            DB::beginTransaction();
            $products = products::create([
                'name' => $request->name,
                'price' => $request->price,
                'date_of_manufacture' => $request->date_of_manufacture,
                'expiry' => $request->expiry,
                'quantity' => $request->quantity,
                'description' => $request->description,
                // 'hot' => $hot,
                'status' => $status,
                'image' => $image,
                'sub_categories_id' => $request->sub_categories_id,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $products;
    }

    public function update(Request $request, $id)
    {
        // if ($request->hot != null) {
        //     $hot = 1;
        // } else {
        //     $hot = 0;
        // }
        if ($request->status == 'Còn bán') {
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
                    while (file_exists("image/product/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/product', $image);
                }
            }
        }else{
            $product = products::find($id);
            $image = $product->image;
        }
        try {
            DB::beginTransaction();

            $product = products::find($id);
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'date_of_manufacture' => $request->date_of_manufacture,
                'expiry' => $request->expiry,
                'quantity' => $request->quantity,
                'description' => $request->description,
                // 'hot' => $hot,
                'status' => $status,
                'image' => $image,
                'sub_categories_id' => $request->sub_categories_id,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $product;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $product = products::find($id);

            if ($product->cart()->exists()) {
                return false;
            } else {
                $product->delete();
                ProductReview::where('products_id', $id)->delete();
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $product;
    }
    public function deleteSelected(array  $ids)
    {
        try {
            DB::beginTransaction();

            $deletedIds = [];
            foreach ($ids as $id) {
                $product = products::find($id);
                if ($product->cart()->exists()) {
                    return false;
                } else {
                    $product->delete();
                    $deletedIds[] = $id;
                }
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $deletedIds;
    }
    public function getProductsexpired()
    {
        $now = now();

        $products = products::where('expiry', '<', $now)
            ->orderBy('id', 'DESC')
            ->update(['status' => 0]);

        $updatedProducts = products::where('expiry', '<', $now)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return $updatedProducts;

    }

    public function getProductOutOfStock()
    {
        $products = products::where('quantity', '0')
            ->orderBy('id', 'DESC')
            ->update(['status' => 0]);

        $updatedProducts = products::where('quantity', '0')
            ->orderBy('id', 'DESC')
            ->paginate(10);


        // $products = products::orderBy('id', 'DESC')->where('quantity', '0')->paginate(10);
        return $updatedProducts;
    }

    public function getProductSurvive()
    {
        //tồn theo ngày
        $now = now();
        $products = products::orderBy('id', 'DESC')->where('date_of_manufacture', '<', $now)->where('quantity','>', '0')->paginate(10);
        return $products;
    }
}
