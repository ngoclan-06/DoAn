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
        // $messages = $this->message->getAllMessage();
        $messages = Message::with('user')->latest()->get();
        $messagekh = MessageKh::where('message_id', $messages->first()->id)->get();
        return view('backend.message.index', compact('messages', 'messagekh'));

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
    // // Lấy thông tin người dùng
    // $users = User::findOrFail($id);

    // // Lấy tin nhắn của người dùng
    // $messages = Message::where('status', 1)
    //     ->where('user_id', $users->id)
    //     ->select('id', 'name')
    //     ->first();
    $messages = Message::with('user')->latest()->get();

    // Kiểm tra xem có tin nhắn hay không
    if ($messages) {
        // $messagekh = MessageKh::where('status', 1)
        //     ->where('message_id', $messages->id)
        //     ->select('id', 'name')
        //     ->first();
    $messagekh = MessageKh::with([
        'message',
        'message.user',
        ])->latest()->get();

    } else {
        $messagekh = null;
    }

    return view('backend.message.index', compact('messages', 'messagekh'));
}
    // public function index($userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $messages = Message::where('user_id', $user->id)->get();
    //     $messageKhs = MessageKh::where('message_id', $messages->first()->id)->get();

    //     return view('backend.message.index', compact('user', 'messages', 'messageKhs'));
    //     // Trong một Controller

    //     // return redirect()->route('backend.message.index', ['userId' => $userId]);

    // }

    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required',
    //         'userId' => 'required',
    //     ]);

    //     $user = Auth::user();

    //     $message = new Message([
    //         'name' => 'Cửa hàng HaVy Bakery',
    //         'message' => $request->message,
    //         'status' => 1, // Thích hợp với logic của bạn
    //     ]);
    //     $user->messages()->save($message);

    //     $messageKh = new MessageKh([
    //         'name' => 'Cửa hàng HaVy Bakery',
    //         'message' => $request->message,
    //         'status' => 1, // Thích hợp với logic của bạn
    //     ]);
    //     $messageKh->user()->associate($user);
    //     $messageKh->message()->associate($message);
    //     $messageKh->save();

    //     return redirect()->route('chat.index', ['userId' => $request->userId]);
    // }
    // public function showChat()
    // {
    //     $messages = Message::all();
    //     $messageKhs = MessageKh::all();

    //     return view('backend.message.index', compact('messages', 'messageKhs'));
    // }

    public function sendMessage(Request $request)
    {
        // Validate request
        $request->validate([
            'userId' => 'required',
            'message' => 'required',
        ]);

        // Lưu tin nhắn vào bảng 'messages'
        $message = new Message();
        $message->user_id = $request->userId;
        $message->message = $request->message;
        $message->save();

        // Lưu tin nhắn vào bảng 'message_kh'
        $messageKh = new MessageKh();
        $messageKh->message_id = $message->id; // Lấy ID của tin nhắn vừa lưu
        $messageKh->message = $request->message;
        $messageKh->save();

        return redirect()->route('backend.message.index')->with('success', 'Tin nhắn đã được gửi thành công');
    }
}
