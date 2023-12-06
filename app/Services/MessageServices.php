<?php

namespace App\Services;

use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageServices
{
    public function getAllMessage()
    {
        $messages = Message::with('user')->get();
        return $messages;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $messages = Message::create([
                'name' => $request->name,
                'image' => $request->image,
                'user_id' => $request->user_id,
                'status' => $request->status,
                'message' => $request->message
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $messages;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $message = Message::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $message;
    }
}
