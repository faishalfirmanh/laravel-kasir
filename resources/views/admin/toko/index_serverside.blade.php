@extends('layout.admin_app')
@section('title')
 Toko
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
      <a href="#" id="add_toko" class="btn">Tambah Toko</a>
   </div>
   <section class="table__body">
      <table class="toko-yajra">
         <thead>
            <tr>
               <th>No</th>
               <th>Name Toko</th>
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
        var table = $('.toko-yajra').DataTable({
           responsive: true,
           processing: true,
           serverSide: true,
           ajax: "{{ route('server-side-toko') }}",
           columns: [
                 {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                 {data: 'nama_toko', name: 'nama_toko'},
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
   function editToko(id){

   }

   function deleteToko(id){
      
   }
</script>
@endpush