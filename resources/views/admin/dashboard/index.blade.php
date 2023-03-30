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
                <div class="card-name">Total Product Terjual</div>
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
        <div class="card">
            <div class="card-container">
                <div class="number">$1438</div>
                <div class="card-name">Terjual</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
@endsection



@push('scripts')

@endpush