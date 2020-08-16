@extends('layouts.default')
@section('menu','Transaksi')
@section('page','Daftar Transaksi')
@include('includes.datatables')

@section('content')
<div class="col-lg-12">
    <div class="card card-outline card-teal">
        <div class="card-body p-2">
            <div class="table-responsive table-hover">
                <table class="table table-bordered " id="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Uuid</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
                url: "{{route('transaction.index')}}",
                dataType: 'json'
            },
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'uuid',
                    name: 'uuid'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'transaction_total',
                    name: 'transaction_total'
                },
                {
                    data: 'transaction_status',
                    name: 'transaction_status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
        let overlay =
            '<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-2x fa-sync fa-spin"></i></div> ';

        // edit
        $('body').on('click', '.edit', function () {
            $('#modal').modal('show');
            $('.modal-header').removeClass('bg-teal');
            $('.modal-header').addClass('bg-warning');
            $('.modal-title').html('Edit Barang');
            $('.modal-content').append(overlay);
            var id = $(this).data('id');
            $.get('product/' + id + '/edit', function (data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#category_id').val(data.category_id);
                $('#price').val(data.price);
                $('#quantity').val(data.quantity);
                $('.overlay').remove();
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
                        url: "transaction/" + data_id,
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
