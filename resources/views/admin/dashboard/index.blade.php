@extends('layout.admin_app')
@section('title')
 Dashboard
@endsection
@section('dashboard')
    <div class="cards">
        <div class="card">
            <div class="card-container">
                <div class="number">105</div>
                <div class="card-name">Product Incoming</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">14</div>
                <div class="card-name">Total Product Sell</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-cart-plus"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">8</div>
                <div class="card-name">net profit</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">$1438</div>
                <div class="card-name">Sells Today</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
@endsection

@section('table_content')
    <div class="tables" style="margin-top:-80px;">
        <div class="last-appointments">
            <div class="heading">
                <h2>Last Appointments.....</h2>
                <a href="#" class="btn">View all</a>
            </div>
            <table class="appointmens">
                <thead>
                    <td>Name</td>
                    <td>Doctor</td>
                    <td>Conditions</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <i class="far fa-eye"></i>
                            <i class="far fa-edit"></i>
                            <i class="far fa-trash-alt"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination-custom">
                <ul class="pagination-link">
                    <li> <a href="#" class="prev"> <i class="fas fa-arrow-circle-left" aria-hidden="true"></i> </a> </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#" class="active">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">.....</a></li>
                    <li><a href="#" class="next"> <i class="fas fa-arrow-circle-right" aria-hidden="true"></i> </a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection