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
    <form id="uploadProd" enctype="multipart/form-data">
        <div style="margin-top: 20px">
            <label for="file_upload"   style="margin-left: 5px;font-size: 14px">Pilih File excel</label>
            <input type="file" name="file_excel"  class="input-modal-global-dash" id="file_upload" style="margin-left: 5px;width:300px">
        </div>
        <div style="margin-top: 20px;margin-left:5px">
            <input class="btn-modal2 btn-blue" id="id_submit_upload" type="submit" value="Submit">
        </div>
    </form>
</div>
@endsection

@section('modal_global')
    @include('admin.uploadproduct.modal')
@endsection

@push("scripts")
    <script>
        // $("#id_submit_upload").on("click", function(e) {

        //     console.log("click upload");
        // })

        $(document).ready(function () {
            $('#uploadProd').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: `{{ route('product-upload-excel') }}`,
                    type: 'POST',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                    },
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(typeof(response));
                        if (typeof(response) == 'string') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: `${response}`,
                            })
                        }else{
                            Swal.fire(
                                'Create!',
                                'Uplaod file excel product success.',
                                'success'
                            )
                        }
                        
                    },
                    error: function (error) {
                        console.log("error ",error);
                    }
                });
            });
        });

    </script>
@endpush