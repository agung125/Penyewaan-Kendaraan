@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Kendaraan</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-truck-moving"> Data Kendaraan</i></h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.kendaraan.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('kendaraans.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.kendaraan.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama kendaraan">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">FOTO</th>
                                <th scope="col">NAMA KENDARAAN</th>
                                <th scope="col">JENIS KENDARAAN</th>
                                <th scope="col">JADWAL SERVICE</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($kendaraans as $no => $kendaraan)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($kendaraans->currentPage()-1) * $kendaraans->perPage() }}</th>
                                    <td>
                                        @if ($kendaraan->status == 0)
                                            <span style="color: red">&#11044;</span>
                                        @else
                                            <span style="color: green">&#11044;</span>
                                        @endif
                                    </td>
                                    <td><img src="{{ $kendaraan->image }}" style="width: 150px"></td>
                                    <td>{{ $kendaraan->nama_kendaraan }}</td>
                                    <td>{{ $kendaraan->jenis_kendaraan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kendaraan->jadwal_service)->format('d F Y') }}</td>
                                    <td class="text-center">
                                        @can('kendaraans.edit')
                                            <a href="{{ route('admin.kendaraan.edit', $kendaraan->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('kendaraans.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $kendaraan->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$kendaraans->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {


                    //ajax delete
                    jQuery.ajax({
                        url: "/admin/kendaraan/"+id,
                        data:     {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
</script>
@stop
