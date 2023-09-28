@extends('layout.admin_app')
@section('title')
    Transaksi
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
        .fas.fa-wrench,
        .fa-info-circle,
        .far.fa-trash-alt{
            cursor: pointer;
        }

    </style>
    <div class="tables" style="margin-top:20px;">
        <section class="table__body">
            <h3 style="text-align: center;margin-bottom:10px;margin-top:10px">Transaksi</h3>
            <table class="" id="transaksi-ajax-list" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        {{-- <th>Nama Toko</th> --}}
                        <th>Keuntungan</th>
                        <th>Total product (beda merk)</th>
                        <th>tanggal</th>
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
    @include('admin.transaction.modal')
@endsection

@push('scripts')
    <script>

      $(document).ready(function(){
        $('#transaksi-ajax-list').DataTable({
            "serverside": true,
            "pageLength": 10,
            "ajax": {
                "url": "{{ route('get-all-transaction') }}",
                "dataSrc": "data",
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
                        sweetAlertError("Tidak dapat akses menu laporan")
                        $("#transaksi-ajax-list").html("");
                    }
                }
            },
            "columns": [{
                    "data": "id_struck"
                },
                // {
                //     "data": "nama_toko"
                // },
                {
                    "data": `keuntungan`, render: function(data, type, row){
                        const keuntungan = row.keuntungan_bersih.toLocaleString();
                        return keuntungan;
                    }
                },
                {
                    "data": `list_produc_buy.length`
                },
                {
                    "data" : `string_date`, render: function(data, type, row){
                        const aa = row.created_at;
                        const dt = new Date(aa).toISOString().split('T')[0];
                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const string_date = new Date(dt).toLocaleString("id-ID", options)
                        return string_date;
                    }
                },
                { "data" : 'btn', render: function(data, type, row) {
                        const btn = ` <div >
                                        <i onclick="detail(${row.id_struck})" class="fa fa-info-circle" title="detail-transaction" style="margin-right:5px;background:#b4a2fb;margin-right:10px;"></i>
                                    </div>`;
                        return btn;
                    }
                }
            ]
        });
      })

      function reqAjaxDetailKeuntungan(id){
            return new Promise((resolve, reject)=>{
                $.ajax({
                    type: "post",
                    url: "{{ route('get-keuntungan-by-struck-id') }}",
                    data : { 'id_struck' : id },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    success: function(response) {
                        resolve(response.data)
                    },
                    error: function(err){
                       reject(err)
                    }
                })
            })
      }


        function detail(id){
            const modal = document.querySelector("#modalTransaksi")
            modal.classList.add('show-modal')
          
            reqAjaxDetailKeuntungan(id)
            .then((ok_res)=>{
                let list_data = ok_res[0].data;
                let wrap_div = document.getElementById("div-transaksi")
                list_data.detail_keuntungan.map((item)=>{
                    const elemet_p = document.createElement('p')
                    //name prd
                    const cek_kg = item.is_kg == '1' ? 'kg' : 'pcs';
                    const cek_subname = item.subname !== null ? item.subname : cek_kg;
                    //name prd
                    elemet_p.style.fontSize = "20px";
                    elemet_p.setAttribute('class','li-struck-view-trans');
                    elemet_p.textContent = `${item.nama_product} | ${cek_subname} - total : ${item.jumlah_item_dibeli} | ${item.TotalKeuntungan.toLocaleString()}`
                    wrap_div.appendChild(elemet_p)
                })
                let dd = list_data.total_semua_keuntungan.toLocaleString();
                const elemet_ptotal = document.createElement('p')
                elemet_ptotal.style.fontSize = "20px";
                elemet_ptotal.setAttribute('class','dom-total');
                elemet_ptotal.textContent = `Total keuntungan : ${dd}`
                wrap_div.appendChild(elemet_ptotal);

            })
            .catch((no_ok)=>{
                console.log('err',no_ok)
            })

           

            const modal_close = modal.querySelector('.modal__close_2_transaksi')
           
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";
            modal_close.addEventListener('click', function(e) {
                e.preventDefault()
                modal.classList.remove('show-modal')
                navbar_atas_id.style.position = "fixed";
                navbar_samping_id.style.position = "fixed";
                document.querySelectorAll(".li-struck-view-trans").forEach(el => el.remove());
                document.querySelectorAll('.dom-total').forEach(e => e.remove());
            })

        }

       


        function getRolejax() {
            $.ajax({
                type: "get",
                url: "{{ route('get-all-role') }}",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(response) {
                    setTimeout(() => {
                        if (response.data.length > 0) {
                            let html_opt = `<option value="0">- pilih Role -</option>`;
                            response.data.forEach((e) => {
                                html_opt +=
                                    `<option value="${e.id}">${e.name_role}</option>`;
                                    if ($("#select_role")) {
                                        $("#select_role").html(html_opt);
                                    }
                            });
                        }
                    }, 500);
                }
            })
        }
        getRolejax();

        // getTokoAjax();

        const input_name_user = document.getElementById("nama_user")
        const input_email = document.getElementById("email")
        const input_password = document.getElementById("password")
        const select_role = document.getElementById("select_role")
        const select_toko = document.getElementById("select_toko")
        const all_toogle = document.querySelectorAll('[data-toggle="modalUser"]')
        let navbar_atas_id = document.getElementById('top-bar');
        const navbar_samping_id = document.getElementById('sidebar');
        const modal = document.querySelector("#modalUser")

        $("#add_user").on("click", function(e) {

            const modal_close = modal.querySelector('.modal__close_2')
            modal.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";
            input_name_user.value = ""
            input_email.value = ""
            input_password.value = ""
            select_role.value = 0;
            select_toko.value = 0;
            modal_close.addEventListener('click', function(e) {
                e.preventDefault()
                modal.classList.remove('show-modal')
                navbar_atas_id.style.position = "fixed";
                navbar_samping_id.style.position = "fixed";
            })
            localStorage.removeItem("id_user_hidden");
            //ajax 
            if (document.getElementById("id_user")) {
                document.getElementById("id_user").removeAttribute("id")
               
            }
        })
   

        $("#form-user").on("submit", function(e) {
            e.preventDefault()
            const cek_id = document.getElementById('id_user_hidden');

            let data_input = {
                'name': input_name_user.value,
                'email' : input_email.value,
                'id_roles' : select_role.value,
                'toko_id' : select_toko.value,
                'password' : input_password.value
            }
            if (cek_id) {
                data_input.id = localStorage.getItem('id_user_hidden')
                console.log('edit');
            }
           
            
            $.ajax({
                url: `{{ route('user-save') }}`,
                type: 'post',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: data_input,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status == 'ok') {
                        // 
                        Swal.fire(
                            'Add',
                            'Save data user berhasil',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                                $('#user-ajax-list').DataTable().ajax.reload(null, true);
                            }
                        })

                    }
                },
                error: function(xhr, status, error){
                    const res_error = xhr.responseJSON;
                    console.log(res_error);
                    // if (res_error.data.nama_toko) {
                    //     alert('Gagal simpan ,nama sudah digunakan')   
                    // }
                }
            })

        })

        function ajaxDetail(id){
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: `{{ route('user-detail') }}`,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    data: {
                        'id': id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'post',
                    success: function(res) {
                        resolve(res)
                    },
                    error: function(xhr, status, msg) {
                        reject(msg)
                    }
                })
            })
        }

        function ajaxSaveChangePass(data_save){
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: `{{ route('user-change-password') }}`,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    data: data_save,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'post',
                    success: function(res_ajax_success) {
                        resolve(res_ajax_success);
                    },
                    error: function(err_ajax_failure){
                        reject(err_ajax_failure);
                    }
                })
            })
        }


        //penggunaan function yang di panggil lagi pada ajax, tidak bisa dipanggil langgsung,
        //harus menggunakan, promise, callback
        function changePass(id_user){
            let navbar_atas_change_pass = document.getElementById('top-bar');
            const navbar_samping_change_pass = document.getElementById('sidebar');
            const modal_change_pass = document.querySelector("#modalChangePassUser")
            const modal_close_change_pass = modal_change_pass.querySelector('.modal__close_2_change')

             ajaxDetail(id_user)
             .then(function(res){
                //dom
                modal_change_pass.classList.add('show-modal')
                navbar_atas_change_pass.style.position = "initial";
                modal_close_change_pass.style.position = "initial";

                const val_pass = document.getElementById('password_change')
                const val_name = document.getElementById('nama_user_change')
                val_pass.value = ''
                val_name.value = res.data.name
                $("#form-change-pass-user").on("submit", function(event_ajax){
                    event_ajax.preventDefault();
                    let data_save_change_password = {
                            'id': res.data.id,
                            'password' : val_pass.value,
                        }
                    ajaxSaveChangePass(data_save_change_password)
                    .then(function(res_save){
                        let pesan = res_save.msg
                        if (pesan == 'success') {
                            Swal.fire(
                                'Change!',
                                'User has been change password.',
                                'success'
                            )
                            $('#user-ajax-list').DataTable().ajax.reload(null, true);
                            //close modal
                            modal_change_pass.classList.remove('show-modal')
                            navbar_atas_change_pass.style.position = "fixed";
                            navbar_samping_change_pass.style.position = "fixed";
                        }

                    })
                    .catch(function(err_res_save){
                        console.log(err_res_save);
                    })
                  
                })

             })
             .catch(function(err){
                console.log(err);
             })

             //dom close modal
             modal_close_change_pass.addEventListener('click', function(e) {
                e.preventDefault()
                modal_change_pass.classList.remove('show-modal')
                navbar_atas_change_pass.style.position = "fixed";
                navbar_samping_change_pass.style.position = "fixed";
            })
        }

        function editUser(id) {
            const modal = document.querySelector("#modalUser")
            const modal_close = modal.querySelector('.modal__close_2')
            modal.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";

            input_name_user.value = ""

            //ajax
            $.ajax({
                url: `{{ route('user-detail') }}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: {
                    'id': id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                success: function(res) {
                    let data = res.data;
                    input_name_user.value = data.name
                    input_email.value = data.email
                    selectElement("select_role",data.id_roles);
                    selectElement("select_toko",data.toko_id);
                    
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.setAttribute('id', 'id_user_hidden');
                    input.setAttribute('value', id);
                    document.getElementById('form-user').appendChild(input); 
                    localStorage.setItem("id_user_hidden", id);
                    // console.log('detail-',id);
                    //create input tipe hidden for edit
                    // var input = document.createElement("input");
                    // input.type = "hidden";
                    // input.setAttribute('id', 'id_toko_hidden');
                    // input.setAttribute('value', parseInt(id));
                    // document.getElementById('form-toko').appendChild(input);
                    
                    
                    // console.log(idnya);
                    //create input tipe hidden for edit

                },
                error: function(xhr, status, msg) {
                    alert("Error detail");
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

        function deleteUser(id) {
            Swal.fire({
                title: "Yakin ingin menghapus user ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('user-delete') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                `Bearer ${localStorage.getItem("token")}`);
                        },
                        type: 'post',
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            )
                            $('#user-ajax-list').DataTable().ajax.reload(null, true);
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
