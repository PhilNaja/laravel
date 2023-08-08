@extends('layouts.app')
@section('content')
<div class="container">
    @if ($errors->any())
    <div id="success-alert"
        class="alert alert-danger alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div id="success-alert"
        class="alert alert-success alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
        {{ session('success') }}
    </div>
    @endif
    <script>
        function closeAlert() {
            document.getElementById('success-alert').style.display = 'none';
        }
        setTimeout(closeAlert, 3000);

    </script>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    บิล
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead class='table-success'>
                                <tr>
                                    <th>เลขที่บิล</th>
                                    <th>รอบบิล</th>
                                    <th>ที่ต้องชำระ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paid as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->billingcycle}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>
                                        @if($item->ispaid==0)
                                        ยังไม่ได้จ่าย
                                        @endif
                                        @if($item->ispaid==1)
                                        จ่ายแล้ว
                                        @endif
                                    </td>
                                    <td>
                                        <a class='btn btn-success' href="{{ url('detail/'.$item->id) }}">รายละเอียด</a>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
