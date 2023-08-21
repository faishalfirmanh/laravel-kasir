
<style>
     /**/
     input[type="checkbox"]{
        position: relative;
        width: 40px; /*80*/
        height: 20px; /*40*/
        -webkit-appearance: none;
        background: #c6c6c6;
        outline: none;
        border-radius: 10px; /**/
        box-shadow: inset 0 0 5px rgba(0,0,0.2);
        transition: .5s;
    }   
    input:checked[type="checkbox"]{
        background: #03a9fa;
    }
    input[type="checkbox"]:before
    {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 10px;
        top:0;
        left: 0;
        background: #fff;
        transition: .5s;
        box-shadow: 0 2px 5px  rgba(0,0,0.2);
        transform:scale(1.1); 
    }

    input:checked[type="checkbox"]::before
    {
      left: 20px;
    }
    .input-group-tes{
        display: grid;
        grid-template-columns: 2fr 2fr;
    }
</style>

<div class="modal2" id="modalrole">
    <div class="modal__wrapper">
        <h3 id="title_modal">Input Role</h3>
        <p></p>
        
        <form action="" id="form-role">
            <label id="id_label_nama_role" class="text-label-modal" for="nama_role" style="margin-left: 5px;">Nama role</label>
            <input class="input-modal-global" id="nama_role" required type="text" style="margin-top:5px;" name="nama_role" placeholder="Nama role">
            <div class="input-group-tes">
                <label id="id_label_kategori" class="text-label-modal" for="kategori" style="">Kategori</label>
                <input class="input-modal-global is_kategori_class" id="is_kategori"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_toko" class="text-label-modal" for="toko" style="">Toko</label>
                <input class="input-modal-global is_toko_class" id="is_toko"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_product" class="text-label-modal" for="product" style="">Product</label>
                <input class="input-modal-global is_product_class" id="is_product"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_user" class="text-label-modal" for="user" style="">User</label>
                <input class="input-modal-global is_user_class" id="is_user"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_kasir" class="text-label-modal" for="kasir" style="">Kasir</label>
                <input class="input-modal-global is_kasir_class" id="is_kasir"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_laporan" class="text-label-modal" for="laporan" style="">Laporan</label>
                <input class="input-modal-global is_laporan_class" id="is_laporan"  type="checkbox" style="">
            </div>
            <div class="input-group-tes">
                <label id="id_label_log" class="text-label-modal" for="laporan" style="">Log Activity</label>
                <input class="input-modal-global is_log_class" id="is_log"  type="checkbox" style="">
            </div>
            <div class="btn-group-modal2">
                <button type="submit" class="btn-modal2 btn-blue">Submit</button>
                <button class="btn-modal2 btn-light-modal2 modal__close_2">Cancel</button>
            </div>
        </form>
    </div>
</div>