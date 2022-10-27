@extends('layouts.app')
@section('js')
<script src="https://cdn.tiny.cloud/1/cjves1zm5h8aljomy6r6368i5h9xkp7xv648ddxb1uqjpie1/tinymce/5/tinymce.min.js">
</script>

<script>
    tinymce.init({
 selector: 'textarea#description',
height : "720",
width : "1080",

plugins: 'image code print preview searchreplace autolink directionality  visualblocks visualchars fullscreen image link    table charmap hr pagebreak nonbreaking  toc insertdatetime advlist lists textcolor wordcount   imagetools    contextmenu colorpicker textpattern media ',
    toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat |undo redo | image code| link fontsizeselect  | ',
    image_class_list: [
{title: 'fluid', value: 'img-raised rounded img-fluid'}
],
    images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    var token = '{{ csrf_token() }}';
    xhr.open('POST', '/berita-tinymce');
    xhr.setRequestHeader("X-CSRF-Token", token);
    xhr.onload = function() {
    var json;

    if (xhr.status != 200) {
    failure('HTTP Error: ' + xhr.status);
    return;
    }

    json = JSON.parse(xhr.responseText);

    if (!json || typeof json.location != 'string') {
    failure('Invalid JSON: ' + xhr.responseText);
    return;
    }

    success(json.location);
    };

    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
    }
        });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Input groups -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Input Menu Berita</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <form method="POST" action="{{ route('berita.create') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Input groups with icon -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <input class="form-control" name="thumbnail" type="file">
                            </div>
                        </div>
                    </div>
                    <!-- Input groups with icon -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <input class="form-control" placeholder="Judul Berita" name="judul" type="text" required>
                            </div>
                        </div>
                    </div>
                    <!-- Input groups with icon -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <textarea id="description" name="isi_berita" class="form-control"
                                    name="isi_menu"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Input Berita</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
