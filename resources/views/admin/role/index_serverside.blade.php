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
      <a href="#" id="add_toko" class="btn">Tambah Role</a>
   </div>
   <section class="table__body">
      <table class="role-yajra">
         <thead>
            <tr>
               <th>No</th>
               <th>Name Role</th>
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
   
</script>
@endpush