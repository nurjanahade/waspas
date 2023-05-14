@extends('main')
@section('container')
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="container-fluid border-bottom">
            <div class="row">
                <div class="col-6">
                    <h2 class=" d-flex justify-content-start">Hasil Akhir Perhitungan</h4>
                </div>
                
            </div>
            <div class="table-responsive">

                <table class="table m-2 ">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Ranking</th>
                            <th scope="col">Nama</th>
                            <th>Nilai Qi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($a = 0; $a < $alternatifCount; $a++)
                            <tr>
                                <td></td>
                                <td>{{ $alternatif[$a] }}</td>
                                <td>{{ $dataQi[$a] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
