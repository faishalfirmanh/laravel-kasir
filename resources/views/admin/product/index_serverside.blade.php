@extends('layout.admin_app')
@section('title')
    Product
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

        .style-price-buy {
            text-align: center;
            background: #51ffe2;
            border-radius: 5px;
            height: 23px;
            width: 70%;
            color: rgb(17, 13, 4);
            font-size: 13px;
            font-weight: bold;
        }

        .style-price-buy-problem{
            text-align: center;
            background: #e01b1b;
            border-radius: 5px;
            height: 23px;
            width: 70%;
            color: rgb(17, 13, 4);
            font-size: 13px;
            font-weight: bold;
        }

        .style-total-price {
            text-align: center;
            background: #53dfd1;
            border-radius: 5px;
            height: 15px;
            width: 10px;
            color: black;
            font-size: 13px;
            font-weight: bold;
        }
    </style>

    <div class="tables" style="margin-top:20px;">
        <div class="" style="margin-left:25px">
            {{-- <a href="#" id="add_product" class="btn">Tambah Product</a> --}}

            <button class="btn btn-blue" id="btn-modal-product" data-toggle="modal2" data-target="#modal2">Tambah product</button>
        </div>
        <section class="table__body">
            <table class="product-yajra" id="id-table-product" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name Product</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
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
    @include('admin.product.modal_prodct')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

$(document).ready(function() {
   $('#id-table-product').DataTable({
         "ajax": {
            "url": "{{ route('product-all-no-paginate') }}",
            "dataSrc": "data",
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

               if(xhr.status == 403) {
                    sweetAlertError("Tidak dapat akses menu product")
                    $("#id-table-product").html("");
                    $("#btn-modal-product").remove()
                }
            }
         },
         "columns": [{
               "data": "id_product"
            },
            {
               "data": "nama_product"
            },
            {
               "data": `kk`, render: function(data, type, row) {
                    if (row.price_buy_product_custom.length > 0 && row.harga_beli == 0) {
                        const kondisi_beli = `<div class="style-price-buy">custom (total ${row.price_buy_product_custom.length})</div>`;
                        return kondisi_beli;
                    }else if(row.harga_beli > 0 && row.price_buy_product_custom.length < 1){
                        const kondisi_beli = row.harga_beli;
                        return kondisi_beli;
                    }else{
                        const kondisi_beli = '<div class="style-price-buy-problem" style="backgroud-color:red;color:white">data bermasalah</div>';
                        return kondisi_beli;
                    }
                    
                }
            },
            {
               "data": `kondisi_price_jual`, render: function(data,type, row){
                    const total = row.price_sell_product.length < 1 
                    ? '<div class="style-price-buy-problem" style="backgroud-color:red;color:white"> no set </div>' : `${row.price_sell_product.length} (jenis)`;
                    const kondisi_price_jual = total;
                    return kondisi_price_jual;
               }
            },
            {
               "data": `kondisi_stock`, render: function(data, type, row) {
                    var total = row.pcs == null ? row.total_kg : row.pcs;
                    var satuan = row.pcs == null ? '(kg)' : '(pcs)';
                    var  kondisi_stock = `${total} ${satuan}` 
                    return kondisi_stock;
                }
            },
            {
               render: function(data, type, row) {
                     const cek = row.price_sell_product.length < 1 ?
                        `<i onclick="deleteProduct(${row.id_product})" class="far fa-trash-alt" style="background:red;margin-right:5px" title="delete-toko"></i>` :
                        '';
                    const btn_price_sell = `<a href="${row.route_url}" class="fas fa-money-bill" style="background:#b4a2fb;margin-right:10px;" title="price-product"></a>`;
                     return `<i onclick="editProduct(${row.id_product})" class="far fa-edit" style="margin-right:5px;"></i>` +
                        cek + btn_price_sell;
                     }
            }
         ]
   })
})

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });

        var modal = document.getElementById("modal2");
        let navbar_atas = document.getElementsByClassName('top-bar');
        let navbar_atas_id = document.getElementById('top-bar');
        const navbar_samping_id = document.getElementById('sidebar');


        //input
        const name_ = document.getElementById('name_product')
        const harga_beli = document.getElementById('harga_beli')
        const berat = document.getElementById('total_satuan')
        const is_kg_check = document.getElementById('is_kg')
        const expired = document.getElementById('expired')
        //input
        const all_toogle = document.querySelectorAll('[data-toggle="modal2"]')
        all_toogle.forEach(btn => {
            btn.addEventListener('click', function(e) {

                const id_kategori = document.getElementById('kategori_select')
                const cek_satuan = document.getElementById('is_kg')

                var date = new Date();
                let dateplust1day = date.setDate(date.getDate() + 2);
                var numDate = new Date(dateplust1day);

                name_.value = ''
                harga_beli.value = ''
                berat.value = ''
                expired.value = numDate.toDateInputValue();

                //ajax list kategori
                $.ajax({
                    url: `{{ route('kategori-all') }}`,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    type: 'get',
                    success: function(response) {
                        if (response.data.length > 0) {
                            let html_opt =
                                `<option value="0">- pilih kategori product-</option>`;
                            response.data.forEach((e) => {
                                html_opt +=
                                    `<option value="${e.id_kategori}">${e.nama_kategori}</option>`;
                                if ($("#kategori_select")) {
                                    $("#kategori_select").html(html_opt);
                                }
                            });
                        }

                    },
                    error: function(xhr,msg,err) {
                        const toJson = JSON.parse(xhr.responseText);
                        console.log('error', toJson);
                    }
                })
                //ajax list kategori     
                e.preventDefault()
                const modal = document.querySelector(this.dataset.target)
                const modal_close = modal.querySelector('.modal__close_2')
                modal.classList.add('show-modal')

                navbar_atas_id.style.position = "initial";
                navbar_samping_id.style.position = "initial";

                modal_close.addEventListener('click', function(e) {
                    e.preventDefault()
                    modal.classList.remove('show-modal')
                    navbar_atas_id.style.position = "fixed";
                    navbar_samping_id.style.position = "fixed";
                })
            })
        });

        // document.addEventListener('click',function(e){
        //    let tes = e.target.matches('.modal2');
        //    if (tes) {
        //       e.target.classList.remove('show-modal')   
        //    }
        // })

        function appendDelayedTextNode(element, text, delayMs) {
            setTimeout(function() {
                element.appendChild(document.createTextNode(text));
            }, delayMs);
        }
//tesd
        $('#form-product').on("submit", function(e) {
            e.preventDefault();
            let name = $("#name_product").val();
            let id_kategori = $("#kategori_select").val();
            let input_harga_beli = $("#harga_beli").val();
            let cek_satuan = $('.is_kg:checked').val() == undefined ? 0 : 1;
            let cek_box = $('.is_kg:checked').val();
            let berat = $("#total_satuan").val();
            let expired = $("#expired").val();
            if (id_kategori == '0') {
                $("#kategori_select").css('border-color', 'red')
            }

            const cek_id_product = document.getElementById('id_product_hidden');

            const harga_beli = input_harga_beli == '' ? 0 : input_harga_beli
            console.log(harga_beli);
            
            let data_pcs = {
                'nama_product': name,
                'kategori_id': id_kategori,
                'harga_beli': harga_beli,
                'is_kg': cek_satuan,
                'pcs': berat,
                'expired': expired
            };
            let data_kg = {
                'nama_product': name,
                'kategori_id': id_kategori,
                'harga_beli': harga_beli,
                'is_kg': cek_satuan,
                'total_kg': berat,
                'expired': expired
            }
            if (cek_id_product) {
                data_pcs.id_product = cek_id_product.value
                data_kg.id_product = cek_id_product.value
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('product-add') }}`,
                beforeSend: function (xhr) {
                     xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: cek_satuan == '1' ? data_kg : data_pcs,
                success: function(data) {
                    if (data.status == 'ok') {

                        $('.product-yajra').DataTable().ajax.reload(null, true);
                        Swal.fire(
                            'Add',
                            'Tambah data product berhasil',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                            }
                        })
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON.data.expired) {
                        console.log(xhr.responseJSON.data.expired);
                        let label_expired = document.getElementById('id_label_expired');
                        appendDelayedTextNode(label_expired, 'Tanggal tidak boleh kurang dari hari ini',
                            1000);
                    }


                }
            });
        });
    </script>
    <script type="text/javascript">
        //   $(function () { 
        //       var table = $('.product-yajra').DataTable({
        //          responsive: true,
        //          processing: true,
        //          serverSide: true,
        //          ajax: "{{ route('server-side-product') }}",
        //          columns: [
        //                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        //                {data: 'nama_product', name: 'nama_product'},
        //                {data: 'kategori', name: 'kategori'},
        //                {data: 'harga_beli', name: 'harga_beli'},
        //                {data: 'harga_jual', name: 'harga_jual'},
        //                {data: 'stock', name: 'stock'},
        //                {
        //                   data: 'action', 
        //                   name: 'action', 
        //                   orderable: false, 
        //                   searchable: false
        //                },
        //          ]
        //       });

        //    });
       
    </script>
    <script>
        function selectElement(id, valueToSelect) {
            let element = document.getElementById(id);
            element.value = valueToSelect;
        }
        //list kategori
        $.ajax({
            type: 'get',
            url: `{{ route('kategori-all') }}`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
            },
            success: function(response_list_kategori) {
                setTimeout(() => {
                    if (response_list_kategori.data.length > 0) {
                        let html_opt = `<option value="0">- pilih kategori product-</option>`;
                        response_list_kategori.data.forEach((e) => {
                            html_opt +=
                                `<option value="${e.id_kategori}">${e.nama_kategori}</option>`;
                            if ($("#kategori_select")) {
                                $("#kategori_select").html(html_opt);
                            }
                        });
                    }
                }, 1000);
               console.log(response_list_kategori);

            },
            error: function(xhr,msg,err) {
                console.log('error', xhr);
            }
        })
        //list kategori
        function editProduct(id) {
            $.ajax({
                type: "post",
                url: "{{ route('porudct-detailById') }}",
                beforeSend: function (xhr){
                     xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: {
                    'id_product': id
                },
                success: function(response) {
                    console.log(response.data);
                    //get
                    name_.value = response.data.nama_product;
                    harga_beli.value = response.data.harga_beli;
                    const cek_is_berat = response.data.is_kg == 0 ? response.data.pcs : response.data.total_kg;
                    berat.value = cek_is_berat
                    response.data.is_kg == 0 ? is_kg_check.checked = false : is_kg_check.checked = true;
                    selectElement('kategori_select', response.data.kategori_id)
                    let dd = new Date(Date.parse(response.data.expired));
                    expired.value = response.data.expired != null ? dd.toDateInputValue() : '';
                    //get
                    const h3_title = document.getElementById('title_modal').textContent = 'Update Product';
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.setAttribute('id', 'id_product_hidden');
                    input.setAttribute('value', id);
                    document.getElementById('form-product').appendChild(input);
                    const modal = document.querySelector('#modal2')
                    const modal_close = modal.querySelector('.modal__close_2')
                    modal.classList.add('show-modal')
                    navbar_atas_id.style.position = "initial";
                    navbar_samping_id.style.position = "initial";
                    modal_close.addEventListener('click', function(e) {
                        e.preventDefault()
                        input.remove()
                        modal.classList.remove('show-modal')
                        navbar_atas_id.style.position = "fixed";
                        navbar_samping_id.style.position = "fixed";
                    })
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        function editProductPrice(id) {
            //ajax get byid
            // const modal = document.querySelector('#modalPrice')
            // const modal_close = modal.querySelector('.modal__close_2')
            // const input_start_kg = document.getElementById('start_kg');
            // const input_end_kg = document.getElementById('end_kg');
            // const input_price = document.getElementById('price-sell');
            // modal.classList.add('show-modal')
            // navbar_atas_id.style.position = "initial";
            // navbar_samping_id.style.position = "initial";
            // modal_close.addEventListener('click', function(e){
            //       e.preventDefault()
            //       input_end_kg.value = ''
            //       input_start_kg.value = ''
            //       input_price.value = ''
            //       modal.classList.remove('show-modal')
            //       navbar_atas_id.style.position = "fixed";
            //       navbar_samping_id.style.position = "fixed";
            // })
            //ajax getbyid
        }

        function deleteProduct(id) {
            Swal.fire({
                title: "Yakin ingin menghapus product ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('product-delete') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                        },
                        type: 'post',
                        data: {
                            'id_product': id
                        },
                        success: function(response) {
                            $('.product-yajra').DataTable().ajax.reload(null, true);
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
@endpush
