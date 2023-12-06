<?php

namespace App\Services;

use App\Models\MessageKh;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageKhServices
{
    public function getAllMessageKh()
    {
        $messageskh = MessageKh::orderBy('id', 'ASC')->paginate(10);
        return $messageskh;
    }

    

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $message = MessageKh::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $message;
    }
}
