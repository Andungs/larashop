@extends('layouts.default')
@section('menu','Barang')
@section('page','Kategori Barang')
@include('includes.datatables')


@section('content')
<div class="col-lg-12">
    <div class="card card-outline card-teal">
        <div class="card-body p-1">
            <a href="javascript:void(0)" class="add btn btn-primary btn-sm float-right mb-3 mt-2 mr-1 shadow"><i
                    class="fas fa-edit"></i>
                Tambah
                Kategori</a>

            <div class="table-responsive table-hover">
                <table class="table table-bordered " id="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h6 class="modal-title">Large Modal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="form" id="form" autocomplete="off">
                @csrf
                <div class="modal-body bg-light">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" id="name" value="">
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
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#table').DataTable({
            serverSide: true,
            paging: false,
            processing: true,
            responsive: true,
            searching: false,
            info: false,
            language: {
                emptyTable: '<span class="badge badge-pill badge-danger">Tidak Ada Data</span>',
                loadingRecords: '&nbsp;',
                processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            },
            ajax: {
                url: "{{route('category.index')}}",
                dataType: 'json'
            },
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
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
            $('.modal-title').html('Tambah Kategori Bararang');
        })
        $('#form').submit(function (event) {
            event.preventDefault();
            console.log('submit');
            var form = $('#form')[0];
            var data = new FormData(form);
            var id = $('#id').val();
            var url;
            if (id > 0) {
                url = 'category/' + id;
            } else {
                url = "{{route('category.store')}}";
            }
            $.ajax({
                dataType: 'json',
                processData: false,
                contentType: false,
                url: url,
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

        // edit
        $('body').on('click', '.edit', function () {
            $('#modal').modal('show');
            $('.modal-header').removeClass('bg-teal');
            $('.modal-header').addClass('bg-warning');
            $('.modal-title').html('Edit Kategori Barang');
            var id = $(this).data('id');
            $.get('category/' + id + '/edit', function (data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
            })

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
                        url: "category/" + data_id,
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
