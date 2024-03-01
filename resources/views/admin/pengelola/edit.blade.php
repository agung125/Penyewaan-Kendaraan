@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Kepala Cabang</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-tie"></i> Edit Data Kepala Cabang</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.pengelola.update', $pengelola->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>NAMA KEPALA CABANG</label>
                            <input type="text" name="nama_pengelola" value="{{ old('nama_pengelola', $pengelola->nama_pengelola) }}"
                                placeholder="Masukkan Nama Kepala Cabang"
                                class="form-control @error('nama_pengelola') is-invalid @enderror">
                            @error('nama_pengelola')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>KANTOR CABANG</label>
                            <input type="text" name="cabang" value="{{ old('cabang', $pengelola->cabang) }}"
                                placeholder="Masukkan Alamat Kantor Cabang"
                                class="form-control @error('cabang') is-invalid @enderror">
                            @error('cabang')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
    var editor_config = {
        selector: "textarea.content",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };

    tinymce.init(editor_config);
</script>
@stop
