@extends('admin.layouts.default')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">Welcome to HR-Tech Traning</h1>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection