<?php

namespace App\Http\Controllers;

use App\Models\comments;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'active';
        $status = comments::create($data);
        if ($status) {
            return redirect()->back()->with('success', 'Cảm ơn bạn lời bình luận của bạn.');
        } else {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function index()
    {
        $comments = comments::orderBy('id', 'DESC')->paginate(20);
        return view('backend.comment.index', compact('comments'));
    }
    public function edit($id)
    {
        $comment = comments::find($id);
        return view('backend.comment.edit', compact('comment'));
    }
    public function update(Request $request, $id)
    {
        $comment = comments::find($id);
        // dd($comment);
        $comment->update([
            'comment' => $request->comment,
            'status' => $request->status,
        ]);
        if ($comment) {
            return redirect()->route('comment.index')->with('success', 'Đã sửa đổi bình thành công.');
        } else {
            return redirect()->route('comment.index')->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    public function delete($id)
    {
        $comment = comments::find($id);
        if ($comment) {
            $comment->forceDelete();
            return back()->with('success', 'Xóa thành công.');
        } else {
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}
