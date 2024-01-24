@extends('layouts.app')
@php
  $pageNm = 'Chatting';
// echo '<pre>'; print_r($user_info); die;
  $chatId = $user_info->chat_id;
  $userId = $user_info->user_id;
  
@endphp
@section('title', $pageNm)
@section('content')
  <style>
    .direct-chat-messages p {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 9px;
    
    }
    .direct-chat-messages {
    height: auto;
    }
    .navbar-badge {
    right: unset;
    top: unset;
    z-index: 9999;
    left: 40px;
    }
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $pageNm }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">{{ $pageNm }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $pageNm }}</h3>
        </div>
      
        <div class="card-body">
          
            <form action="{{ route('chatting.save')}}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{ $userId }}">
              <input type="hidden" name="chat_id" value="{{ $chatId }}">

              <div class="input-group">
                <textarea type="text" rows="1" class="form-control" row="1" name="chat" placeholder="Type Message ..." required ></textarea>
                <span class="input-group-append">
                <button type="button" class="btn btn-primary sub-btn">Send</button>
                </span>
              </div>
            </form>   
            <div class="card direct-chat direct-chat-primary">
              <div class="direct-chat-messages">
                @foreach($chatting_list as $chatting)
                    <div class="direct-chat-msg {{ $chatting->user_type == 'admin' ? 'right' : '' }}">
                        <div class="direct-chat-infos clearfix">
                            {{-- <span class="direct-chat-name float-{{ $chatting->user_type == 'admin' ? 'right' : 'left' }}">
                                {{ $chatting->user_type == 'admin' ? 'Admin' : 'User' }}
                            </span> --}}
                            {{-- <span class="direct-chat-timestamp float-{{ $chatting->user_type == 'admin' ? 'left' : 'right' }}">
                                {{ $chatting->created_at->format('d M h:i a') }}
                            </span> --}}
                        </div>
                         <img class="direct-chat-img" src="{{ asset('/images/chat_' . ($chatting->user_type == 'admin' ? 'admin.png' : 'user.png')) }}" alt="message user image">

                        @if($chatting->user_type == 'user' && $chatting->chat_status == 0)
                        <span class="badge badge-success navbar-badge">New</span>
                        @endif
                        <div class="direct-chat-text">
                            {{ $chatting->message }}
                            <p>{{ $chatting->created_at->format('d M h:i A') }}, {{ $chatting->name }}</p>
                        </div>
                    </div>
                @endforeach
              </div>
            </div>
      
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('.sub-btn').on('click', function () {
            var form = $(this).closest('form');
            console.log(form.serialize());
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    console.log(response);
                    // return false;
                    show_msgT(response.status, response.message);
                    form.find('textarea[name="chat"]').val('');
                    window.location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
  </script>