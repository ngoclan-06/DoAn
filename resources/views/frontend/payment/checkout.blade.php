@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')
<form action="{{ route('user.checkout.momo') }}" method="POST">
    @csrf
    {{-- <input type="hidden" value="{{ $total_amount }}" name="total">ATM payment:  --}}
    <button class="btn" type="submit" name="payUrl">Momo</button>
</form>
@endsection