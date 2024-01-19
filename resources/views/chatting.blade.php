@extends('layouts.app')
@php
  $pageNm = 'Chatting';
//    echo '<pre>';
// print_r($chatting_list);
@endphp
@section('title', $pageNm)
@section('content')

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
            {{-- <input type="hidden" name="user_id" value="{{$chatting[array_key_last($chatting)];}}"> --}}
            @if(!empty($chatting_list))
            <input type="hidden" name="user_id" value="{{ $chatting_list[end($chatting_list)]->user_id }}">
            @endif
            <div class="form-group row"> 
                <div class="col-sm-12">
                    <textarea class="form-control" name="chat" required></textarea>
                </div>
            </div>
        
            <div class="form-group row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary sub-btn">Submit</button>
                </div>
            </div>
          </form>   
          <table class="table">
            <thead>
              <tr>
                <th>S No.</th>
                <th>Message</th>
                <th>Date</th>
              </tr>
            </thead>
        
            <tbody>

       
              @foreach($chatting_list as $chatting)
                <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>{{$chatting->message}}</td>
                  <td>{{$chatting->created_at}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
     
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
                    show_msgT(response.status, response.message);
                    form.find('textarea[name="chat"]').val('');
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
  </script>