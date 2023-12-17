<?php

namespace App\Http\Controllers;

use App\Services\MessageServices;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageKh;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    protected $message;
    public function __construct(MessageServices $message)
    {
        $this->message = $message;
    }
    public function index()
    {
        $messages = Message::with('user')->get();
        $messageKh = MessageKh::with('message.user')->get();

        return view('backend.message.index', compact('messages', 'messageKh'));
    }

    public function searchUser(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->search . '%')
            ->where('role', 0) // Bạn muốn tìm kiếm theo status = 0, không phải '0'
            ->orderBy('id', 'DESC')
            ->get(); // Thêm hàm get() ở cuối để thực hiện truy vấn

        return view('backend.message.index', compact('users'));
    }

    public function viewMessage($id)
    {
        $messages = Message::find($id);

        // Kiểm tra xem có tin nhắn nào được tìm thấy hay không
        if (!$messages) {
            return redirect()->back()->with([
                'Unauthorized' => 'Không thấy tin nhắn'
            ]);
        }

        // Sử dụng first() thay vì get() nếu bạn chỉ mong muốn lấy một bản ghi
        $messagekh = MessageKh::where('message_id', $id)->first();

        return view('backend.message.index', compact('messages', 'messagekh'));
    }

    public function sendMessage(Request $request)
    {
        // Validate request
        $request->validate([
            'user_id' => 'required',
            'message' => 'required',
        ]);

        // Lưu tin nhắn vào bảng 'messages'
        $message = new Message();
        $message->user_id = $request->user_id;
        $message->message = $request->message;
        $message->save();

        // // Lưu tin nhắn vào bảng 'message_kh'
        // $messageKh = new MessageKh();
        // $messageKh->message_id = $message->id; // Lấy ID của tin nhắn vừa lưu
        // $messageKh->message = $request->message;
        // $messageKh->save();

        return redirect()->route('backend.message.index')->with('success', 'Tin nhắn đã được gửi thành công');
    }
}
