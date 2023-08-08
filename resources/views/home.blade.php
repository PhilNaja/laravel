@extends('layouts.app')
@section('content')
<div class="container">
    <!-- @if ($errors->any())
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
    </script> -->
    <div class="row">
        <div class="col-sm-8">
            @if (session('userdata'))
            <div class="card">
                <h5 class="card-header">บิลภายในปีนี้</h5>
                <div class="card-body">
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
                            @foreach(session('userdata') as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->billingcycle}}</td>
                                <td>{{$item->amount}}</td>
                                <td>
                                    @if($item->ispaid==0)
                                    ยังไม่ชำระ
                                    @endif
                                    @if($item->ispaid==1)
                                    ชำระแล้ว
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
               
                    <h5 class="card-title">ยอดทั้งหมดที่ค้างชำระ</h5>
                    <p class="card-text"> {{session('price')}}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
