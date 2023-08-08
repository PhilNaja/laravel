@extends('layouts.app')
@section('content')
<div class="container col-md-12 ">
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
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    เพิ่มหนี้คงค้าง
                </div>
                <div class="card-body">
                    <form action="{{url('debt')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <strong>House Number:</strong>
                                <select class="form-select" aria-label="Default select example" name="house_id">
                                    @foreach($house as $item)
                                    <option value={{$item->id}}>{{$item->housenumber}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-3">
                                    <strong>Amount:</strong>
                                    <input type="number" value=0 name="amount" class="form-control"
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-3">
                                    <strong>Note:</strong>
                                    <input type="text" name="note" class="form-control" placeholder="Note">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    หนี้คงค้าง
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">บ้านเลขที่</th>
                                <th scope="col">ทั้งหมด</th>
                                <th scope="col">จ่ายแล้ว</th>
                                <th scope="col">หมายเหตุ</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($debt as $item)
                            <tr>
                                <th scope="row">{{$item->housenumber}}</th>
                                <td>{{$item->total_balance}}</td>
                                <td>{{$item->balance}}</td>
                                <td>{{$item->note}}</td>
                                <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#paid{{$item->id}}">
                                        Paid
                                    </button>
                                    <div class="modal fade" id="paid{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/updatedebt/'.$item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        ชำระหนี้คงค้าง
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>balace:</strong>
                                                                    <input type="number" name="balance"
                                                                        class="form-control" placeholder="balance">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#Modaldeletedebt{{$item->id}}">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="Modaldeletedebt{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/destroydebt')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete
                                                    </div>
                                                    <input type="hidden" name="id" value={{$item->id}}>
                                                    <input type="hidden" name="balance" value={{$item->balance}}>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
