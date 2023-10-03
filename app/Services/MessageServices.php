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
        $messages = Message::orderBy('id', 'ASC')->paginate(10);
        return $messages;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $messages = Message::create([
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'phone' => $request->phone,
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
