@extends('layout.admin_app')
@section('title')
 Product
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
   <div class="" style="margin-left:25px">
      <a href="#" id="add_product" class="btn">Tambah Product</a>

      <button class="btn btn-blue" data-toggle="modal2" data-target="#modal2">Click</button>
   </div>
   <section class="table__body">
      <table class="product-yajra">
         <thead>
            <tr>
               <th>No</th>
               <th>Name Product</th>
               <th>Kategori</th>
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

var modal = document.getElementById("modal2");
let navbar_atas = document.getElementsByClassName('top-bar');
let navbar_atas_id = document.getElementById('top-bar');
const navbar_samping_id = document.getElementById('sidebar');

const all_toogle = document.querySelectorAll('[data-toggle="modal2"]')
all_toogle.forEach(btn => {
   btn.addEventListener('click', function(e) {
      const name_ = document.getElementById('name_product')
      const id_kategori = document.getElementById('kategori_select')
      const harga_beli = document.getElementById('harga_beli')
      const cek_satuan = document.getElementById('is_kg')
      const berat = document.getElementById('total_satuan')
      const expired = document.getElementById('expired')

      name_.value=''
      harga_beli.value=''
      berat.value=''

      //ajax list kategori
      $.ajax({
         url: `{{route('kategori-list')}}`,
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         type: 'get',
         success: function(response){
            if (response.data.data.length > 0) {
               let html_opt = `<option value="0">- pilih kategori product-</option>`;
               response.data.data.forEach((e) => {
                  html_opt += `<option value="${e.id_kategori}">${e.nama_kategori}</option>`;
                  if($("#kategori_select")) {
                     $("#kategori_select").html(html_opt);
                  }
               });
            }
            
         },
         error: function(err){
            console.log('error',err);
         }
      })
      //ajax list kategori     
      e.preventDefault()
      const modal = document.querySelector(this.dataset.target)
      const modal_close = modal.querySelector('.modal__close_2')
      modal.classList.add('show-modal')

      navbar_atas_id.style.position = "initial";
      navbar_samping_id.style.position = "initial";

      modal_close.addEventListener('click', function(e){
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

$('#form-product').on("submit", function(e) {
   e.preventDefault(); 
   let name = $("#name_product").val();
   let id_kategori = $("#kategori_select").val();
   let harga_beli = $("#harga_beli").val();
   let cek_satuan = $('.is_kg:checked').val() == undefined ? 0 : 1; 
   let cek_box = $('.is_kg:checked').val();
   let berat = $("#total_satuan").val();
   let expired = $("#expired").val();
   if (id_kategori == '0') {
      $("#kategori_select").css('border-color','red')
   }
  
   let data_pcs = {
                     'nama_product' : name,
                     'kategori_id' : id_kategori,
                     'harga_beli' : harga_beli,
                     'is_kg' : cek_satuan,
                     'pcs':berat,
                     'expired':expired
                  };
   let data_kg = {
                  'nama_product' : name,
                  'kategori_id' : id_kategori,
                  'harga_beli' : harga_beli,
                  'is_kg' : cek_satuan,
                  'total_kg':berat,
                  'expired':expired
                  }
   $.ajax({
         type:'post',
         headers: {
         'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
         url:`{{route('product-add')}}`,
         data: cek_satuan == '1' ? data_kg : data_pcs,
         success:function(data) { 
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
         error:function(err){
            console.log(err);
         }
   });
});
</script>
<script type="text/javascript">
  $(function () { 
      var table = $('.product-yajra').DataTable({
         responsive: true,
         processing: true,
         serverSide: true,
         ajax: "{{ route('server-side-product') }}",
         columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
               {data: 'nama_product', name: 'nama_product'},
               {data: 'kategori', name: 'kategori'},
               {data: 'harga_beli', name: 'harga_beli'},
               {data: 'harga_jual', name: 'harga_jual'},
               {data: 'stock', name: 'stock'},
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
   function editProduct(id){
      console.log(id);
   }

   function editProductPrice(id){
    
   }

   function deleteKategori(id){
     
   }


  
         
</script>
@endpush
