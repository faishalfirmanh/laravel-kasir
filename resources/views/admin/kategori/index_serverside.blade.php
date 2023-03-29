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
   <section class="table__body">
      <table class="kategori-yajra">
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
  $(function () { 
      var table = $('.kategori-yajra').DataTable({
         responsive: true,
         processing: true,
         serverSide: true,
         ajax: "{{ route('server-side-kategori') }}",
         columns: [
               {data: 'no', name: 'no'},
               {data: 'nama_kategori', name: 'nama_kategori'},
               {data: 'totalProduct', name: 'totalProduct'},
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
                    url: `{{route('kategori-delete')}}`,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'post',
                    data:{'id_kategori':id},
                    success: function(response){
                        $('.kategori-yajra').DataTable().ajax.reload(null, true);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    error: function(err){
                        console.log('error',err);
                    }
                })                
            }
        })
   }
</script>
@endpush
