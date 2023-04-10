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

@section('modal_global')
    @include('admin.toko.modal')
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
   const input_toko = document.getElementById("nama_toko")
   const all_toogle = document.querySelectorAll('[data-toggle="modaltoko"]')
   let navbar_atas_id = document.getElementById('top-bar');
   const navbar_samping_id = document.getElementById('sidebar');
   const modal = document.querySelector("#modaltoko")

   $("#add_toko").on("click",function(e){
     
      const modal_close = modal.querySelector('.modal__close_2')
      modal.classList.add('show-modal')
      navbar_atas_id.style.position = "initial";
      navbar_samping_id.style.position = "initial";
      input_toko.value = ""
      modal_close.addEventListener('click', function(e){
         e.preventDefault()
         modal.classList.remove('show-modal')
         navbar_atas_id.style.position = "fixed";
         navbar_samping_id.style.position = "fixed";
      })

      //ajax 
      if(document.getElementById("id_toko_hidden")){
         document.getElementById("id_toko_hidden").removeAttribute("id")
      }
   })

</script>
<script>

   $("#form-toko").on("submit",function(e){
      e.preventDefault()
      const cek_id =  document.getElementById('id_toko_hidden');
      
      let data_input = {
         'nama_toko' : input_toko.value
      }
      if (cek_id) {
         data_input.id_toko = localStorage.getItem('id_toko_hidden')
      }

      console.log();
      $.ajax({
         type:'post',
         data:data_input,
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         url:`{{route('post-toko')}}`,
         success:function(res){
            if (res.status == 'ok') {
               $('.toko-yajra').DataTable().ajax.reload(null, true);
                  Swal.fire(
                           'Add',
                           'Save data toko berhasil',
                           'success'
                        ).then((result) => {
                           if (result.isConfirmed) {
                              modal.classList.remove('show-modal')
                              navbar_atas_id.style.position = "fixed";
                              navbar_samping_id.style.position = "fixed";
                           } 
                        }) 
               }
         }
      })
      
   })

   function editToko(id){
      const modal = document.querySelector("#modaltoko")
      const modal_close = modal.querySelector('.modal__close_2')
      modal.classList.add('show-modal')
      navbar_atas_id.style.position = "initial";
      navbar_samping_id.style.position = "initial";

      input_toko.value = ""

      //ajax
      $.ajax({
         type:'post',
         data:{'id_toko':id},
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         url:`{{route('detail-toko')}}`,
         success:function(res){
            let data = res.data;
            input_toko.value = data.nama_toko
            //create input tipe hidden for edit
            var input = document.createElement("input");
            input.type = "hidden";
            input.setAttribute('id', 'id_toko_hidden');
            input.setAttribute('value', parseInt(id));
            document.getElementById('form-toko').appendChild(input); 
            localStorage.setItem("id_toko_hidden", id);
            const idnya  = localStorage.getItem("id_toko_hidden");
            console.log(idnya);
            //create input tipe hidden for edit
            
         },
         error:function(xhr,status, msg){

         }
      })
      //ajax

      modal_close.addEventListener('click', function(e){
         e.preventDefault()
         modal.classList.remove('show-modal')
         navbar_atas_id.style.position = "fixed";
         navbar_samping_id.style.position = "fixed";
      })
      console.log(id);
   }

function deleteToko(id){
   Swal.fire({
         title: "Yakin ingin menghapus toko ini ?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
         if (result.isConfirmed) {
               $.ajax({
                  url: `{{route('delete-toko')}}`,
                  headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  type: 'post',
                  data:{'id_toko':id},
                  success: function(response){
                     $('.toko-yajra').DataTable().ajax.reload(null, true);
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