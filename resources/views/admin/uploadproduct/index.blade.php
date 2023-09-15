@extends('layout.admin_app')
@section('title')
    Upload product
@endsection
<style>
     div .card-name{
        color: white;
        font-size: 13px;
    }
    .input-modal-global-dash {
        width: 100%;
        font-size: 14px;
        padding: .65rem 1.3rem;
        border-radius: .5rem;
        margin-bottom: .75rem;
        background-color: white;
        border: 1px solid var(--grey-d-2);
        transition: .2s;
    }
</style>
@section('content-no-table')
<div class="" style="margin-left: 20px">
    <div style="margin-top: 20px">
        <a href="{{asset('downloadexample/example.xlsx')}}" style="font-size: 20px">download contoh file excel</a>
    </div>
    <div style="margin-top: 20px">
         <label for="file_upload"   style="margin-left: 5px;font-size: 14px">Pilih File excel</label>
         <input type="file"  class="input-modal-global-dash" id="file_upload" style="margin-left: 5px;width:300px">
    </div>
    <div style="margin-top: 20px;margin-left:5px">
         <input class="btn-modal2 btn-blue" id="id_submit" type="submit" value="Submit">
    </div>
</div>
@endsection

@section('modal_global')
    @include('admin.uploadproduct.modal')
@endsection