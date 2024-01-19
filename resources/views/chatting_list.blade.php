@extends('layouts.app')
@php
  $pageNm = 'Chatting lists';
  //  echo '<pre>';
    // print_r($chat_list);
  
  // die;
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
        <div class="card-header bg-info">
          <h3 class="card-title">{{ $pageNm }}</h3>
        </div>
        <div class="card-body">
          <form action="" method="post" class="update-role-form">
            
            <table class="table">
              <thead>
                <tr>
                  <th>S No.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>CPF NO</th>
                  <th>Mobile</th>
                  <th>Action</th>
                </tr>
              </thead>
          
              <tbody>
                @foreach($chat_list as $chat)
                  <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$chat->name}}</td>
                    <td>{{$chat->email}}</td>
                    <td>{{$chat->cpf_no}}</td>
                    <td>{{$chat->mobile}}</td>
                    <td>
                      <button type="button" class="btn btn-success btn-sm" title="Reply" onclick="window.location='{{ route("chatting.show", ["id" => $chat->id]) }}';" >Reply</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </form>
    

        </div>

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
