<?php

namespace App\Http\Controllers;

use App\Services\MessageKhServices;
use Illuminate\Http\Request;
use App\Models\MessageKh;

class MessagesKHController extends Controller
{
    protected $messageskh;
    public function __construct(MessageKhServices $messageskh)
    {
        $this->messageskh = $messageskh;
    }
    public function index()
    {
        $messageskhs = $this->messageskh->getAllMessageKh();
        return view('backend.message.index', compact('messageskhs'));
    }
}
