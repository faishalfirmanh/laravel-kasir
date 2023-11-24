
<style>
    
</style>


<div class="modal2" id="modalPrice">
    <div class="modal__wrapper">
        <div>
            <h3 id="title_modal">Input Price Product</h3>
        </div>
        <p></p>
        <form action="" id="form-product-price">
            <div class="input-group">
                <label id="id_label_satuan_berat_item" class="text-label-modal" for="satuan_berat_item" style="margin-left: 5px;">Satuan berat item <span style="font-size: 13px;color:red">(untuk stock)</span></label>
                <input class="input-modal-global" id="satuan_berat_item" step="0.0001" required type="number" min="0" style="margin-top:5px;" name="satuan_berat_item" placeholder="satuan berat item">
            </div>
            <div class="input-group">
                <label id="id_label_subname" class="text-label-modal" for="subname" style="margin-left: 5px;">Subname <span style="font-size: 13px">(opsional)</span></label>
                <input class="input-modal-global" id="subname" type="text"  style="margin-top:5px;" name="subname" placeholder="opsional subname">
            </div>
            <div class="input-group">
                <label id="id_label_price_sell" class="text-label-modal" for="price_sell" style="margin-left: 5px;">Harga jual</label>
                <input class="input-modal-global" id="price_sell" required type="text" style="margin-top:5px;" name="price_sell" placeholder="Harga jual">
            </div>
            <div class="input-group">
                <label id="id_label_price_beli" class="text-label-modal" for="price_buy" style="margin-left: 5px;">Price buy</label>
                <select class="input-modal-global" id="price_buy" name="price_buy"  style="margin-top:5px;" required>
                    <option value="0">0</option>
                </select>
            </div>
            <div class="btn-group-modal2">
                <button type="submit" class="btn-modal2 btn-blue">Submit</button>
                <button class="btn-modal2 btn-light-modal2 modal__close_2">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="modal2" id="modalPriceBuy">
    <div class="modal__wrapper">
        <div>
            <h3 id="title_modal">Input Harga Beli Custom</h3>
        </div>
        <p></p>
        <form action="" id="form-product-price-buy">
            <div class="input-group">
                <label id="id_label_nama_variant" class="text-label-modal" for="nama_variant" style="margin-left: 5px;">Nama variant</label>
                <input class="input-modal-global" id="nama_variant" required type="text" style="margin-top:5px;" name="nama_variant" placeholder="nama variant">
            </div>
            <div class="input-group">
                <label id="id_label_price_buy_custom" class="text-label-modal" for="price_buy" style="margin-left: 5px;">Harga beli custom</label>
                <input class="input-modal-global" id="price_buy_custom" required type="text" style="margin-top:5px;" name="price_buy_custom" placeholder="Harga beli">
            </div>
            <div class="btn-group-modal2">
                <button type="submit" class="btn-modal2 btn-blue">Submit</button>
                <button class="btn-modal2 btn-light-modal2 modal__close_2_price_buy">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
   
</script>