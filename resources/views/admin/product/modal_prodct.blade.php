



<div class="modal2" id="modal2">
    <div class="modal__wrapper">
        <h3 id="title_modal">Input Product</h3>
        <p></p>
        <form action="" id="form-product">
            <label id="id_label_nama_barang" class="text-label-modal" for="nama_barang" style="margin-left: 5px;">Nama barang</label>
            <input class="input-modal-global" id="name_product" required type="text" style="margin-top:5px;" name="nama_barang" placeholder="Nama barang">
            <label id="id_label_kategori" class="text-label-modal" for="kategori" style="margin-left: 5px;">Kategori</label>
            <select class="input-modal-global" id="kategori_select" name="kategori"  style="margin-top:5px;" required>
              
            </select>
            <label id="id_label_hargabeli" class="text-label-modal" for="harga_beli" style="margin-left: 5px;">Haraga Beli</label>
            <input class="input-modal-global" id="harga_beli" min="1" required type="number" id="harga_beli" style="margin-top:5px;" name="harga_beli" placeholder="Harga beli">
            <label id="id_label_satuan" class="text-label-modal" style="margin-left: 5px">Satuan kg, Uncheck bila pcs</label>
            <input  class="input-modal-global is_kg"  type="checkbox" id="is_kg" name="is_kg">
            <br>
            <label id="id_label_jumlah" class="text-label-modal" min="1" for="jumlah_berat" style="margin-left: 5px;">Jumlah berat / kg</label>
            <input class="input-modal-global" required type="number" id="total_satuan" style="margin-top:5px;" name="jumlah_berat" placeholder="Jumlah berat">
            <label id="" class="text-label-modal" for="expired" style="margin-left: 5px;">tanggal expired <label id="id_label_expired" style="color:red"></label> </label>
            <input class="input-modal-global" type="date" id="expired" style="margin-top:5px;" name="expired" placeholder="Tanggal expired">
            <div class="btn-group-modal2">
                <button type="submit" class="btn-modal2 btn-blue">Submit</button>
                <button class="btn-modal2 btn-light-modal2 modal__close_2">Cancel</button>
            </div>
        </form>
    </div>
</div>