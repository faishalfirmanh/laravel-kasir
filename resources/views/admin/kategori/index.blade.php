@extends('layout.admin_app')
@section('title')
kategori

@section('table_content')
<div class="tables" style="margin-top:20px;">
    <section class="table__body">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Customers</th>
                    <th>Locations</th>
                    <th>Order date</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <td>1</td>
                   <td><img src="./images/1.jpeg" alt=""></td>
                   <td>Malang</td>
                   <td>13 Desember 2022</td>
                   <td><p class="status deliver">Deliver </p></td>
                   <td>$1234</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img src="./images/2.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status cancel">Canceled </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>3</td>
                    <td><img src="./images/3.png" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>4</td>
                    <td><img src="./images/4.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>5</td>
                    <td><img src="./images/5.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>6</td>
                    <td><img src="./images/5.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>7</td>
                    <td><img src="./images/5.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>8</td>
                    <td><img src="./images/5.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
                 <tr>
                    <td>9</td>
                    <td><img src="./images/5.jpg" alt=""></td>
                    <td>Malang</td>
                    <td>13 Desember 2022</td>
                    <td><p class="status ">Deliver </p></td>
                    <td>$1234</td>
                 </tr>
            </tbody>
        </table>
        <div class="pagination-custom">
            <ul class="pagination-link" id="link-paging-id">
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
    </section>
</div>
@endsection

@endsection
