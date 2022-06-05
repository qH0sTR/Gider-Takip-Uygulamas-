@extends('app')
@section('icerik')

<div role="main" class="main">
    <div class="container">
        <div class="row">
            <div class="kol col-12">    
                <div class="container">
                    <div class="row">
                        <div class="">
                           <h2 class="my-3">Kategorilere Göre Rapor</h2>
                            <table class="table">
                                <thead id="kategoriler_thead">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Ödeme Sayısı</th>
                                        <th scope="col">Ortalama Ödeme Tutarı</th>
                                        <th scope="col">Toplam Ödeme Tutarı</th>
                                    </tr>
                                </thead>
                                <tbody id="rehber">

                                    @foreach($categories as $category => $row)
                                    <tr>
                                        <td>1</td>
                                        <td>{{$category}}</td>
                                        <td>{{$row["count_of_payments"]}}</td>
                                        <td>{{$row["mean_of_payments"]}}</td>
                                        <td>{{$row["total_payment"]}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('css')
@endsection
@section('js')
<script>
    $(function() {

    })
</script>
@endsection