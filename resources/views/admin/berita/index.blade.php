@extends('layouts.app')

@section('css')
<!-- Page plugins -->
<link rel="stylesheet" href="{{URL::asset('adm_dinsos/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{URL::asset('adm_dinsos/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Input groups -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">List Berita</h3>

                <div class="pt-3">
                    <a href="{{ route('berita.tambah') }}" class="btn btn-success">Tambah Data</a>
                </div>
            </div>

            <!-- Card body -->
            <div class="card-body">
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Judul Berita</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_all as $ga)
                            <tr>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $ga->judul }}</td>
                                <td class="text-center">
                                    <form action="{{ route('berita.destroy', $ga->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-pinterest btn-icon-only rounded-circle"
                                            onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')">
                                            <span class="btn-inner--icon">x</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Optional JS -->
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('adm_dinsos/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
@endsection
