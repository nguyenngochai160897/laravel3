@extends("admin.layouts.default")

@section("title", "add-post")

@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý bai viet
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Them moi bai viet</h3>
                    </div>
                    <!-- /.box-header -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- form start -->
                    <form role="form" action="{{ route('admin.post.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tieu de</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label>Danh muc</label>
                                <select class="form-control" name="category_id">
                                    <option value="">---- Chon danh muc ----</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Anh bia</label>
                                <input type="file" name="image">
                            </div>
                            <div class="form-group">
                                <label>Mo ta ngan</label>
                                <textarea class="form-control" rows="6" name="snapshort"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Noi dung</label>
                                <textarea class="form-control" rows="10" name="content"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Trang thai</label>
                                <select class="form-control" name="state">
                                    <option value="">---- Chon trang thai ----</option>
                                    <option value="1">Hien thi</option>
                                    <option value="0">An</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="submit" class="btn btn-default">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
