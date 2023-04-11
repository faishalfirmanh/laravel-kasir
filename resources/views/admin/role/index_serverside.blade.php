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
      <a href="#" id="add_role" class="btn">Tambah Role</a>
   </div>
   <section class="table__body">
      <table class="role-yajra">
         <thead>
            <tr>
               <th>No</th>
               <th>Name Role</th>
               <th>Total User</th>
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
    @include('admin.role.modal')
@endsection

@push('scripts')
<script type="text/javascript">
   $(function () { 
       var table = $('.role-yajra').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          ajax: "{{ route('server-side-role') }}",
          columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name_role', name: 'name_role'},
                {data: 'total_user', name: 'total_user'},
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
<script type="text/javascript">
   
   const input_nama = document.getElementById('nama_role');
   const all_toogle = document.querySelectorAll('[data-toggle="modalrole"]')
   let navbar_atas_id = document.getElementById('top-bar');
   const navbar_samping_id = document.getElementById('sidebar');
   const modal = document.querySelector("#modalrole")
   //checkbox
   const checkedKategori = $("#is_kategori").val();
   const checkedProduct = $("#is_product").val();
   const checkedKasir = $("#is_kasir").val();
   const checkedLaporan = $("#is_laporan").val();

   $("#add_role").on("click",function(e){
     
      const modal_close = modal.querySelector('.modal__close_2')
      modal.classList.add('show-modal')
      navbar_atas_id.style.position = "initial";
      navbar_samping_id.style.position = "initial";
      input_nama.value = ""
      document.getElementById('is_kategori').checked = false;
      document.getElementById('is_product').checked = false;
      document.getElementById('is_laporan').checked = false;
      document.getElementById('is_kasir').checked = false;
      modal_close.addEventListener('click', function(e){
         e.preventDefault()
         modal.classList.remove('show-modal')
         navbar_atas_id.style.position = "fixed";
         navbar_samping_id.style.position = "fixed";
      })

      //ajax 
      if(document.getElementById("id_role_hidden_input")){
         document.getElementById("id_role_hidden_input").removeAttribute("id")
      }
   })


   $("#form-role").on("submit",function(e){
      e.preventDefault()
      const cek_id =  document.getElementById('id_role_hidden_input');
      
      let cek_kasir = document.getElementById('is_kasir').checked ? 1 : 0;
      let cek_product = document.getElementById('is_product').checked ? 1 : 0;
      let cek_laporan = document.getElementById('is_laporan').checked ? 1 : 0;
      let cek_kategori = document.getElementById('is_kategori').checked ? 1 : 0;
      
      let data_input = {
         'name_role' : input_nama.value,
         'kategori' :cek_kategori,
         'product' :cek_product,
         'kasir' : cek_kasir,
         'laporan' :cek_laporan
      }
      if (cek_id) {
         data_input.id = localStorage.getItem('id_role_hidden')
      }

      //console.log(data_input);
      $.ajax({
         type:'post',
         data:data_input,
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         url:`{{route('role-add')}}`,
         success:function(res){
            if (res.status == 'ok') {
               $('.role-yajra').DataTable().ajax.reload(null, true);
                  Swal.fire(
                           'Saved',
                           'Save data role berhasil',
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

   function editRole(id){
      const modal = document.querySelector("#modalrole")
      const modal_close = modal.querySelector('.modal__close_2')
      modal.classList.add('show-modal')
      navbar_atas_id.style.position = "initial";
      navbar_samping_id.style.position = "initial";

      input_nama.value = ""

      //ajax
      $.ajax({
         type:'post',
         data:{'id':id},
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         url:`{{route('role-detail')}}`,
         success:function(res){
            let data = res.data;
            input_nama.value = data.name_role
            console.log(data);
            //create input tipe hidden for edit
            var input = document.createElement("input");
            input.type = "hidden";
            input.setAttribute('id', 'id_role_hidden_input');
            input.setAttribute('value', parseInt(id));
            document.getElementById('form-role').appendChild(input); 
            localStorage.setItem("id_role_hidden", id);
            //create input tipe hidden for edit
            let cek_product = data.product == '1' ? $("#is_product").attr("checked", true) : $("#is_product").attr("checked", false)
            let cek_kasir = data.kasir == '1' ?  $("#is_kasir").attr("checked", true) : $("#is_kasir").attr("checked", false);
            let cek_laporan = data.laporan == '1' ? $("#is_laporan").attr("checked", true) : $("#is_laporan").attr("checked", false)
            let cek_kat = data.kategori == '1' ? document.getElementById("is_kategori").checked = true : document.getElementById("is_kategori").checked = false; 
            
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

function deleteRole(id){
   Swal.fire({
         title: "Yakin ingin menghapus role ini ?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
         if (result.isConfirmed) {
               $.ajax({
                  url: `{{route('role-delete')}}`,
                  headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  type: 'post',
                  data:{'id':id},
                  success: function(response){
                     $('.role-yajra').DataTable().ajax.reload(null, true);
                     Swal.fire(
                           'Deleted!',
                           'Your role has been deleted.',
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