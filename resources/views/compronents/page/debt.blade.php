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
        <div class="card">
            <div class="card-body">
                <form action="{{url('debt')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row ms-5 me-5">
                        <div class="row mt-3">
                            <div class="col">
                                <strong>Housenumber:</strong>
                                <select class="form-select" aria-label="Default select example" name="house_id">
                                    @foreach($house as $item)
                                    <option value={{$item->id}}>{{$item->housenumber}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <strong>Amount:</strong>
                                <input type="number" value=0 name="amount" class="form-control" placeholder="Amount">
                            </div>
                        </div>

                        <div class="col">

                            <label for="exampleFormControlTextarea1" class="form-label"><strong>Note:</strong></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="note"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="container mt-3">
                        <div class="row text-center">
                            <div class="col">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
            <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
                <div class="col-3">
                    <form method="GET" action="{{ url('filterdebtpage') }}">
                        @csrf
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" placeholder="Enter Housenumber" name="housenumber"
                                value="{{Request::get("housenumber")}}" aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">search</button>
                        </div>
                    </form>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table me-4 ms-4">
                        <thead class='table-primary'>
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
                                <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#paid{{$item->id}}">
                                        Paid
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modaldeletedebt{{$item->id}}">
                                        Delete
                                    </button>
                                    </div>
                                    <!-- Modalpaid -->
                                    <div class="modal fade" id="paid{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">ชำระหนี้คงค้าง</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/updatedebt/'.$item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        
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
                                    <!-- ModalDelete -->
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- ModalPaid -->

@endsection
