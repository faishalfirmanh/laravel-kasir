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
            <button class="btn btn-blue" data-toggle="modalPriceBuy" data-target="#modalPriceBuy">Tambah harga beli</button>
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

        all_toogle.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault()
                const modal = document.querySelector(this.dataset.target)
                const modal_close = modal.querySelector('.modal__close_2')
                modal.classList.add('show-modal')

                input_price_sell.value = '';
                input_end_kg.value = '';
                input_start_kg.value = '';

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

        $('#form-product-price').on("submit", function(e) {
            e.preventDefault();
            let input_data = {
                'product_id': parseInt($("#id_prd").val()),
                'start_kg': input_start_kg.value,
                'end_kg': input_end_kg.value,
                'price_sell': input_price_sell.value
            }

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
                        Swal.fire(
                            'Add',
                            'Tambah data product berhasil',
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
                    console.log('error save',xhr);
                }
            });
        })

        function editProductJual(id) {
            console.log(id);
            setTimeout(() => {
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
            }, 500);

            //ajax get
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
                                `<i onclick="" class="far fa-trash-alt" style="background:red;margin-right:5px" title="delete-toko"></i>` :
                                '';
                            return `<i onclick="" class="far fa-edit" style="margin-right:5px;"></i>` + cek ;
                        }
                    }
                ]
            })
        })
    </script>
@endpush
