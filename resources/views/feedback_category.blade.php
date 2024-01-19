@extends('layouts.app')
@php
 
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Feedback Master ';
@endphp
@section('title', $pageNm)
@section('content')
<style>
.ui-sortable-helper{
  width:100%;
  background-color:#ccc;
}
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $pageNm }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <hr class="w-100 mt-0">
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
   

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">List</h3>
           </div>
          <div class="card-body pl-0 pr-0">
            <table class="table table-bordered" width="100%" style="min-width: 100%;">
              <thead>
                <tr class="bg-dark">
                  <th style="width:7%;">Sr.No.</th>
                  <th style="width:85%;">Name</th>
                 
                </tr>
              </thead>
              <tbody  >
              @php $cnt = 0; @endphp 
              @foreach ($feedback_category_list as $key => $feedback_category) 
              @php $cnt++; @endphp 
              <tr style="width:100%; cursor: move;" class="td_fd_id" data-id="{{ $feedback_category->id }}">
                <td style="padding-top: 2px; padding-bottom: 2px;width:7%;"><i class="fa fa-arrows-alt-v text-gray"></i> &nbsp;&nbsp;&nbsp;&nbsp;{{ $key+1 }}.</td>
                <td style="padding-top: 2px; padding-bottom: 2px;width:85%;"><a href="{{ route('feedback', $feedback_category->id) }}">{{ $feedback_category->title }}</a></td>
                <td style="padding-top: 2px; padding-bottom: 2px;width:8%;">
                  </td>
              </tr>
              @endforeach
              @php if($cnt == 0){
                echo '<tr><td colspan="5">No record found.</td></tr>';
              } 
              @endphp 
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection