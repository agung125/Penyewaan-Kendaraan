@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pemesanan</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book-open"></i> Pemesanan</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.pemesanan.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('pemesanans.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.pemesanan.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="date" class="form-control" name="q"
                                       placeholder="cari berdasarkan hari">
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
                                <th scope="col">SUPIR</th>
                                <th scope="col">KEPALA CABANG</th>
                                <th scope="col">KENDARAAN</th>
                                <th scope="col">STATUS</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pemesanans as $no => $pemesanan)
                                @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('pengelola') && $pemesanan->pengelola_id == auth()->user()->user_id) || (auth()->user()->hasRole('supir') && $pemesanan->supir_id == auth()->user()->user_id))
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($pemesanans->currentPage()-1) * $pemesanans->perPage() }}</th>
                                        <td class="text-center"> {{$pemesanan->supir->nama_supir}}</td>
                                        <td class="text-center"> {{$pemesanan->pengelola->nama_pengelola}}</td>
                                        <td class="text-center"> {{$pemesanan->kendaraan->nama_kendaraan}}</td>
                                        <td>
                                            @if ($pemesanan->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-primary">Pending</button>
                                            @elseif ($pemesanan->status == 'disetujui')
                                                <button type="button" class="btn btn-sm btn-success">Disetujui</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-danger">Tidak Disetujui</button>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#myModal" data-id="{{ $pemesanan->id }}">
                                                Lihat
                                            </button>
                                        </td>

                                        <td>
                                            <form action="{{ route('admin.pemesanan.export', $pemesanan->id )}}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-file-excel"></i> Export Excel
                                                </button>
                                            </form>
                                        </td>

                                        <td class="text-center">
                                            @can('pemesanans.edit')
                                                <a href="{{ route('admin.pemesanan.edit', $pemesanan->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            @can('pemesanans.delete')
                                                <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $pemesanan->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$pemesanans->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detail Pemesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                        @if(auth()->user()->hasRole('supir') && $pemesanan->supir_id == auth()->user()->user_id)
                        <form action="{{ route('admin.aprove.supir', $pemesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </form>
                        <form action="{{ route('admin.reject.supir', $pemesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    @endif
                    @if(isset($pemesanan) && auth()->user()->hasRole('pengelola') && $pemesanan->pengelola_id == auth()->user()->user_id)
                         <form action="{{ route('admin.aprove.pengelola', $pemesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </form>
                        <form action="{{ route('admin.reject.pengelola', $pemesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Script JavaScript -->
<!-- JavaScript to handle modal and AJAX request -->
<script>
    $(document).ready(function() {
        $('.open-modal').on('click', function() {
            var id = $(this).data('id');

            // Kirimkan AJAX request untuk mendapatkan data rincian dari server
            $.ajax({
                url: "/admin/show/"+id, // URL untuk endpoint detail pemesanan
                type: 'GET',
                success: function(response) {
                    // Isi konten modal dengan data rincian yang diterima dari server
                    $('#myModal .modal-body').html(response);
                    // Tampilkan modal
                    $('#myModal').modal('show');
                },
                error: function(xhr) {
                    // Tangani error jika request gagal
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>



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
                        url: "/admin/pemesanan/"+id,
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
