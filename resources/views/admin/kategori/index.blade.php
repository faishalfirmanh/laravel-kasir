@extends('layout.admin_app')
@section('title')
kategori tess
@endsection

@section('table_content')
<div class="tables" style="margin-top:20px;">
   <section class="table__body">
      <table class="kategori-table" id="kategori_id">
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
   $(function (){ 
      // $('#kategori_id').dataTable( {
      //    "ajax": {
      //       "url": "{{ route('kategori-list') }}",
      //       "type": "get",
      //       "beforeSend": function (xhr) {
      //                   xhr.setRequestHeader("Authorization",
      //                      "Bearer " + Bearer `${localStorage.getItem("token")}`);
      //                   },
      //       "columns": [
      //                      { "data": response.data.data.nama_kategori },
      //                      { "data": "position" },
      //                      { "data": "office" },
      //                      { "data": "salary" }
      //                ]
      //    }
      // });
      $.ajax({
         type: "get",
         url:"{{ route('kategori-list') }}",
         beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
         },
         success: function(response){
            if (response.status  == 'Authorization Token not found') {
                alert("tidak ada hak akses");
                window.location.href = '{{route("home")}}'
            }else{
               console.log(response);
               let data_json = response.data
               console.log('sukses',data_json.data);
               var tbody = $('#kategori_id tbody');
               $.each(data_json.data, function(i, item) {
                  var row = $('<tr>').appendTo(tbody);
                  $('<td>').text(item.id_kategori).appendTo(row);
                  $('<td>').text(item.nama_kategori).appendTo(row);
                  $('<td>').text(item.product_relasi_kategori.length).appendTo(row);
               });
               
            }
           
         }
      })
   })
   console.log('tess');
   console.log(localStorage.getItem("token"));
</script>
@endpush    