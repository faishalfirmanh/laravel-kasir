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
                    Mojokerto
                </div> 
                <div id="id_date_riport" style="color: white;font-size:14px;font-weight:600">
                    hari ini (14/07/2023)
                </div>
                <div class="number">105</div>
                <div class="card-name">Total Transaksi</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">14</div>
                <div class="card-name">Keuntungan kotor</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-cart-plus"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">8</div>
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
        <input type="text">
    </div>
@endsection



@push('scripts')

@endpush