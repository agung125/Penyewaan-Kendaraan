@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pemesanan</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-book-open"></i> Tambah Pemesanan</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.pemesanan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>PILIH SUPIR</label>
                                <select class="form-control select-category @error('supir_id') is-invalid @enderror" name="supir_id">
                                    <option value="">-- PILIH SUPIR --</option>
                                    @foreach ($supirs as $supir)
                                        <option value="{{ $supir->id }}">{{ $supir->nama_supir }}</option>
                                    @endforeach
                                </select>
                                @error('supir_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>PILIH PERSETUJUAN CABANG</label>
                                <select class="form-control select-category @error('pengelola_id') is-invalid @enderror" name="pengelola_id">
                                    <option value="">-- PILIH PENGELOLA --</option>
                                    @foreach ($pengelolas as $pengelola)
                                        <option value="{{ $pengelola->id }}">{{ $pengelola->nama_pengelola }}</option>
                                    @endforeach
                                </select>
                                @error('pengelola_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>PILIH KENDARAAN</label>
                                <select class="form-control select-category @error('kendaraan_id') is-invalid @enderror" name="kendaraan_id">
                                    <option value="">-- PILIH KENDARAAN --</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama_kendaraan }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>UANG JALAN</label>
                                <input type="number" min="0" name="uang_bbm" value="{{ old('uang_bbm') }}" placeholder="Masukkan Jumlah Uang Jalan" class="form-control @error('uang_bbm') is-invalid @enderror">

                                @error('uang_bbm')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>LOKASI TUJUAN</label>
                                <input type="text"  name="lokasi_tujuan" value="{{ old('lokasi_tujuan') }}" placeholder="Masukan Lokasi Tujuan" class="form-control @error('lokasi_tujuan') is-invalid @enderror">

                                @error('lokasi_tujuan')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>TANGGAL BERANGKAT</label>
                                <input type="date"  name="tanggal_berangkat" value="{{ old('tanggal_berangkat') }}" min="{{ now()->format('Y-m-d') }}" class="form-control @error('tanggal_berangkat') is-invalid @enderror">

                                @error('tanggal_berangkat')
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
