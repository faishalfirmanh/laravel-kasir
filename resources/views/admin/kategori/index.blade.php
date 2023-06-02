@extends('layout.admin_app')
@section('title')
kategori tess
@endsection

@section('table_content')
<style>
   body{

      background-color: #eee; 
   }

   table th , table td{
      text-align: center;
   }

   table tr:nth-child(even){
      background-color: #f0a6f9
   }

   .pagination li:hover{
      cursor: pointer;
   }
   table tbody tr {
      /* display: none; */
   }

   *{
      list-style-type: none !important;
   }

   .active{
      border: 1px solid;
      padding: 10px;
      margin-left: 5px;
      background-color: #f0a6f9;
      border-radius: 10px;
   }
   .dt-page{
      border: 1px solid;
      padding: 10px;
      margin-left: 5px;
      border-radius: 10px;
   }
  .pagination-mobile{
    margin-left: 25px;
  }

   @media only screen and (max-width: 600px) {
    .table-mobile{
      width: 55%;
    }
    .pagination-mobile{
      margin-left: 5px;
    }
  }
   

</style>

<div class="tables" style="margin-top:20px;">
	<div class="last-appointments table-mobile">
	<section class="table__body">
			<div class="heading">
				<h2>Kategori</h2>
			</div>
			<div class="form-group"> 	<!--		Show Numbers Of Rows 		-->
						<select class  ="form-control" name="state" id="maxRows" style="border-radius: 10px;height: 40px; margin-top: 20px; display:none;">
							
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="15">15</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="70">70</option>
							<option value="100">100</option>
							</select>
					</div>
		<table class="kategori-table" id="kategori_id">
			<thead>
				<tr>
				
				<th>Name Kategori</th>
				<th>Total Product</th>
				<th>Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</section>
	<div class='pagination-container pagination-mobile' style="">
				<nav>
				   <ul class="pagination" style="display: flex;margin-top: 30px;">
                  <li data-page="prev" class="dt-page" id="btn_prev">
                     <span> < <span class="sr-only">(current)</span></span>
                  </li>
				   
                   <li data-page="next" id="prev" class="dt-page">
                     <span> > <span class="sr-only">(current)</span></span>
                  </li>
				  </ul>
				</nav>
			</div>
	</div>
</div>

			
@endsection

@push('scripts')
<script type="text/javascript">
	
  var tabletes = $(function (){ 
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


		var xi = localStorage.getItem("pagess");
    
		var sec_limit = $('#maxRows').val;
    var lim = localStorage.getItem("maxRows");
    console.log('cek', lim);
		if(xi != null){
			$('.pagination [data-page="'+ xi +'"]').addClass('active'); // add active class to the first li
		}else{
			$('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
		}
      $.ajax({
         type: "post",
         url:"{{ route('kategori-list') }}",
         data: {'limit' : lim, 'page' : xi, 'keyword' : ''},
         beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
         },
         success: function(response){
            if (response.status  == 'Authorization Token not found') {
                alert("tidak ada hak akses");
                window.location.href = '{{route("home")}}'
            }else{
               console.log(response);
               let data_json = response.data[0].data
               console.log('sukses',data_json);
               localStorage.setItem("total_page", data_json.total_page);
               var tbody = $('#kategori_id tbody');
               $.each(data_json.data, function(i, item) {
                  var row = $('<tr>').appendTo(tbody);
                  $('<td>').text(item.id_kategori).appendTo(row);
                  $('<td>').text(item.nama_kategori).appendTo(row);
                  $('<td>').text(item.product_relasi_kategori.length).appendTo(row);
                  $('<td>').appendTo(row);
               });
				//for (var page = 0; page < data_json.total_page; page++) {
					//console.log("button", page);
				//}  
            }
           
         }
      })
   })
   //console.log('tess');
   //console.log(localStorage.getItem("token"));
	
   	

   	
	
//$("#maxRows").change(function(){
  //alert("The text has been changed.");
  //tabletes.$.ajax.reload();
//});

   getPagination('#kategori_id');

function getPagination(table) {
  var lastPage = 1;

  $('#maxRows')
    .on('change', function(evt) {
      //$('.paginationprev').html('');						// reset pagination

     lastPage = 1;
      $('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
      var trnum = 0; // reset tr counter
      var maxRows = parseInt($(this).val()); // get Max Rows from select option
		console.log('maxRows',maxRows)
    localStorage.setItem("maxRows", maxRows);
    //location.reload();
      if (maxRows == 5000) {
        $('.pagination').hide();
      } else {
        $('.pagination').show();
      }

      //var totalRows = $(table + ' tbody tr').length; // numbers of rows
	  var totalRows = 32;
	  console.log('totalRows', totalRows);
      $(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
        if (trnum > maxRows) {
          // if tr number gt maxRows

          $(this).hide(); // fade it out
        }
        if (trnum <= maxRows) {
          $(this).show();
        } // else fade in Important in case if it ..
      }); //  was fade out to fade it in
      if (totalRows > maxRows) {
        // if tr total rows gt max rows option
        var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
        //	numbers of pages
        for (var i = 1; i <= pagenum; ) {
          // for each page append pagination li
          $('.pagination #prev')
            .before(
              '<li data-page="' +
                i +
                '" class="dt-page" onclick="klickpage()">\
								  <span>' +
                i++ +
                '<span class="sr-only">(current)</span></span>\
								</li>'
            )
            .show();
        } // end for i
      } // end if row count > max rows
	  //$('.pagination [data-page=""]').addClass('active'); // add active class to the first li
      $('.pagination li').on('click', function(evt) {
        // on click each page
        evt.stopImmediatePropagation();
        evt.preventDefault();
        var pageNum = $(this).attr('data-page'); // get it's number
		
        if(pageNum == 'next'){
           //console.log('total_pagennya', localStorage.getItem("total_page"));
          var jumlahpage = localStorage.getItem("total_page")
          var page_old = localStorage.getItem("pagess");

          if(jumlahpage <= page_old){
            localStorage.setItem("pagess", page_old);
            console.log('batas');
            location.reload();
          }else{
          console.log('pagesold', (parseInt(page_old) + parseInt(1)));
          localStorage.setItem("pagess", (parseInt(page_old) + parseInt(1)));
          location.reload();
          }
	        
          //location.reload();
        }else if(pageNum == 'prev'){
          var page_old = localStorage.getItem("pagess");
	        console.log('pagesold', (parseInt(page_old) + parseInt(1)));
          if(page_old <=1){
            localStorage.setItem("pagess", 1);
            document.getElementById("btn_prev").display = true;
            location.reload();
          }else{
            localStorage.setItem("pagess", (parseInt(page_old) - parseInt(1)));
            location.reload();
          }
          
          
        }else{
          localStorage.setItem("pagess", pageNum);
          location.reload();
        }
        
		      console.log('pageNum',pageNum)
        var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

        // if (pageNum == 'prev') {
        //   location.reload();
        //   if (lastPage == 1) {
        //     return;
        //   }
        //   pageNum = --lastPage;
        // }
        // if (pageNum == 'next') {
        //   //location.reload();
        //   var xi = localStorage.getItem("pagess");
        //   console.log('klik', xi);
          
        //   if (lastPage == $('.pagination li').length - 2) {
        //     return;
        //   }
        //   pageNum = ++lastPage;
        // }

        lastPage = pageNum;
        var trIndex = 0; // reset tr counter
        $('.pagination li').removeClass('active'); // remove active class from all li
        //$('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
        // $(this).addClass('active');					// add active class to the clicked
	  	limitPagging();
        $(table + ' tr:gt(0)').each(function() {
          // each tr in table not the header
          trIndex++; // tr index counter
          // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
          if (
            trIndex > maxRows * pageNum ||
            trIndex <= maxRows * pageNum - maxRows
          ) {
            $(this).hide();
          } else {
            $(this).show();
          } //else fade in
        }); // end of for each tr in table
      }); // end of on click pagination list
	  limitPagging();
    })
    
    .val(10)
    .change();
	

  // end of on select change

  // END OF PAGINATION
}

function limitPagging(){
	// alert($('.pagination li').length)

	if($('.pagination li').length > 5 ){
    //console.log('aaa', $('.pagination li').length)
			if( $('.pagination li.active').attr('data-page') <= 3 ){
			$('.pagination li:gt(5)').hide();
			$('.pagination li:lt(5)').show();
			$('.pagination [data-page="next"]').show();
		}if ($('.pagination li.active').attr('data-page') > 3){
			$('.pagination li:gt(0)').hide();
			$('.pagination [data-page="next"]').show();
			for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
				$('.pagination [data-page="'+i+'"]').show();

			}

		}
	}
}

$(function() {
  // Just to append id number for each row
  $('table tr:eq(0)').prepend('<th> No </th>');

  var id = 0;

  $('table tr:gt(0)').each(function() {
    id++;
    $(this).prepend('<td>' + id + '</td>');
  });
});


var xi = localStorage.getItem("pagess");
	console.log('pages', xi);
function klickpage() {
	
        location.reload();
        
    }
</script>
@endpush    