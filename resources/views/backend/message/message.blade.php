<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<html>
<head>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link href="/style.css" type="text/css" rel="stylesheet">


</head>
<body>
  <div class="container">
  <div class="messaging">
        <div class="inbox_msg">
          <div class="inbox_people">
            <div class="headind_srch">
              <div class="recent_heading">
                <h4>Danh sách</h4>
              </div>
              <div class="srch_bar">
                <div class="stylish-input-group">
                  <form method="POST" action="{{ route('message.search') }}">
                      @csrf
                      <input name="search" placeholder="Search Products Here" type="search">
                      <span class="input-group-addon">
                          <button type="search" name="search"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                          </span> </div>
                  </form>
              </div>
            </div>
            
            <div class="inbox_chat">
              @foreach ($messages as $message)
                  <div class="chat_list">
                      @if ($message->user->image)
                          <img src="{{ asset('image/user/' . $message->user->image) }}" alt="#">
                      @else
                          <img src="{{ asset('backend/img/avatar.png') }}" alt="">
                      @endif
                      <div class="content">
                          <h6>
                              <a href="{{ route('message.view', ['id' => $message->user->id]) }}">
                                  {{ $message->user->name }}
                              </a>
                              <span>At {{ $message->created_at->format('g: i a') }} On
                                  {{ $message->created_at->format('M') }}</span>
                          </h6>
                      </div>
                  </div>
              @endforeach
          </div>          
          </div>

          @foreach ($messagekh as $messagekh)
            <div class="incoming_msg">
                <div class="incoming_msg_img"> 
                    @if ($messagekh->message->user->image)
                        <img src="{{ asset('image/user/' . $messagekh->message->user->image) }}" alt="#">
                    @else
                        <img src="{{ asset('backend/img/avatar.png') }}" alt="">
                    @endif
                </div>
                <div class="received_msg">
                    <div class="received_withd_msg">
                        <p>{{ $messagekh->message->message }}</p>
                        <span class="time_date">
                            At {{ $messagekh->message->created_at->format('g:i A') }} | {{ $messagekh->message->created_at->format('F d') }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach


          <div class="mesgs">
            <div class="msg_history">

              @foreach ($messages as $message)
                <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>{{ $message->message }}</p>
                    <span>At {{ $message->created_at->format('g: i a') }} On
                      {{ $message->created_at->format('M') }}</span></div>
                  </div>
               @endforeach
            </div>

            <div class="type_msg">
              <div class="input_msg_write">
                <input v-model="message" @keyup.enter type="text" class="write_msg" placeholder="Type a message" />
                <button @click="sendMessage" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
        </div>
</body>
</html>
        
</div>