
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

    /* class stuck */
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
   .style-li-dom-fix{
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        margin-right: 100px;
   }

   /* buton */
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
        margin-top: 7px;
   }

   .hr-dom{
    margin-top: 10px;
    width: 120%;
   }

   /*clas loading*/
   .loading-p-class{
        margin-top: 12px;
        margin-bottom: 13px;
        font-size: 17px;
        color: red;
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

    <div id="keranjang_struck" style="margin-bottom: 80px;border-style: dotted ;">
       <ul id="parrent-keranjang" style="margin-left:10px;">
            <li class="style-li-dom-fix">Total harga: <span id="total_harga">0</span></li>
            <hr>
       </ul>
    </div>

    <div style="margin-bottom: 15px;">
        <p>3. User Bayar</p> <br>
        <input type="number" min="1" id="user_bayar_id"> 
        <div style="margin-bottom: 20px;margin-top: 15px;">
            <button id="btn-hitung-transaksi">Hitung transaksi</button>
        </div>
    </div>
    

    <div id="response_struck_print" class="struc-display">
        <h4>Tampilan struck</h4>
        <br><br>
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
//js cek total bayar start
const text_total_harga = document.getElementById('total_harga')
if (text_total_harga.textContent < 1) {
    let btn_cetak_struck = document.getElementById('btn-hitung-transaksi');
    btn_cetak_struck.setAttribute("disabled", true);
    let input_harga_bayar_user = document.getElementById('user_bayar_id')
    input_harga_bayar_user.setAttribute("disabled",true)
}
//js cek total bayar end

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
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
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

function domLoading(){
    const ul_parent = document.getElementById('parrent-keranjang');
    const loading_p = document.createElement("p");
    var text_loading = document.createTextNode("Loading......");
    loading_p.className = "loading-p-class";
    loading_p.appendChild(text_loading)
    loading_p.setAttribute('id', 'text-loading-p-id')
    ul_parent.appendChild(loading_p) 
    //remove loading
    const  cek_class_child_exsis = document.getElementsByClassName('style-li-dom');
    if (cek_class_child_exsis.length > 0) {
        document.querySelectorAll('.style-li-dom').forEach(e => e.remove());
    }
}

$("#btn-hitung-transaksi").click(function(){
    let struck_id = document.getElementById('id_struck').value
    let input_price = document.getElementById('user_bayar_id').value
    let input_data = { 'id_struck' : struck_id, 'user_bayar' : input_price }
    $.ajax({
        type: "post",  
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url:"{{ route('input-price-user-bayar') }}",
        data: input_data,
        success: function(response){
            console.log('response suskes transaksi',response);
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        error: function (xhr,status,response){
            if (status == 'error') {
                let msg_error = JSON.parse(xhr.responseText);
                if (msg_error.data.user_bayar) {
                    alert(msg_error.data.user_bayar)
                }
            }
        }
    });
});

function reqAjaxMin1Keranjang(idKeranjang){
    $.ajax({
        type: "post",  
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url:"{{ route('remove-keranjang-product-min1') }}",
        data:{'id_keranjang_kasir': idKeranjang},
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        success: function(response){
            domLoading();
            if (response.data == null) {
                document.getElementById("total_harga").innerHTML = 0;
                setTimeout(() => {
                    document.getElementById("text-loading-p-id").remove();
                }, 800);
            }else{
                const id_struck = response.data.struck_id;
                setTimeout(() => {
                    document.getElementById("text-loading-p-id").remove();
                    getStruckFunction(id_struck);
                }, 800);
            }
           
        },
        error: function (err){
            console.log('err',err);
        }
    })
}

function reqAjaxPlus1Keranjang(idKeranjang){
    $.ajax({
        type: "post",  
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url:"{{ route('add-keranjang-product-plus1') }}",
        data:{'id_keranjang_kasir': idKeranjang},
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        success: function(response){
            domLoading();
            const id_struck = response.data.struck_id;
            setTimeout(() => {
                document.getElementById("text-loading-p-id").remove();
                getStruckFunction(id_struck);
            }, 800);
        },
        error: function (err){
            console.log('err',err);
        }
    })
}

function reqAjaxRemoveKeranjang(id){ 
    $.ajax({
        type: "post",  
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        url:"{{ route('delete-keranjang') }}",
        data:{'id_keranjang_kasir': id},
        success: function(response){
            domLoading();
            if (response.data == null) {
                document.getElementById("total_harga").innerHTML = 0;
                setTimeout(() => {
                    document.getElementById("text-loading-p-id").remove();
                }, 800);
            }else{
                const id_struck = response.data.id_struck;
                setTimeout(() => {
                    document.getElementById("text-loading-p-id").remove();
                    getStruckFunction(id_struck);
                }, 800);
            }
        },
        error: function (err){
            console.log('err',err);
        }
    })
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
        'product_jual_id' : id_product
        // 'jumlah_item_dibeli' : 1
    }
   
    
    
    //1 buat response html buat keranjang ,dengan button->ok
    //2 implementasi response tadi ke route ajax keranajng->ok
    //3 saat route keranjang success panggil api get kerajang->ok
    //4 perbaiki saat product sudah ada (update keranjang) tidak create element lagi->

    // Request User Details
    $.ajax({
        url: '{{route("kerajang-create")}}',
        type: 'post',
        data: input_data,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        success: function(response){
            const data_res = response.data;
            let keranjang_id = data_res.id_keranjang_kasir;
            let total_product = data_res.jumlah_item_dibeli;
            let id_keranjang_kasir = data_res.id_keranjang_kasir

            //create element loading
            domLoading();
            //loading end
            setTimeout(() => {
                document.getElementById("text-loading-p-id").remove();//remove loading
                document.getElementById('user_bayar_id').value = ''
                getStruckFunction(data_res.struck_id);
            }, 800);
        },
        error: function(xhr, status, error){
            if (status == 'error') {
                let msg_error = JSON.parse(xhr.responseText);
                if (msg_error.data.struck_id) {
                    alert("Tolong generate ulang struck")
                }
                if (msg_error.data.id_keranjang_kasir) {
                    alert(msg_error.data.id_keranjang_kasir)
                }
                if (msg_error.data[0].data.id_keranjang_kasir) {
                    alert(msg_error.data[0].data.id_keranjang_kasir)
                }
            }
        }

    });
}

function getStruckFunction(id_struck){
    //dom-create tampilan keranjang
    const div_keranjang_struck = document.getElementById('keranjang_struck');
    const ul_parent = document.getElementById('parrent-keranjang');
    //ajax get struck start
    $.ajax({
        url: '{{route("get-view-struck-barang")}}',
        type: 'post',
        data: {'id_struck' : id_struck},
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        success: function(resStruck){
            //enabled button save and input price money from user
            let btn_cetak_struck = document.getElementById('btn-hitung-transaksi');
            btn_cetak_struck.removeAttribute("disabled");
            let input_harga_bayar_user = document.getElementById('user_bayar_id')
            input_harga_bayar_user.removeAttribute("disabled");
            //enabled button save and input price money from user
            const list_data = resStruck.data[0].data;;
            const total_price_must_pay = list_data.total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $("#total_harga").text(total_price_must_pay);
            const list_item = list_data.list;
                //create element html
                list_item.map((item)=>{
                
                    const cek_element_exsist_list = $('li').hasClass('style-li-dom')
                    const id_product_jual = item.id_product_jual;
                    
                    //nama product
                    const list_item = document.createElement("li");
                    const cek_pcs = item.is_kg == 1 ? 'kg' : 'pcs';
                    const name_prd = `${item.nama_product} | ${item.start_kg} - ${item.end_kg} ${cek_pcs}`;
                    list_item.textContent = name_prd;
                    list_item.className = "style-li-dom";
                    
                  

                    //btn-plus
                    const button_plus = document.createElement("BUTTON");
                    const plus = document.createTextNode("+");
                    button_plus.className = "btn-plus-dom";
                    button_plus.setAttribute('onclick', `reqAjaxPlus1Keranjang(${item.id_keranjang_kasir})`);
                    
                    //btn-min
                    const button_min = document.createElement("BUTTON");
                    const min = document.createTextNode("-");
                    button_min.className = "btn-min-dom";
                    button_min.setAttribute('onclick', `reqAjaxMin1Keranjang(${item.id_keranjang_kasir})`);
                    
                    //btn-remove
                    const button_hapus = document.createElement("BUTTON");
                    var hapus = document.createTextNode("hapus");
                    button_hapus.className = "btn-hapus-dom";
                    button_hapus.setAttribute('onclick',`reqAjaxRemoveKeranjang(${item.id_keranjang_kasir})`)
                    
                    //price each item 
                    const element_price_item = document.createElement("p")
                    const price_each_item = item.harga_tiap_item.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    const text_price = document.createTextNode(`harga item : ${price_each_item}`)
                    element_price_item.className = 'text-price-item'

                    //price total each item
                    const element_total_item = document.createElement("p")
                    const price_total_item = item.total_harga_item.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    const text_total_item = document.createTextNode(`total item ${price_total_item}`)

                    //total item
                    const input_total = document.createElement('input')
                    input_total.setAttribute('value',item.jumlah_item_dibeli);
                    input_total.setAttribute('disabled', true)
                    let id_value_jumlah = `id-input-${item.id_keranjang_kasir}`
                    input_total.setAttribute('id',id_value_jumlah)
                    //hr
                    const hr = document.createElement("hr")
                    hr.className = "hr-dom"
                    //for create element implements

                    
                    ul_parent.appendChild(list_item);
                    button_plus.appendChild(plus)
                    list_item.appendChild(button_plus);
                    button_min.appendChild(min)
                    list_item.appendChild(button_min)
                    list_item.appendChild(input_total)
                    button_hapus.appendChild(hapus)
                    list_item.appendChild(button_hapus)
                    element_price_item.appendChild(text_price)
                    list_item.appendChild(element_price_item)
                    element_total_item.appendChild(text_total_item)
                    list_item.appendChild(element_total_item)
                    list_item.appendChild(hr)
                
                })
            
        },
        error: function(xhr, status, error){
            if (status == 'error') {
                let msg_error = JSON.parse(xhr.responseText);
                console.log(msg_error);
            }
        }
    })
    //ajax get struck end

}

function generateNewStruck(){
    $.ajax({
        url: '{{route("generate-new-struck")}}',
        type: 'post',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
        },
        success: function(response){
            if (response.msg == 'success') {
                document.getElementById("id_struck").value = response.data.id_struck;
                document.getElementById("msg_response").removeAttribute("style");
                $('.style-li-dom').remove();
                $("#total_harga").text(0)
                document.getElementById('txt_search').value = ''
                document.getElementById('user_bayar_id').value = ''
            }
           
        },
        error: function(err){
            console.log(err);
        }

    });
}
</script>
@endpush