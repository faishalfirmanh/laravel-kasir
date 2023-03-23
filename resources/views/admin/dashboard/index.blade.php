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
                <h2>Kategori</h2>
                <a href="#" class="btn">Tambah</a>
            </div>
            <table class="appointmens" id="kategori-table-id">
                <thead>
                    <td>No</td>
                    <td>Name Kategori</td>
                    <td>Total Product</td>
                    <td>Actions</td>
                </thead>
                <tbody id="table-body-kategori">
                    {{-- <tr>
                        <td>1</td>
                        <td>Sayur</td>
                        <td>20</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Bahan Pokok</td>
                        <td>10</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Buah</td>
                        <td>20</td>
                        <td>
                            <i class="far fa-eye"></i>
                            <i class="far fa-edit"></i>
                            <i class="far fa-trash-alt"></i>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <div class="pagination-custom">
                <ul class="pagination-link" id="link-paging-id">
                    {{-- <li> <a href="#" class="prev"> <i class="fas fa-arrow-circle-left" aria-hidden="true"></i> </a> </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#" class="active">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">.....</a></li>
                    <li><a href="#" class="next"> <i class="fas fa-arrow-circle-right" aria-hidden="true"></i> </a></li> --}}
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $.ajax({
            url: `{{route('kategori-list')}}`,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'get',
            // data: {page:2},
            dataType: 'json',
            success: function(response){
                let list_data = response.data.data;
                buildTable(list_data)
                makePagination(response.data)
                
            },
            error: function(err){
                console.log('error',err);
            }
    })

    function buildTable(data){
        var table = document.getElementById('table-body-kategori');
        for (let i = 0; i < data.length; i++) {
             var row  = `<tr>
                            <td>${data[i].id_kategori}</td>
                            <td>${data[i].nama_kategori}</td>
                            <td>${data[i].product_relasi_kategori.length}</td>
                            <td>
                                <i class="far fa-eye"></i>
                                <i class="far fa-edit"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>`;
                table.innerHTML += row;
        }
    }
    
    function makePagination(data){
        if (data.total > 0) {
            const wraper_pagination = document.getElementById("link-paging-id");
            let list_page = data.total / data.per_page;
            let curr_page = data.current_page;
            let paging_first = `<li> <a href="#" class="prev"> <i class="fas fa-arrow-circle-left" aria-hidden="true"></i> </a> </li>`
            wraper_pagination.innerHTML += paging_first;
            for (let index = 1; index <= list_page; index++) {
                let cek = curr_page == index ? 'active': '';
                var paging = `
                        <li><a href="#" onclick="reqajaxkategoriPaging(this)" class="${cek}">${index}</a></li>
                    `;
                wraper_pagination.innerHTML += paging;
            }
            let pagging_last = `<li><a href="#" class="next"> <i class="fas fa-arrow-circle-right" aria-hidden="true"></i> </a></li>`
            wraper_pagination.innerHTML += pagging_last;
        }
    }

    function reqajaxkategoriPaging(val){
        let page = val.textContent;
        $.ajax({
                url: `{{route('kategori-list')}}`,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'get',
                data: {page:Number(page)},
                dataType: 'json',
                success: function(response){
                    let list_data = response.data.data;
                    const table_html = document.getElementById("table-body-kategori");
                    table_html.innerHTML= '';
                    const paging_html = document.getElementById("link-paging-id");
                    paging_html.innerHTML = '';
                    buildTable(list_data)
                    makePagination(response.data)
                    
                },
                error: function(err){
                    console.log('error',err);
                }
        })
    }
</script>
@endpush