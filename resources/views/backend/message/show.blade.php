@extends('backend.layouts.master')
@section('main-content')
<div class="card">
  <h5 class="card-header">Tin nhắn</h5>
  <div class="card-body">
    @if($message)
        <div class="py-4">From: <br>
           Tên :{{$message->name}}<br>
           Email :{{$message->email}}<br>
           Số điện thoại :{{$message->phone}}
        </div>
        <hr/>
  <h5 class="text-center" style="text-decoration:underline"><strong>Subject :</strong> {{$message->subject}}</h5>
        <p class="py-5">{{$message->message}}</p>

    @endif

  </div>
</div>
@endsection