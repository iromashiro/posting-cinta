@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Input groups -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Input Data Informasi</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <form method="POST" action="{{ route('pai.create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <input class="form-control" placeholder="Nama Menu" name="nama_menu" type="text"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <input class="form-control" name="path" type="file">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Input Data Informasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
