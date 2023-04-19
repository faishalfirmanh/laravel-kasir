
@extends('layout.admin_app')
@section('title')
 Kasir
@endsection

<style>
    .clear{
        clear:both;
        margin-top: 20px;
    }

    .autocomplete{
        width: 250px;
        position: relative;
        margin-top: 200px;
        margin-left: 60px;
    }
    .autocomplete #searchResult{
        list-style: none;
        padding: 0px;
        width: 100%;
        position: absolute;
        margin: 0;
        background: white;
    }

    .autocomplete #searchResult li{
        background: #F2F3F4;
        padding: 4px;
        margin-bottom: 1px;
    }

    .autocomplete #searchResult li:nth-child(even){
        background: #E5E7E9;
        color: black;
    }

    .autocomplete #searchResult li:hover{
        cursor: pointer;
        background: #CACFD2;
    }
    .autocomplete input[type=text]{
        padding: 5px;
        width: 100%;
        letter-spacing: 1px;
    }
    .msg-generate-struck{
        width: 200px;
        height: 20px;
        background: green;
        color: white;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .struc-display{
        padding-top: 10px;
        padding-bottom: 10px;
        width: 200px;
        height: auto;
        border-style: dotted ;
    }
     li{
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    
    /*style dom*/
   .style-li-dom{
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        margin-right: 100px;
   }

   .btn-plus-dom{
      margin-left: 5px;
      margin-right: 3px;
   }

   .btn-min-dom{
        margin-left: 5px;
        margin-right: 3px;
      
   }
   .btn-hapus-dom{
        margin-left: 5px;
        margin-right: 3px;
        margin-bottom: 5px;
   }

   .hr-dom{
    margin-top: 10px;
    width: 120%;
   }

</style>

@section('content-no-table')
<div class='autocomplete'>
    <p>1. Generate new struck</p> <br>
    <div> 
        <input type="text" disabled id="id_struck" style="margin-bottom: 10px">  
        <br> <button onclick="generateNewStruck()" style="margin-bottom:20px;">Generate</button> 
        <p id="msg_response" class="msg-generate-struck" style="display: none">Success generate new struck</p>
        <input type="hidden" id="value_id_struck_php" value="{{$last_id_struck}}">
    </div>
    <div style="margin-bottom: 15px;">2. Enter Product Name </div>
    <div>
        <input type="text" id="txt_search" name="txt_search">
        <p id="msg_search"></p>
    </div>
    <ul id="searchResult"></ul>

    <div class="clear"></div>
    <div id="userDetail"></div>

    <div id="keranjang_struck" style="margin-bottom: 230px;border-style: dotted ;">
       <ul id="parrent-keranjang" style="margin-left:10px;">
            <li class="style-li-dom">Total harga: <span id="total_harga">0</span></li>
            <hr>
       </ul>
    </div>

    <div id="response_struck_print" class="struc-display">
        <ul>
            <li>
                <span style="margin-right:15px" id="nama_barang">Sampo</span>
                <span style="margin-right: 10px" id="item_barang">1x12000</span>
                <span style="margin-right: 10px" id="total_harga_barang">12.000</span>
            </li>
            <li>
                <span style="margin-right:15px" id="nama_barang">Garam</span>
                <span style="margin-right: 10px" id="item_barang">3x3000</span>
                <span style="margin-right: 10px" id="total_harga_barang">9.000</span>
            </li>
            <li>
                <span style="margin-right:15px" id="nama_barang">Jeruk</span>
                <span style="margin-right: 10px" id="item_barang">1x5000</span>
                <span style="margin-right: 10px" id="total_harga_barang">5.000</span>
            </li>
           
            <li>Total &nbsp;&nbsp;&nbsp;  28.000</li>
            <li>Bayar &nbsp;&nbsp;&nbsp;  30.000</li>
            <li>Kembali &nbsp;&nbsp;&nbsp; 2.000</li>
        </ul>
    </div>
</div>
@endsection


@push('scripts')
<script>
$("#txt_search").keyup(function(){
    setTimeout(() => {
        var input_keyword = $(this).val();
        //console.log('input keyword',input_keyword);
        $("#searchResult").css({'display' : 'block'})
        if(input_keyword != ""){
            $.ajax({
                type: "post",
                url:"{{ route('product-list-jual-price-search') }}",
                data:{'keyword': input_keyword},
                success: function(response){
                    let data_tes = response.data
                    const total_ = response.data.length
                    if (total_ > 0) {
                        $("#searchResult").empty();
                        $('#msg_search').css({'display': 'none'})
                        data_tes.forEach(element => {
                            //console.log(element.nama_product);
                            $("#searchResult").append("<li value='"+element.id_product_jual+"'>"+element.nama_product+"</li>");
                        });

                        $("#searchResult li").bind("click",function(){
                            saveProductToKeranjang(this);
                        });
                    }else{

                        let element_notiv = document.getElementById('msg_search')
                        element_notiv.removeAttribute("style");
                        $('#msg_search').css({'width': '100px'})
                        $('#msg_search').css({'height': '25px'})
                        $('#msg_search').css({'background-color': 'red'})
                        $("#msg_search").css({'margin-top' : '10px'})
                        $("#msg_search").css({'text-align' : 'center'})
                        $("#msg_search").css({'border-radius' : '8px'})
                        $("#msg_search").css({'color' : 'white'})
                        element_notiv.textContent = "Data tidak ada"
                        console.log('kosong');
                        $("#searchResult").empty();
                    }
                   
                },
                error:function (err){
                    console.log(err);
                }
            })
        }else{
            $('#msg_search').css({'display': 'none'})
            $("#searchResult").empty();
        }

    }, 800);
})


function reqAjaxMin1Keranjang(idKeranjang){

}

function reqAjaxPlus1Keranjang(idKeranjang){

}

function reqAjaxRemoveKeranjang(id){

}


function saveProductToKeranjang(element){

    let nama_product = element.firstChild.data;
    document.getElementById('txt_search').value = nama_product

    $("#searchResult").css({'display' : 'none'})

    let id_product = element.value;
    let id_struck = document.getElementById("id_struck").value
    let id_struck_php = document.getElementById("value_id_struck_php").value
    let final_id = id_struck == "" ? id_struck_php : id_struck
    let input_data = {
        'struck_id': final_id,
        'status' : 0,
        'product_jual_id' : id_product,
        'jumlah_item_dibeli' : 1
    }
   
    //dom-create tampilan keranjang
    const div_keranjang_struck = document.getElementById('keranjang_struck');
    const ul_parent = document.getElementById('parrent-keranjang');
    
    const list_item = document.createElement("li");
    list_item.className = "styleLidom";
    list_item.textContent = nama_product;
    list_item.className = "style-li-dom";

    const button_plus = document.createElement("BUTTON");
    var plus = document.createTextNode("+");
    button_plus.className = "btn-plus-dom";
    button_plus.setAttribute('onclick', 'reqAjaxPlus1Keranjang(id)');
    button_plus.appendChild(plus)

    const input_total = document.createElement('input')
    input_total.setAttribute('value',1);
    input_total.setAttribute('disabled', true)

    const button_min = document.createElement("BUTTON");
    var min = document.createTextNode("-");
    button_min.className = "btn-min-dom";
    button_min.setAttribute('onclick', 'reqAjaxMin1Keranjang(id)');
    button_min.appendChild(min)

    const button_hapus = document.createElement("BUTTON");
    var hapus = document.createTextNode("hapus");
    button_hapus.className = "btn-hapus-dom";
    button_hapus.setAttribute('onclick','reqAjaxRemoveKeranjang(id)')
    button_hapus.appendChild(hapus)

    const hr = document.createElement("hr")
    hr.className = "hr-dom"

    ul_parent.appendChild(list_item);
    list_item.appendChild(button_plus);
    list_item.appendChild(button_min);
    list_item.appendChild(button_hapus);
    list_item.appendChild(input_total)
    list_item.appendChild(hr)
  
    //dom-create tampilan keranjang
    
    //1 buat response html buat keranjang ,dengan button->ok
    //2 implementasi response tadi ke route ajax keranajng
    //3 saat route keranjang success panggil api get kerajang

    // Request User Details
    $.ajax({
        url: '{{route("kerajang-create")}}',
        type: 'post',
        data: input_data,
        success: function(response){
            const data_res = response.data;
            let keranjang_id = data_res.id_keranjang_kasir;
            let total_product = data_res.jumlah_item_dibeli;
            //ajax get struck start
            $.ajax({
                url: '{{route("get-view-struck-barang")}}',
                type: 'post',
                data: {'id_struck' : data_res.struck_id},
                success: function(resStruck){
                    const list_data = resStruck.data;
                    const total_price_must_pay = list_data.total_bayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    $("#total_harga").text(total_price_must_pay);
                     //create element html
                    
                    
                },
                error: function(xhr, status, error){
                    if (status == 'error') {
                        let msg_error = JSON.parse(xhr.responseText);
                        console.log(msg_error);
                    }
                }
            })
            //ajax get struck end

        },
        error: function(xhr, status, error){
            if (status == 'error') {
                let msg_error = JSON.parse(xhr.responseText);
                if (msg_error.data.struck_id) {
                    alert("Tolong generate ulang struck")
                }
            }
        }

    });
}

function generateNewStruck(){
    $.ajax({
        url: '{{route("generate-new-struck")}}',
        type: 'post',
        success: function(response){
            if (response.msg == 'success') {
                document.getElementById("id_struck").value = response.data.id_struck;
                document.getElementById("msg_response").removeAttribute("style");
            }
            console.log(response.msg);
            console.log(response.data);
        },
        error: function(err){
            console.log(err);
        }

    });
}
</script>
@endpush