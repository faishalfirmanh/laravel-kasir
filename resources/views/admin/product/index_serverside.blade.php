@extends('layout.admin_app')
@section('title')
 kategori
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
   .far.fa-trash-alt:hover{
        cursor: pointer;
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
               <th>Harga Beli</th>
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
               {data: 'harga_beli', name: 'harga_beli'},
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
   function editKategori(id){
      console.log(id);
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
               let html_opt = `<option value="">- pilih kategori product-</option>`;
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

         Swal.fire({
         title: 'Tambah Product',
         html: `<input type="text" id="name_product" class="swal2-input" placeholder="nama product">
               <select  name="" id="kategori_select" class="swal2-input" required>	
               <input type="text" id="harga_beli" class="swal2-input" placeholder="harga beli">`,
         confirmButtonText: 'Save',
         focusConfirm: false,
         preConfirm: () => {
            
         }
         }).then((result) => {
            console.log(result);
         })

   });
         
</script>
@endpush
