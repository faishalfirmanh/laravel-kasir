
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
</style>

@section('content-no-table')
<div class='autocomplete'>
    <p>1. Generate new struck</p> <br>
    <div> 
        <input type="text" disabled id="id_struck" style="margin-bottom: 10px">  
        <br> <button onclick="generateNewStruck()" style="margin-bottom:20px;">Generate</button> 
        <p id="msg_response" class="msg-generate-struck" style="display: none">Success generate new struck</p>
    </div>
    <div style="margin-bottom: 15px;">2. Enter Product Name </div>
    <div>
        <input type="text" id="txt_search" name="txt_search">
        <p id="msg_search"></p>
    </div>
    <ul id="searchResult"></ul>

    <div class="clear"></div>
    <div id="userDetail"></div>

    <div id="response_struck_print" class="struc-display">
        <ul>
            <li>Sampo &nbsp &nbsp  1x12000  &nbsp | &nbsp 24.000</li>
            <li>Sabon &nbsp &nbsp  1x2000  &nbsp  | &nbsp 2.000</li>
            <li>Garam &nbsp &nbsp  2x3000  &nbsp  | &nbsp 6.000</li>
        </ul>
    </div>
</div>
@endsection


@push('scripts')
<script>
$("#txt_search").keyup(function(){
    setTimeout(() => {
        var input_keyword = $(this).val();
        console.log('input keyword',input_keyword);
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
                            console.log(element.nama_product);
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

function saveProductToKeranjang(element){
    var value = $(element).text();
    var userid = $(element).val();

    $("#txt_search").val(value);
    $("#searchResult").empty();
    
    // Request User Details
    $.ajax({
        url: '{{route('kerajang-create')}}',
        type: 'post',
        data: {userid:userid, type:2},
        dataType: 'json',
        success: function(response){

            var len = response.length;
            $("#userDetail").empty();
            if(len > 0){
                var username = response[0]['username'];
                var email = response[0]['email'];
                $("#userDetail").append("Username : " + username + "<br/>");
                $("#userDetail").append("Email : " + email);
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