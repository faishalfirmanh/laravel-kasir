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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
      $.ajax({
            type:'post',
            headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
            url:`{{route('product-jual-byid-product')}}`,
            data:{'id_product' : id},
            success:function(data) { 
               console.log(data.data);
               Swal.fire({
                  title: 'Tambah Kategori',
                  html: `<input type="text" id="name_kategori" class="swal2-input" placeholder="nama kategori">`,
                  confirmButtonText: 'Save',
                  showCancelButton: true,
                  cancelButtonColor: '#d33',
                  focusConfirm: true,
               }).then((result) => {
               
               })
            },
            error:function(err){
               console.log(err);
            }
      });
   }

   function deleteKategori(id){
     
   }


   $( "#add_product" ).click(function() {
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

     
      function cekValidasi(name,select,beli,berat,expired){
         if (name == '') {
            Swal.showValidationMessage(`Input nama tidak boleh kosong`)
         }
         if (select == 0) {
            Swal.showValidationMessage(`Input kategori tidak boleh kosong`)
         }
         if (beli == '') {
            Swal.showValidationMessage(`Input harga tidak boleh kosong`)
         }
         if (berat == '') {
            Swal.showValidationMessage(`Input total berat tidak boleh kosong`)
         }
         if (expired == '') {
            Swal.showValidationMessage(`Input expired tidak boleh kosong`)
         }
         if (new Date(expired) < new Date()) {
            Swal.showValidationMessage(`Input expired tidak boleh kurang dari hari ini`)
         }
      }


      Swal.fire({
         title: 'Tambah Product',
         html: `<input type="text" id="name_product" class="swal2-input" placeholder="nama product">
               <select  name="" id="kategori_select" class="swal2-input" required>	
               <input type="text" id="harga_beli" class="swal2-input" placeholder="harga beli">
               <label style='align:left'>Pilih satuan kg</label>
               <input type="checkbox" class="is_kg" id="is_kg" name="is_kg">
               <input type="text" id="total_satuan" class="swal2-input" placeholder="total berat / pcs">
               <input type="date" id="expired" class="swal2-input">`,
         confirmButtonText: 'Save',
         focusConfirm: true,
         preConfirm: () => {
            let btn_save = document.getElementsByClassName('swal2-confirm')
            let name = $("#name_product").val();
            let id_kategori = $("#kategori_select").val();
            let harga_beli = $("#harga_beli").val();
            let cek_satuan = $('.is_kg:checked').val() == undefined ? 0 : 1; 
            let berat = $("#total_satuan").val();
            let expired = $("#expired").val();
            cekValidasi(name,id_kategori,harga_beli,berat,expired)
           
           
         }
         }).then((result) => {

            let btn_save = document.getElementsByClassName('swal2-confirm')
            let name = $("#name_product").val();
            let id_kategori = $("#kategori_select").val();
            let harga_beli = $("#harga_beli").val();
            let cek_satuan = $('.is_kg:checked').val() == undefined ? 0 : 1; 
            let berat = $("#total_satuan").val();
            let expired = $("#expired").val();
           
            
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
                           )
                  }
                },
                error:function(err){
                  console.log(err);
                }
            });
      })

   });
         
</script>
@endpush
