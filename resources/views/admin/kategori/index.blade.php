@extends('layout.admin_app')
@section('title')
kategori

@section('table_content')
<div class="tables" style="margin-top:20px;">
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
    </div>
</div>
@endsection

@endsection
