@extends('layouts.app')
@php
  $pageNm = 'Bus List';
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
          <button type="button" class="btn btn-xs btn-success float-right" onclick="linkClick(this);" data-link="{{ route('bus.ae', ['ae' => 'add']) }}"><i class="fa fa-plus"></i> Add New</button>
        </div>
        <div class="card-body">
        
          <form action="" method="post" class="update-role-form">
            <table class='table'>
              <thead>
                <tr>
                  <th>S No.</th>
                  <th>Event type</th>
                  <th>Bust type</th>
                  <th>Bus no.</th>
                  <th>Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Event type</td>
                  <td>Bust type</td>
                  <td>Bus no.</td>
                  <td>Time</td>
                  <td>
                    <button type="button" class="btn btn-success btn-sm" title="Edit" onclick="linkClick(this);" data-link="{{ route('bus.ae', ['ae' => 'edit']) }}">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="linkClick(this);" data-link="{{ route('bus.ae', ['ae' => 'delete']) }}">Delete</button>
                  </td>

                </tr>
                <tbody>
              <table>
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
