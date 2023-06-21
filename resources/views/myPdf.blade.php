<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
</head>

<body>
    <style>
        @media print {
            @page {
                size: 58mm 100mm;
                /* Custom paper size  1 mm =  3.7 px*/
                margin: 0;
                /* Remove default margins */
            }

            body {
                margin: 0px;
                background-color: rgb(221, 219, 219);
                /* Reset body margin */
            }
        }

        .struc-display {
            padding-top: 5px;
            padding-bottom: 10px;
            height: auto;
            border-style: dotted;
        }

        ul {
            list-style-type: none;
            margin-left: -35px;
        }

        .font-isi-struck{
          font-size: 12px;
        }
    </style>
    <div id="view-print-invoice" style="width:220px; background-color:rgb(235, 231, 231)" class="struc-display">
        <h5 style="text-align: center">Toko ...</h5>
        <hr>
        <br><br>
        <ul id="id-ul-view-invoice" class="font-isi-struck">
            <li>Total &nbsp;&nbsp;&nbsp; <span id="id_struckUser_total"></span></li>
            <li>Bayar &nbsp;&nbsp;&nbsp; <span id="id_struckUser_bayar"></span></li>
            <li>Kembali &nbsp;&nbsp;&nbsp; <span id="id_struckUser_kembali"></span></li>
            <hr style="margin-top: 5px;margin-bottom:5px;">
        </ul>
        <button id="btn-print-js">Print</button>
    </div>

    <script>
        let full_current_url = document.URL.split("/");
        let total_arr = full_current_url.length
        let id_struck = full_current_url[total_arr - 1]

        const getAjaxViewStruck = (id_struck) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route("get-view-struck-barang") }}',
                    type: 'post',
                    data: {
                        'id_struck': id_struck
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            `Bearer ${localStorage.getItem("token")}`);
                    },
                    success: function(resStruck) {
                        resolve(resStruck)
                    },
                    error: function(xhr, status, error) {
                        if (status == 'error') {
                            let msg_error = JSON.parse(xhr.responseText);
                            reject(msg_error);
                        }
                    }
                })
            });
        }

        const  getDomLoadView = async(struck_id)=>{
            try {
                const response_succes = await getAjaxViewStruck(struck_id)
                const json_data = response_succes.data[0].data;
                const list_product_buy_customer = json_data.list;
                const ul_div = document.getElementById("id-ul-view-invoice")

                list_product_buy_customer.map((item,key)=>{
                   const name_item =  item.nama_product;
                   const harga_tiap_item = item.harga_tiap_item.toLocaleString()
                   const each_item_price = `${harga_tiap_item} x ${item.jumlah_item_dibeli}`;
                   const total_item_price = item.total_harga_item.toLocaleString();
                   const attribute_id = `item_keranjgan_id_${item.id_keranjang_kasir}`

                   const elemet_li_struck = document.createElement('li')
                   elemet_li_struck.style.marginTop = "10px";
                   elemet_li_struck.setAttribute('id',attribute_id);
                   elemet_li_struck.setAttribute('class','li-struck-view');

                   ul_div.appendChild(elemet_li_struck)
                   const element_span = document.createElement('span');
                   element_span.className = "span-align";
                   

                   element_span.textContent = `${name_item} - ${each_item_price} - ${ total_item_price}`
                   elemet_li_struck.appendChild(element_span);

                   const hr = document.createElement("hr")
                   hr.style.width = "220px"
                   element_span.appendChild(hr)
               })

              let total_must_pay = document.getElementById('id_struckUser_total');
              let user_pay = document.getElementById('id_struckUser_bayar')
              let kembalian = document.getElementById('id_struckUser_kembali')

              total_must_pay.textContent = json_data.total_harga;
              user_pay.textContent = json_data.dibayar
              kembalian.textContent = json_data.kembalian

            } catch (error) {
               console.log('eror',error);
            }
        }

        getDomLoadView(id_struck)

        const print_btn = document.getElementById('btn-print-js')

        $("#btn-print-js").click(function(e) {
            document.getElementById("btn-print-js").style = 'display:none'

            // Print the page
            window.print();
        })
    </script>
</body>

</html>
