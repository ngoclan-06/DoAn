<?php

namespace App\Http\Controllers;

use App\Services\MessageServices;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;

class messageController extends Controller
{
    protected $message;
    public function __construct(MessageServices $message)
    {
        $this->message = $message;
    }
    public function index()
    {
        $messages = $this->message->getAllMessage();
        return view('backend.message.index', compact('messages'));
    }
    public function store(MessageRequest $messageRequest)
    {
        $result = $this->message->store($messageRequest);
        if ($result) {
            return back()->with('success', 'Đã gửi phản hồi thành công.');
        } else {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    public function show(Request $request, $id)
    {
        $message = Message::find($id);
        if ($message) {
            $message->read_at = \Carbon\Carbon::now();
            $message->save();
            return view('backend.message.show', compact('message'));
        } else {
            return back();
        }
    }

    public function delete($id)
    {
        $result = $this->message->delete($id);
        if ($result) {
            return back()->with('success', 'Bạn đã xóa thành công.');
        } else {
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại');
        }
    }
}
