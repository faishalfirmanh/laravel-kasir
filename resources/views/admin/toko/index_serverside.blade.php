@extends('layout.admin_app')
@section('title')
    Toko
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
            <a href="#" id="add_toko" class="btn">Tambah Toko</a>
        </div>
        <section class="table__body">
            <table class="toko-yajra" id="toko-ajax-list">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name Toko</th>
                        <th>Jumlah user</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </div>
@endsection

@section('modal_global')
    @include('admin.toko.modal')
@endsection

@push('scripts')
    <script>
      $(document).ready(function(){
         $('#toko-ajax-list').DataTable({
            "ajax": {
                "url": "{{ route('get-all-toko') }}",
                "dataSrc": "data",
                /*response data*/
                "beforeSend": function(xhr) {
                    xhr.setRequestHeader('Authorization',
                        "Bearer " + `${localStorage.getItem("token")}`);
                },
                "error": function(xhr, error, thrown) {
                    const toJson = JSON.parse(xhr.responseText);
                    if (toJson.status === 'Token is Invalid' || toJson.status == "Token is Expired") {
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
                    if (xhr.status == 403) {
                        sweetAlertError("Tidak dapat akses menu toko")
                        $("#toko-ajax-list").html("");
                        $("#add_toko").remove()
                    }
                }
            },
            "columns": [{
                    "data": "id_toko"
                },
                {
                    "data": "nama_toko"
                },
                {
                    "data": `user_relasi_toko.length`
                },
                {
                    render: function(data, type, row) {
                        const cek = row.user_relasi_toko.length < 1 ?
                            `<i onclick="deleteToko(${row.id_toko})" class="far fa-trash-alt" style="background:red" title="delete-toko"></i>` :
                            '';
                        return `<i onclick="editToko(${row.id_toko})" class="far fa-edit" style="margin-right:5px;"></i>` +
                            cek;
                    }
                }
            ]
        });
      })


        function getTokoAjax() {
            $.ajax({
                type: "post",
                url: "{{ route('toko-list') }}",
                data: {
                    'limit': 10,
                    'page': 1,
                    'keyword': ''
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(response) {
                    if (response.status == 'Authorization Token not found') {
                        alert("tidak ada hak akses");
                        window.location.href = '{{ route('home') }}'
                    } else {
                        let data_json = response.data[0].data
                        var tbody = $('#toko-ajax-list tbody');
                        $.each(data_json.data, function(i, item) {
                            let html_button =
                                `<i onclick="editToko(${item.id_toko})" class="far fa-edit" style="margin-right:5px;"></i>`;
                            let html_button_delete = item.user_relasi_toko.length < 1 ?
                                `<i onclick="deleteToko(${item.id_toko})" class="far fa-trash-alt" style="background:red" title="delete-product"></i>` :
                                '';
                            var row = $('<tr>').appendTo(tbody);
                            $('<td>').text(item.id_toko).appendTo(row);
                            $('<td>').text(item.nama_toko).appendTo(row);
                            $('<td>').text(item.user_relasi_toko.length).appendTo(row);
                            $('<td>').append(html_button, html_button_delete).appendTo(row)
                        });
                    }
                }
            })
        }

        // getTokoAjax();

        const input_toko = document.getElementById("nama_toko")
        const all_toogle = document.querySelectorAll('[data-toggle="modaltoko"]')
        let navbar_atas_id = document.getElementById('top-bar');
        const navbar_samping_id = document.getElementById('sidebar');
        const modal = document.querySelector("#modaltoko")

        $("#add_toko").on("click", function(e) {

            const modal_close = modal.querySelector('.modal__close_2')
            modal.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";
            input_toko.value = ""
            modal_close.addEventListener('click', function(e) {
                e.preventDefault()
                modal.classList.remove('show-modal')
                navbar_atas_id.style.position = "fixed";
                navbar_samping_id.style.position = "fixed";
            })

            //ajax 
            if (document.getElementById("id_toko_hidden")) {
                document.getElementById("id_toko_hidden").removeAttribute("id")
            }
        })
    </script>
    <script>
        $("#form-toko").on("submit", function(e) {
            e.preventDefault()
            const cek_id = document.getElementById('id_toko_hidden');

            let data_input = {
                'nama_toko': input_toko.value
            }
            if (cek_id) {
                data_input.id_toko = localStorage.getItem('id_toko_hidden')
            }

            console.log();
            $.ajax({
                type: 'post',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: data_input,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('post-toko') }}`,
                success: function(res) {
                    if (res.status == 'ok') {
                        // 
                        Swal.fire(
                            'Add',
                            'Save data toko berhasil',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                                $('#toko-ajax-list').DataTable().ajax.reload(null, true);
                            }
                        })


                    }
                    console.log('ress sucesse save', res);
                },
                error: function(xhr, status, error){
                    const res_error = xhr.responseJSON;
                    if (res_error.data.nama_toko) {
                        alert('Gagal simpan ,nama sudah digunakan')   
                    }
                }
            })

        })

        function editToko(id) {
            const modal = document.querySelector("#modaltoko")
            const modal_close = modal.querySelector('.modal__close_2')
            modal.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";

            input_toko.value = ""

            //ajax
            $.ajax({
                type: 'post',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: {
                    'id_toko': id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('detail-toko') }}`,
                success: function(res) {
                    let data = res.data;
                    input_toko.value = data.nama_toko
                    //create input tipe hidden for edit
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.setAttribute('id', 'id_toko_hidden');
                    input.setAttribute('value', parseInt(id));
                    document.getElementById('form-toko').appendChild(input);
                    localStorage.setItem("id_toko_hidden", id);
                    const idnya = localStorage.getItem("id_toko_hidden");
                    console.log(idnya);
                    //create input tipe hidden for edit

                },
                error: function(xhr, status, msg) {

                }
            })
            //ajax

            modal_close.addEventListener('click', function(e) {
                e.preventDefault()
                modal.classList.remove('show-modal')
                navbar_atas_id.style.position = "fixed";
                navbar_samping_id.style.position = "fixed";
            })
            console.log(id);
        }

        function deleteToko(id) {
            Swal.fire({
                title: "Yakin ingin menghapus toko ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('delete-toko') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                `Bearer ${localStorage.getItem("token")}`);
                        },
                        type: 'post',
                        data: {
                            'id_toko': id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            location.reload();
                        },
                        error: function(err) {
                            console.log('error', err);
                        }
                    })
                }
            })
        }
    </script>
@endpush
