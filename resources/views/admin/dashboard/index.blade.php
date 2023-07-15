@extends('layout.admin_app')
@section('title')
 Dashboard
@endsection
<style>
    .far.fa-eye,
    .far.fa-edit,
    .far.fa-trash-alt:hover{
        cursor: pointer;
    }
    div .card-name{
        color: white;
        font-size: 13px;
    }
</style>
@section('dashboard')
    <div class="cards">
        <div class="card">
            <div class="card-container">
                <div id="id_toko_name" style="color: white;font-size:14px;font-weight:600">
                    
                </div> 
                <div id="id_date_riport" style="color: white;font-size:14px;font-weight:600">
                    
                </div>
                <div class="number"  id="sum_transaction"></div>
                <div class="card-name">Total Transaksi</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number" id="sum_uang_masuk" style="font-size: 20px;"></div>
                <div class="card-name">Keuntungan kotor</div>
                <div class="card-name">(Uang masuk)</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-cart-plus"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number" id="sum_laba_bersih" style="font-size: 20px;"></div>
                <div class="card-name">Keuntungan Bersih</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-container">
                <div class="number">$1438</div>
                <div class="card-name">Terjual</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div> --}}
    </div>
    <div class="" style="margin-left: 20px">
       <div>
            <label id="" class=""  style="margin-left: 5px;font-size:14px">Pilih toko</label>
            <select class="" id="select_tokoid" name=""  style="margin-top:5px;margin-left:10px" required>
                
            </select>
       </div>
       <div style="margin-top: 20px">
            <label for="tngl"  style="margin-left: 5px;font-size: 14px">Pilih tanggal</label>
            <input type="date" id="id_tanggal" style="margin-left: 5px">
       </div>
       <div style="margin-top: 20px;margin-left:5px">
            <input id="id_submit" type="submit" value="Submit">
       </div>
    </div>
@endsection



@push('scripts')
<script>
    function getApiDashboard(id_toko,date){
        return new Promise(function(resolve, reject){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('dashboard_today') }}`,
                data: { 'toko_id' : id_toko, 'tanggal' : date },
                type: 'post',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(responseSuccess) {
                    resolve(responseSuccess)
                },
                error: function(xhr, status, error) {
                    reject(error)
                }
            })
        })
     }

     function getTokoList(){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: "get",
                url: "{{ route('get-all-toko') }}",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                success: function(response) {
                    resolve(response)
                },
                error:function(xhr, status, error) {
                    reject(error)
                }
            })
        })
     }

    function getAjAXTokoById(toko_id){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: 'post',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                data: {
                    'id_toko': toko_id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('detail-toko') }}`,
                success: function(res) {
                    resolve(res)
                },
                error: function(xhr, status, msg) {
                    reject('error get tokoby id')
                }
            })
        })
    } 

     const getResponseToke = async () =>{
        let select_html_option = document.getElementById("select_tokoid");
        try {
            let ajaxRequest = await getTokoList()
            let data = ajaxRequest.data
           
            if (data.length > 0) {
                data.map((item)=>{
                    var option= document.createElement("option");
                    option.value= item.id_toko;
                    option.text = item.nama_toko
                    select_html_option.add(option)
                })
                
            }
        } catch (error) {
          alert("error get toko")
        }
    
     }
      
     function formatDateYYYMMDD(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function formateDateView(date){
        const dt = new Date(date).toISOString().split('T')[0];
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const string_date = new Date(dt).toLocaleString("id-ID", options)
        return string_date
    }

     getResponseToke();

     const getAjaxDashboard = async (id_toko, tanggal) =>{
        try {
            //date now
            const now = new Date();
            const options = { timeZone: 'Asia/Jakarta' };
            const currentTime = now.toLocaleString('en-US', options);

            let response_report = await getApiDashboard(id_toko, tanggal)
            let response_toko = await getAjAXTokoById(id_toko);
            //report
            const data_json = response_report.data[0].data[0]
            //final result
            const tgl = data_json.tanggal == formatDateYYYMMDD(currentTime) ? `Hari ini ${formateDateView(data_json.tanggal)}` : formateDateView(data_json.tanggal)  ;
            const toko_name = response_toko.data.nama_toko
            const total_transaksi = data_json.total_transaksi;
            const uang_masuk = data_json.uang_masuk != null ? Number(data_json.uang_masuk).toLocaleString() : 0;
            const untung_bersih = data_json.keuntungan_bersih != null ? Number(data_json.keuntungan_bersih).toLocaleString() : 0;
            
            let element_toko = document.getElementById("id_toko_name");
            let element_total_trans = document.getElementById("sum_transaction");
            let element_tgl = document.getElementById("id_date_riport");
            let element_uang_masuk = document.getElementById("sum_uang_masuk");
            let element_untung_bersih = document.getElementById("sum_laba_bersih");

            const kondisi_tgl = total_transaksi < 1 ? 'no set' : tgl
            element_toko.innerHTML = toko_name
            element_total_trans.innerHTML = total_transaksi
            element_tgl.innerHTML = kondisi_tgl
            element_uang_masuk.innerHTML = uang_masuk
            element_untung_bersih.innerHTML = untung_bersih
          
            console.log(tgl);

        } catch (error) {
            alert('error dashboard')
        }
     }

     const btn_click = document.getElementById("id_submit");
     btn_click.addEventListener("click", function(e){
        const select_toko = document.getElementById("select_tokoid").value;
        const input_date = document.getElementById("id_tanggal").value;
        getAjaxDashboard(select_toko, input_date);
     });
     
</script>
@endpush