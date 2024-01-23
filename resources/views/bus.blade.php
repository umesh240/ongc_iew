@extends('layouts.app')
@php
  $pageNm = 'Bus details';
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
            <div class="form-group row">
              <label for="exampleInputEmail1">Hotel For Event</label>
              <div class="col-sm-9">
                <select class="form-control form-control-sm eventcd" name="eventcd" required>
                  <option value="">Select</option>
                  <option value="test">test</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">Bus type</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="bus_type" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">Bus No.</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="bus_num" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">Time</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="time" value="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </div>
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
