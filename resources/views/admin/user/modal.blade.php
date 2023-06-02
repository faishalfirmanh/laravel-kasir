



<div class="modal2" id="modalUser">
    <div class="modal__wrapper">
        <h3 id="title_modal">Input User</h3>
        <p></p>
        <form action="" id="form-user">
            <label id="id_label_nama_user" class="text-label-modal" for="nama_user" style="margin-left: 5px;">Nama User</label>
            <input class="input-modal-global" id="nama_user" required type="text" style="margin-top:5px;" name="nama_user" placeholder="Nama user">
            <div class="input-group">
                <label id="" class="text-label-modal" for="email" style="margin-left: 5px;">Email</label>
                <input class="input-modal-global" id="email" required type="email"  style="margin-top:5px;" name="email" placeholder="email">
            </div>
            <div class="input-group">
                <label id="" class="text-label-modal" for="Akses" style="margin-left: 5px;">Akses</label>
                <select class="input-modal-global" id="select_role" name="role"  style="margin-top:5px;" required>
                    <option value="0">0</option>
                </select>
            </div>
            <div class="input-group">
                <label id="" class="text-label-modal" for="Toko" style="margin-left: 5px;">Toko</label>
                <select class="input-modal-global" id="select_toko" name="toko"  style="margin-top:5px;" required>
                    <option value="0">0</option>
                </select>
            </div>
            <div class="input-group">
                <label id="" class="text-label-modal" for="Passwprd" style="margin-left: 5px;">Password </label><br>
                <span style="color: red;margin-left:5px">(tidak wajib)</span>
                <input class="input-modal-global" id="password" type="password"  style="margin-top:5px;" name="password" placeholder="">
            </div>
            <div class="btn-group-modal2">
                <button type="submit" class="btn-modal2 btn-blue">Submit</button>
                <button class="btn-modal2 btn-light-modal2 modal__close_2">Cancel</button>
            </div>
        </form>
    </div>
</div>