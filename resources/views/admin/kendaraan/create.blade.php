@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Kendaraan</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-truck-moving"></i> Tambah Data Kendaraan</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>GAMBAR</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NAMA KENDARAAN</label>
                                <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" placeholder="Masukkan Nama Kendaraan" class="form-control @error('nama_kendaraan') is-invalid @enderror">

                                @error('nama_kendaraan')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">JENIS KENDARAAN</label>
                                <select class="form-control" name="jenis_kendaraan" multiple="multiple">
                                        <option value="">--- PILIH JENIS KENDARAAN --- </option>
                                        <option value="angkutan orang">--- ANGKUTAN ORANG --- </option>
                                        <option value="angkutan barang">--- ANGKUTAN BARANG --- </option>
                                        <option value="sewa">--- KENDARAAN SEWA --- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>KONSUMSI BBM</label>
                                <div class="input-group">
                                    <input type="number" min="0" name="konsumsi_bbm" value="{{ old('konsumsi_bbm') }}" placeholder="Masukkan Jumlah Kapasitas" class="form-control @error('konsumsi_bbm') is-invalid @enderror">
                                    <div class="input-group-append">
                                        <span class="input-group-text text-danger"><b>Liter</b></span>
                                    </div>
                                </div>

                                @error('konsumsi_bbm')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>JADWAL SERVICE</label>
                                <input type="date" name="jadwal_service" value="{{ old('jadwal_service') }}" min="{{ now()->format('Y-m-d') }}" class="form-control @error('jadwal_service') is-invalid @enderror">

                                @error('jadwal_service')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
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
