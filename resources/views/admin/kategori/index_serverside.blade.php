@extends('layout.admin_app')
@section('title')
    kategori
@endsection
@section('table_content')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-top: 20px;
            margin-right: 10px;
        }

        .dataTables_length {
            margin-top: 20px;
            margin-left: 15px;
        }

        .far.fa-edit,
        .far.fa-trash-alt:hover {
            cursor: pointer;
        }
    </style>
    <div class="tables" style="margin-top:20px;">
        <div class="" style="margin-left:25px">
            <a href="#" id="add_kategori" class="btn">Tambah Kategori</a>
        </div>
        <section class="table__body">
            <table id="kategori-yajra">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name Kategori</th>
                        <th>Total Product</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // $(function () { 
        //    var table = $('.kategori-yajra').DataTable({
        //       responsive: true,
        //       processing: true,
        //       serverSide: true,
        //       ajax: "{{ route('server-side-kategori') }}",
        //       columns: [
        //             {data: 'no', name: 'no'},
        //             {data: 'nama_kategori', name: 'nama_kategori'},
        //             {data: 'totalProduct', name: 'totalProduct'},
        //             {
        //                data: 'action', 
        //                name: 'action', 
        //                orderable: false, 
        //                searchable: false
        //             },
        //       ]
        //    });

        // });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#kategori-yajra').DataTable({
                "ajax": {
                    "url": "{{ route('kategori-all') }}",
                    "dataSrc": "data",
                    /*response data*/
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            "Bearer " + `${localStorage.getItem("token")}`);
                    },
                    "error": function(xhr, error, thrown) {
                        const toJson = JSON.parse(xhr.responseText);
                        if (toJson.status === 'Token is Invalid') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Harap login kembali',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('home') }}'
                                }
                            })
                        }
                        if (xhr.responseJSON.msg == 'tidak dapat akses menu kategori') {
                           Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Tidak ada akses',
                            })
                        }
                    }
                },
                "columns": [{
                        "data": "id_kategori"
                    },
                    {
                        "data": "nama_kategori"
                    },
                    {
                        "data": `product_relasi_kategori.length`
                    },
                    {
                        render: function(data, type, row) {
                            const cek = row.product_relasi_kategori.length < 1 ?
                                `<i onclick="deleteKategori(${row.id_kategori})" class="far fa-trash-alt" style="background:red" title="delete"></i>` :
                                '';
                            return `<i onclick="editKategori(${row.id_kategori})" class="far fa-edit" style="margin-right:5px;"></i>` +
                                cek;
                        }
                    }
                ]
            });
        });

        function editKategori(id) {
            $.ajax({
                type: "get",
                url: "{{ route('kategori-details-input') }}",
                data: {
                    'id_kategori': id
                },
                beforeSend: function(xhr) {
                     xhr.setRequestHeader('Authorization',
                        `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Tambah Kategori',
                        html: `<input type="text" id="name_kategori_edit" value='${response.data.nama_kategori}' class="swal2-input" placeholder="nama kategori">`,
                        confirmButtonText: 'Save',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        focusConfirm: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let name_kategori = $("#name_kategori_edit").val();
                            $.ajax({
                                url: `{{ route('kategori-add') }}`,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                type: 'post',
                                data: {
                                    'id_kategori': id,
                                    'nama_kategori': name_kategori
                                },
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader('Authorization',
                                       `Bearer ${localStorage.getItem("token")}`);
                                },
                                success: function(response) {
                                    if (response.status == 'ok') {
                                        $('#kategori-yajra').DataTable().ajax.reload(null,
                                            true);
                                        Swal.fire(
                                            'Add',
                                            'Update data kategori berhasil',
                                            'success'
                                        )
                                    }
                                },
                                error: function(er) {
                                    Swal.fire({
                                        icon: 'error',
                                        text: 'nama kategori wajib diisi...',
                                    })
                                }
                            })
                        }
                    })
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        function deleteKategori(id) {
            Swal.fire({
                title: "Yakin ingin menghapus kategori ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('kategori-delete') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: 'post',
                        data: {
                            'id_kategori': id
                        },
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                `Bearer ${localStorage.getItem("token")}`);
                        },
                        success: function(response) {
                            $('#kategori-yajra').DataTable().ajax.reload(null, true);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        },
                        error: function(err) {
                            let tidak_ada_akses = err.responseJSON.msg
                            if (tidak_ada_akses) {
                                Swal.fire({
                                    icon: 'error',
                                    text: tidak_ada_akses,
                                })
                            }
                        }
                    })
                }
            })
        }

        $("#add_kategori").click(function() {
            Swal.fire({
                title: 'Tambah Kategori',
                html: `<input type="text" id="name_kategori" class="swal2-input" placeholder="nama kategori">`,
                confirmButtonText: 'Save',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                focusConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let name_kategori = $("#name_kategori").val();
                    $.ajax({
                        url: `{{ route('kategori-add') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: 'post',
                        data: {
                            'nama_kategori': name_kategori
                        },
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                `Bearer ${localStorage.getItem("token")}`);
                        },
                        success: function(response) {
                            if (response.status == 'ok') {
                                $('#kategori-yajra').DataTable().ajax.reload(null, true);
                                Swal.fire(
                                    'Add',
                                    'Tambah data kategori berhasil',
                                    'success'
                                )
                            }
                        },
                        error: function(er) {
                            Swal.fire({
                                icon: 'error',
                                text: 'nama kategori wajib diisi...',
                            })
                        }
                    })
                }
            })
        })
    </script>
@endpush
