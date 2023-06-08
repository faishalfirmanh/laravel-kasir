@extends('layout.admin_app')
@section('title')
    detail price product
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
        .fas.fa-money-bill,
        .far.fa-trash-alt:hover {
            cursor: pointer;
        }

        .style-pricenoset {
            text-align: center;
            background: #fc8c67;
            border-radius: 5px;
            height: 23px;
            width: 70%;
            color: wheat;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-tap-active {
            background: rgb(0, 255, 242);
            padding: 6px;
            border-radius: 5px;
            font-weight: bold;
            color: rgb(49, 49, 173);
        }

        .bg-div{
            text-align: center;
            background: #53dfd1;
            border-radius: 5px;
            height: 25px;
            width:100px;
            color: black;
            font-size: 13px;
            font-weight: bold;
        }
        .bg-div-price-custom{
            text-align: center;
            background: #6ee637;
            border-radius: 5px;
            height: 25px;
            width:auto;
            color: black;
            font-size: 13px;
            font-weight: bold;
        }
    </style>

    <h3 style="text-align: center;font-size:20px;">{{ $name }}</h3>
    <div style="margin-bottom: 25px">
        <button class="btn-tap-active" id="btn-jual">Product harga jual</button> &nbsp  &nbsp
        <button id="btn-beli">Product harga beli (kulak)</button>
    </div>

    <div class="tables" id="table_buy_div" style="display: none">
        <div class="" style="margin-left:25px">
            {{-- <a href="#" id="add_product" class="btn">Tambah Product</a> --}}
            <button class="btn btn-blue" onclick="openModalProductBeliCustom(0,0,0)">Tambah harga beli</button>
        </div>
        <section class="table__body" style=>
            <table class="" id="price-buy-table"  style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama variant</th>
                        <th>Harga beli</th>
                        <th>Telah digunakan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </div>

    <div class="tables" style="" id="table_sell_div">
        <div class="" style="margin-left:25px">
            {{-- <a href="#" id="add_product" class="btn">Tambah Product</a> --}}
            <button class="btn btn-blue" data-toggle="modalPrice" data-target="#modalPrice">Tambah price Jual</button>
        </div>
        <section class="table__body">
            <table class="product-price-yajra"  style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Start kg</th>
                        <th>End kg</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </div>
    <input type="hidden" id="id_prd" value="{{ $id }}">
@endsection

@section('modal_global')
    @include('admin.product.modal_price')
@endsection

@push('scripts')
    <script type="text/javascript">
         const idnya = $("#id_prd").val()
        // $(function() {
        //     var table = $('.product-price-yajra').DataTable({
        //         responsive: true,
        //         processing: true,
        //         serverSide: true,
        //         ajax: `{{ route('server-price-product', $id) }}`,
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //                 orderable: false,
        //                 searchable: false
        //             },
        //             {
        //                 data: 'start_kg',
        //                 name: 'start_kg'
        //             },
        //             {
        //                 data: 'end_kg',
        //                 name: 'end_kg'
        //             },
        //             {
        //                 data: 'price_sell',
        //                 name: 'price_sell'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             },
        //         ]
        //     });

        // });
        $(document).ready(function() {
            $('.product-price-yajra').DataTable({
                "ajax": {
                    "url": "{{ route('product-jual-byid-product') }}",
                    "dataSrc": "data",
                    "type" : 'post',
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            "Bearer " + `${localStorage.getItem("token")}`);
                    },
                    "data" : function(d) {
                        d.id_product = idnya;
                    },
                    "error": function(xhr, error, thrown) {
                        const toJson = JSON.parse(xhr.responseText);
                        console.log(toJson);
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
                    }
                },
                "columns": [{
                        "data": "id_product_jual"
                    },
                    {
                        "data": "start_kg"
                    },
                    {
                        "data": `end_kg`
                    },
                    {
                        "data" : "price_sell.toLocaleString()"
                    },
                    {
                        "data": `kondisi_beli`,
                        render: function(data, type, row) {
                            var cek = row.product_beli_id == null ? `default - (${row.product_name.harga_beli.toLocaleString()})` : `<div class="bg-div-price-custom">${row.product_beli_kulak.harga_beli_custom.toLocaleString()}</div>`;
                            var kondisi_beli = cek
                            return kondisi_beli;
                        }
                    },
                    {
                        render: function(data, type, row) {
                            const cek =  
                                `<i onclick="deleteProductPrice(${row.id_product_jual})" class="far fa-trash-alt" style="background:red;margin-right:5px" title="delete-toko"></i>`;
                               
                            return `<i onclick="editProductJual(${row.id_product_jual})" class="far fa-edit" style="margin-right:5px;"></i>` + cek ;
                        }
                    }
                ]
            })
        })
    </script>
    <script>
        const all_toogle = document.querySelectorAll('[data-toggle="modalPrice"]')
        var modal_global = document.getElementById("modalPrice");
        let navbar_atas = document.getElementsByClassName('top-bar');
        let navbar_atas_id = document.getElementById('top-bar');
        const navbar_samping_id = document.getElementById('sidebar');

        const input_price_sell = document.getElementById('price_sell');
        const input_start_kg = document.getElementById('start_kg');
        const input_end_kg = document.getElementById('end_kg');
        const input_price_buy = document.getElementById('price_buy')

        all_toogle.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault()
                const modal = document.querySelector(this.dataset.target)
                const modal_close = modal.querySelector('.modal__close_2')
                modal.classList.add('show-modal')

                input_price_sell.value = '';
                input_end_kg.value = '';
                input_start_kg.value = '';
                input_price_buy.value = 0;

                if (document.getElementById('id_product_jual_hidden')) {
                    document.getElementById("id_product_jual_hidden").outerHTML = "";
                }

                navbar_atas_id.style.position = "initial";
                navbar_samping_id.style.position = "initial";

                modal_close.addEventListener('click', function(e) {
                    e.preventDefault()
                    modal.classList.remove('show-modal')
                    navbar_atas_id.style.position = "fixed";
                    navbar_samping_id.style.position = "fixed";
                })

                //ajax
            })
        })

        function selectElement(id, valueToSelect) {
            let element = document.getElementById(id);
            element.value = valueToSelect;
        }

        function getListPriceBeliCustom(id_product,element_id_edit,id_value){
            return new Promise(function(resolve, reject) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: `{{ route('get-all-product-beli-no-used') }}`,
                    data: { 'product_id' : id_product },
                    type: 'post',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    success: function(data) {
                        if (data.status == 'ok'){
                            let total_list = data.data.length;
                            let html_opt = `<option value="0">- pilih variant harga (set kosong)-</option>`;
                            if (total_list > 0) {
                                data.data.forEach((e) => {
                                    html_opt +=
                                        `<option value="${e.id_product_beli}">${e.nama_product_variant} ( ${e.harga_beli_custom.toLocaleString()} ) </option>`;
                                });
                            }else{
                                html_opt +=
                                        `<option value="0">Tidak di set custom</option>`;
                            }
                            if ($("#price_buy")) {
                                //$("#price_buy").html(html_opt)
                                if (element_id_edit !== null){
                                    html_opt += element_id_edit
                                }
                                resolve($("#price_buy").html(html_opt))
                                
                                if (element_id_edit !== null) {
                                    $('#price_buy').val(id_value);
                                }
                               
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        reject(error)
                    }
                });
            })
        }

        getListPriceBeliCustom($("#id_prd").val(),null,null);

        // if (parseInt(input_price_buy.value) > 0) {
        //     const input_price_buy_kondisi = parseInt(input_price_buy.value)
        // }else{
        //     const input_price_buy_kondisi = null;
        // }
       
        //console.log(input_price_buy_kondisi);
        $('#form-product-price').on("submit", function(e) {
            e.preventDefault();
            let cek_input_price_buy = parseInt(input_price_buy.value) > 0 ? parseInt(input_price_buy.value) : null;
           
            let input_data = {
                'product_id': parseInt($("#id_prd").val()),
                'start_kg': input_start_kg.value,
                'end_kg': input_end_kg.value,
                'price_sell': input_price_sell.value,
                'product_beli_id' : cek_input_price_buy
            }

            //console.log(cek_input_price_buy);
            const cek_id_for_update = document.getElementById('id_product_jual_hidden');
            if (cek_id_for_update) {
                input_data.id = localStorage.getItem('id_product_jual') //cek_id_for_update.value
            }

    
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('product-jual-save') }}`,
                data: input_data,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 'ok') {
                        $('.product-price-yajra').DataTable().ajax.reload(null, true);
                        $("#price-buy-table").DataTable().ajax.reload(null, true);
                        Swal.fire(
                            'Add',
                            'Simpan data product jual berhasil',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal_global.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                            }
                        })
                    }
                },
                error: function(xhr, status, error) {
                    const json_res_ajax =  JSON.parse(xhr.responseText);
                    if (json_res_ajax.data.product_beli_id) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text:json_res_ajax.data.product_beli_id[0],
                        })   
                    }
                  
                }
            });
        })

        function editProductJual(id) {
          
           // setTimeout(() => {
                const modal = document.querySelector('#modalPrice')
                const modal_close = modal.querySelector('.modal__close_2')
                modal.classList.add('show-modal')
                navbar_atas_id.style.position = "initial";
                navbar_samping_id.style.position = "initial";
                modal_close.addEventListener('click', function(e) {
                    e.preventDefault()
                    input_end_kg.value = ''
                    input_start_kg.value = ''
                    input_price_sell.value = ''
                    modal_global.classList.remove('show-modal')
                    navbar_atas_id.style.position = "fixed";
                    navbar_samping_id.style.position = "fixed";
                })
            //}, 500);

            //ajax get
           setTimeout(() => {
                $.ajax({
                    type: "post",
                    url: `{{ route('product-jual-byid') }}`,
                    data: {
                        'id_product_jual': id
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    success: function(response) {
                        
                        input_end_kg.value = response.data.end_kg;
                        input_start_kg.value = response.data.start_kg;
                        input_price_sell.value = response.data.price_sell;
                        const cek_select_price_beli = response.data.product_beli_id == undefined ? 0 : response.data.product_beli_id
                        if (cek_select_price_beli > 0) {
                            $.ajax({
                                url: `{{ route('get-product-beliById') }}`,
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader('Authorization',
                                        `Bearer ${localStorage.getItem("token")}`);
                                },
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                type: 'post',
                                data: {
                                    'id_product_beli': cek_select_price_beli
                                },
                                success: function(response) {
                                if (response.status == 'ok') {
                                    const name__ = response.data.nama_product_variant;
                                    const harga__ = response.data.harga_beli_custom;
                                    //dom and slect, ajax get-product-beliById bisa dipisah dijadikan 1 function
                                    let element_html_default = `<option value="${cek_select_price_beli}">
                                                                    ${name__} ( ${harga__.toLocaleString()} )
                                                                </option>`
                                    getListPriceBeliCustom($("#id_prd").val(),element_html_default,cek_select_price_beli)
                                    //end
                                }
                                },
                                error: function(err) {
                                    console.log('error detail', err);
                                }
                            })
                        }else{
                            selectElement('price_buy',null)
                        }
                    
                        //add input hidden id
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.setAttribute('id', 'id_product_jual_hidden');
                        input.setAttribute('value', id);
                        document.getElementById('form-product-price').appendChild(input);
                        localStorage.setItem("id_product_jual", id);
                        //add input hidden id
                    }
                });
           }, 400);
            //ajax get
        }

        function deleteProductPrice(id) {
            Swal.fire({
                title: "Yakin ingin menghapus price product ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('product-jual-remove') }}`,
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                `Bearer ${localStorage.getItem("token")}`);
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: 'post',
                        data: {
                            'id_product_jual': id
                        },
                        success: function(response) {
                            $('.product-price-yajra').DataTable().ajax.reload(null, true);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        },
                        error: function(err) {
                            console.log('error', err);
                        }
                    })
                }
            })
        }
    </script>
    <script>
        /*--- api get price beli ***/
        const id_prodd =  $("#id_prd").val()

        const btn_jual = document.getElementById('btn-jual')
        const btn_beli = document.getElementById('btn-beli')
        const div_beli = document.getElementById('table_buy_div');
        const div_jual = document.getElementById('table_sell_div')

        btn_beli.addEventListener('click', function(e) {
            btn_beli.setAttribute('class', 'btn-tap-active')
            btn_jual.classList.remove('btn-tap-active');
            div_beli.style.display = 'block';
            div_jual.style.display = 'none';

        })

        btn_jual.addEventListener('click', function(e) {
            btn_jual.setAttribute('class', 'btn-tap-active')
            btn_beli.classList.remove('btn-tap-active');
            div_beli.style.display = 'none';
            div_jual.style.display = 'block';
        })


        $(document).ready(function() {
            $('#price-buy-table').DataTable({
                "ajax": {
                    "url": "{{ route('get-all-product-beli') }}",
                    "dataSrc": "data",
                    "type" : 'post',
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            "Bearer " + `${localStorage.getItem("token")}`);
                    },
                    "data" : function(d) {
                        d.product_id = id_prodd;
                    },
                    "error": function(xhr, error, thrown) {
                        console.log('get all',xhr);
                        if (xhr.responseText) {
                            const toJson = JSON.parse(xhr.responseText);
                            console.log('product-buy',toJson);
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
                        }
                    }
                },
                "columns": [{
                        "data": "id_product_beli"
                    },
                    {
                        "data": "nama_product_variant"
                    },
                    {
                        "data": `harga_beli_custom`
                    },
                    {
                        "data": `kondisi_set`,
                        render: function(data, type, row) {
                            var cek = row.get_product_jual == null ? 'tidak diset' : '<div class="bg-div">diset</div>';
                            var kondisi_set = cek
                            return kondisi_set;
                        }
                    },
                    {
                        render: function(data, type, row) {
                            const cek =  row.get_product_jual == null ?
                                `<i onclick="deleteProductBeli(${row.id_product_beli})" class="far fa-trash-alt" style="background:red;margin-right:5px" title="delete-toko"></i>` :
                                '';
                            return `<i onclick="editProductBeli(${row.id_product_beli})" class="far fa-edit" style="margin-right:5px;"></i>` + cek ;
                        }
                    }
                ]
            })
        })

        function openModalProductBeliCustom(id=0,name,harga){
            const modal_price_beli = document.querySelector("#modalPriceBuy")
            const modal_close = modal_price_beli.querySelector('.modal__close_2_price_buy')
            let navbar_atas_id = document.getElementById('top-bar');
            const navbar_samping_id = document.getElementById('sidebar');
           
            const field_name_variant = document.getElementById('nama_variant'); 
            const field_price_buy = document.getElementById('price_buy_custom');

            modal_price_beli.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";

            modal_close.addEventListener('click', function(e) {
                e.preventDefault()
                modal_price_beli.classList.remove('show-modal')
                navbar_atas_id.style.position = "fixed";
                navbar_samping_id.style.position = "fixed";
            })
           
            if (parseInt(id) > 0) {
                field_name_variant.value = name;
                field_price_buy.value = harga;
            }else{
                field_name_variant.value = '';
                field_price_buy.value = '';
            }
            
            $('#form-product-price-buy').on("submit", function(e) {
                e.preventDefault();
                ajaxSaveHargaBeliCustom(id,field_name_variant.value,field_price_buy.value)
                // modal_price_beli.classList.remove('show-modal')
                // navbar_atas_id.style.position = "fixed";
                // navbar_samping_id.style.position = "fixed";
            })
        }

        function ajaxSaveHargaBeliCustom(id_product_beli = 0, name, harga){

            const modal_price_beli = document.querySelector("#modalPriceBuy")
            const modal_close = modal_price_beli.querySelector('.modal__close_2_price_buy')
            let navbar_atas_id = document.getElementById('top-bar');
            const navbar_samping_id = document.getElementById('sidebar');

            const save_data  = {
                'nama_product_variant' : name,
                'harga_beli_custom' : harga,
                'product_id' : id_prodd
            }
          
            if (id_product_beli > 0) {
                save_data.id = id_product_beli;
            }
            
            $.ajax({
                url: `{{ route('save-product-beli') }}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization',
                        `Bearer ${localStorage.getItem("token")}`);
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                data: save_data,
                success: function(response) {
                   if (response.status == 'ok') {
                        Swal.fire(
                            'SAVE!',
                            'Your product beli has been Saved.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal_price_beli.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                                //$('#price-buy-table').DataTable().ajax.reload(null, true);
                                location.reload();
                            }
                        })
                       
                   }
                  
                },
                error: function(xhr, status, error) {
                    const toJsonError = JSON.parse(xhr.responseText);
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.data.nama_product_variant) {
                            alert("Gagal nama variatn sudah digunakan");
                        }
                        if (xhr.responseJSON.data.harga_beli_custom) {
                            alert(toJsonError.data.harga_beli_custom[0]);
                        }
                    }
                    
                }
            })
        }

        function editProductBeli(id){
            $.ajax({
                url: `{{ route('get-product-beliById') }}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization',
                        `Bearer ${localStorage.getItem("token")}`);
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                data: {
                    'id_product_beli': id
                },
                success: function(response) {
                   if (response.status == 'ok') {
                      const name = response.data.nama_product_variant;
                      const harga = response.data.harga_beli_custom;
                      openModalProductBeliCustom(id,name,harga)
                   }
                },
                error: function(err) {
                    console.log('error detail', err);
                }
            })
        }

        function deleteProductBeli(id){
            const modal_price_beli = document.querySelector("#modalPriceBuy")
            const modal_close = modal_price_beli.querySelector('.modal__close_2_price_buy')
            let navbar_atas_id = document.getElementById('top-bar');
            const navbar_samping_id = document.getElementById('sidebar');
            
            $.ajax({
                url: `{{ route('delete-product-beli') }}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization',
                        `Bearer ${localStorage.getItem("token")}`);
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                data: {
                    'id_product_beli': id
                },
                success: function(response) {
                   if (response.status == 'ok') {
                        Swal.fire(
                            'Deleted!',
                            'Your product beli has been delete.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal_price_beli.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                                $('#price-buy-table').DataTable().ajax.reload(null, true);
                                //location.reload();
                            }
                        })
                   }
                },
                error: function(err) {
                    console.log('error detail', err);
                }
            })
        }
    </script>
@endpush
