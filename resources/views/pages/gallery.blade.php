@extends('layouts.default')
@section('menu','Barang')
@section('page','Foto Barang')
@include('includes.datatables')
@push('style')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('assets')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush


@section('content')
<div class="col-lg-12">
    <div class="card card-outline card-teal">
        <div class="card-body p-1">
            <a href="javascript:void(0)" class="add btn btn-primary btn-sm float-right mb-3 mt-2 mr-1 shadow"><i
                    class="fas fa-edit"></i>
                Tambah
                Foto Barang</a>

            <div class="table-responsive table-hover">
                <table class="table table-bordered " id="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name Barang</th>
                            <th>Photo</th>
                            <th>Is Default</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title">Large Modal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="form" id="form" autocomplete="off">
                @csrf
                <div class="modal-body bg-light">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <select class="form-control category" name="product_id" id="product_id">
                                    <option selected>Nama Barang</option>
                                    @foreach ($product as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Photo</label>
                                <input type="file" class="form-control" name="photo" id="photo" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">is_default</label>
                                <select name="is_default" id="is_default" class="form-control">
                                    <option value="0">TIDAK</option>
                                    <option value="1">YA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer p-0 justify-content-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-location-arrow"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>

{{-- modal show photo --}}
<div class="modal fade" id="modal-photo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info p-2">
                <h6 class="modal-title">Photo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <img src="" alt="photo barang" class="w-100" id="photo_show">
            </div>
            <div class="modal-footer p-0 justify-content-right">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i>
                    Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>
@endsection

@push('script')
<!-- Select2 -->
<script src="{{asset('assets')}}/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.category').select2({
            theme: 'bootstrap4'
        });

        // photo
        $('body').on('click', '.photo', function () {
            var id = $(this).data('id');
            $('#modal-photo').modal('show');
            $.get('gallery-photo/' + id, function (data) {
                var src = 'storage/' + data;
                $('#photo_show').attr('src', src);
            })

        });

        var table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            info: false,
            language: {
                emptyTable: '<span class="badge badge-pill badge-danger">Tidak Ada Data</span>',
                loadingRecords: '&nbsp;',
                processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            },
            ajax: {
                url: "{{route('gallery.index')}}",
                dataType: 'json'
            },
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'is_default',
                    name: 'is_default'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        // btn add
        $('.add').click(function () {
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal').modal('show');
            $('.modal-header').addClass('bg-teal');
            $('.modal-title').html('Tambah Foto Barang');
        })
        $('#form').submit(function (event) {
            event.preventDefault();
            console.log('submit');
            var form = $('#form')[0];
            var data = new FormData(form);
            var id = $('#id').val();
            $.ajax({
                enctype: 'multipart/form-data',
                dataType: 'json',
                processData: false,
                contentType: false,
                url: "{{route('gallery.store')}}",
                type: "POST",
                data: data,
                success: function (data) {
                    $('.overlay').remove();
                    table.draw();
                    $('#modal').modal('hide');
                    toastr.success('Data Berhasil Di Simpan');
                },
                error: function () {
                    $('.overlay').remove();
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Tidak Memenuhi Ketentuan Data!!',
                        icon: 'error',
                        confirmButtonText: 'Ulang'
                    })
                }

            });
        })

        // ajax delete
        $('body').on('click', '.delete', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'yakin ?',
                text: "Data akan Di Hapus Permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'konfirmasi hapus!'
            }).then((result) => {
                if (result.value) {
                    var data_id = $(this).data('id');
                    $.ajax({
                        type: "DELETE",
                        url: "gallery/" + data_id,
                        success: function () {
                            toastr.success('Data Berhasil Di Hapus !!');
                            table.draw();

                        }
                    })
                }
            })
        })

    });

</script>
@endpush
