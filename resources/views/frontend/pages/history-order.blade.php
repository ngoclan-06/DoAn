@extends('frontend.layouts.master')
@section('title', 'Lịch sử đơn hàng')
@section('main-content')
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
   <div class="card-header py-3">
     <h6 class="m-0 font-weight-bold text-primary float-left">Danh sách đơn hàng</h6>
   </div>
   <div class="card-body">
     <div class="table-responsive">
       @if(count($orders)>0)
       <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
         <thead>
           <tr style="text-align: center">
             <th>STT</th>
             <th>Tên</th>
             <th>Email</th>
             <th>Tổng cộng</th>
             <th>Ngày</th>
             <th>Trạng thái</th>
             <th>Lựa chọn</th>
           </tr>
         </thead>
         <tbody>
           @foreach($orders as $order)
               <tr style="text-align: center">
                   <td>{{ ++$i }}</td>
                   <td>{{$order->fullname}}</td>
                   <td>{{$order->email}}</td>
                   <td>{{number_format($order->total,0)}}</td>
                   <td>{{ $order->created_at->format('D d M, Y') }}</td>
                   <td>
                       @if($order->status=='new')
                         <span class="badge badge-primary">Mới</span>
                       @elseif($order->status=='process')
                         <span class="badge badge-warning">Đang giao</span>
                       @elseif($order->status=='delivered')
                         <span class="badge badge-success">Đã giao hàng</span>
                       @else
                         <span class="badge badge-danger">Giao thành công</span>
                       @endif

                       {{-- @if ($product->status == 1)
                           <span class="badge badge-success">Còn bán</span>
                       @else
                           <span class="badge badge-warning">Không còn bán</span>
                       @endif --}}
                   </td>
                   <td>
                       {{-- <a href="{{ route('order.show',$order->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                       <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a> --}}
                       <form method="POST" action="{{ route('order.delete', $order->id) }}">
                         @csrf 
                         @method('delete')
                             <button onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng không?')" class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" title="Delete"><i class="fas fa-trash-alt"></i></button>
                       </form>
                   </td>
               </tr>  
           @endforeach
         </tbody>
       </table>
       <span style="float:right">{{ $orders->links('pagination::bootstrap-4') }}</span>
       @else
         <h6 class="text-center">Không tìm thấy đơn hàng!!!</h6>
       @endif
     </div>
   </div>
</div>
@endsection