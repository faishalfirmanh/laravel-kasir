
@extends('layout.admin_app')
@section('title')
 detail price product
@endsection


@section('table_content')
    <style>
        .dataTables_wrapper .dataTables_filter{
            margin-top: 20px;
            margin-right: 10px;
        }
        .dataTables_length{
            margin-top: 20px;
            margin-left: 15px;
        }
        .far.fa-edit,
        .fas.fa-money-bill,
        .far.fa-trash-alt:hover{
                cursor: pointer;
        }
        .style-pricenoset{
            text-align: center;
            background: #fc8c67;
            border-radius: 5px;
            height: 23px;
            width: 70%;
            color: wheat;
            font-size: 13px;
            font-weight: bold;
        }
    </style>

<div class="tables" style="margin-top:20px;">
    <h3 style="text-align: center">{{$name}}</h3>
   <div class="" style="margin-left:25px">
      {{-- <a href="#" id="add_product" class="btn">Tambah Product</a> --}}
      <button class="btn btn-blue" data-toggle="modalPrice" data-target="#modalPrice">Tambah price</button>
   </div>
   <section class="table__body">
      <table class="product-price-yajra">
         <thead>
            <tr>
               <th>No</th>
               <th>Start kg</th>
               <th>End kg</th>
               <th>Harga Jual</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </section>
</div>
<input type="hidden" id="id_prd" value="{{$id}}">
@endsection

@section('modal_global')
@include('admin.product.modal_price')
@endsection

@push('scripts')
<script type="text/javascript">
const idnya = $("#id_prd").val()
    $(function () { 
        var table = $('.product-price-yajra').DataTable({
           responsive: true,
           processing: true,
           serverSide: true,
           ajax: `{{ route('server-price-product',$id) }}`,
           columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                 {data: 'start_kg', name: 'start_kg'},
                 {data: 'end_kg', name: 'end_kg'},
                 {data: 'price_sell', name: 'price_sell'},
                 {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                 },
           ]
        });
        
     });
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

            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";

            modal_close.addEventListener('click', function(e){
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
            'product_id' : parseInt($("#id_prd").val()),
            'start_kg' : input_start_kg.value,
            'end_kg' : input_end_kg.value,
            'price_sell' : input_price_sell.value
        }

        const cek_id_for_update = document.getElementById('id_product_jual_hidden');
        if (cek_id_for_update) {
            input_data.id_product_jual = cek_id_for_update.value
        }

        $.ajax({
            type:'post',
            headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
            url:`{{route('product-jual-save')}}`,
            data: input_data,
            success:function(data) { 
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
            error:function(xhr, status, error){
                
            }
        });
     })

     function editProductJual(id){
       setTimeout(() => {
            const modal = document.querySelector('#modalPrice')
            const modal_close = modal.querySelector('.modal__close_2')
            modal.classList.add('show-modal')
            navbar_atas_id.style.position = "initial";
            navbar_samping_id.style.position = "initial";
            modal_close.addEventListener('click', function(e){
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
            url:`{{ route('product-jual-byid') }}`,
            data:{'id_product_jual':id},
            success: function(response){
                console.log(response.data);
                input_end_kg.value = response.data.end_kg;
                input_start_kg.value = response.data.start_kg;
                input_price_sell.value = response.data.price_sell;

                //add input hidden id
                var input = document.createElement("input");
                input.type = "hidden";
                input.setAttribute('id', 'id_product_jual_hidden');
                input.setAttribute('value', id);
                document.getElementById('form-product-price').appendChild(input); 
                //add input hidden id
            }
        });
        //ajax get
     }
</script>
@endpush
