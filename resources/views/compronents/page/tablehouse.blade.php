@extends('layouts.app')
@section('content')
<div class="container col-md-12">
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
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{url('addhome')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row me-5 ms-5">
                        <div class="row mt-3">
                            <div class="col">
                                <strong>House Number:</strong>
                                <input type="text" name="housenumber" class="form-control" placeholder="House Number">
                            </div>
                            <div class="col">
                                <strong>Owner:</strong>
                                <input type="text" name="owner" class="form-control" placeholder="Owner">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <strong>Email:</strong>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col">
                                <strong>Phone:</strong>
                                <input type="text" name="phone" class="form-control" placeholder="Phone">
                            </div>
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
        <div class="card mb-3">
            <div class="card-body">
                <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
                    <div class="col-3">
                        <form method="GET" action="{{ url('filterhouse') }}">
                            @csrf
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" placeholder="Enter Housenumber"
                                    name="housenumber" value="{{Request::get("housenumber")}}"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class='table-primary'>
                            <tr>
                                <th>No.</th>
                                <th>Owner</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($houses as $item)
                            <tr>
                                <td>{{$item->housenumber}}</td>
                                <td>{{$item->owner}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modaledit{{$item->id}}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modaldelete{{$item->id}}">
                                        Delete
                                    </button>
    </div>
                                    <!-- Modaledit -->
                                    <div class="modal fade" id="Modaledit{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/update/'.$item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <strong>House Number:</strong>
                                                                    <input type="text" value="{{$item->housenumber}}"
                                                                        name="housenumber" class="form-control"
                                                                        placeholder="House Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <strong>Owner:</strong>
                                                                    <input type="text" value="{{$item->owner}}"
                                                                        name="owner" class="form-control"
                                                                        placeholder="Owner">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <strong>Email:</strong>
                                                                    <input type="email" value="{{$item->email}}"
                                                                        name="email" class="form-control"
                                                                        placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <strong>Phone:</strong>
                                                                    <input type="text" value="{{$item->phone}}"
                                                                        name="phone" class="form-control"
                                                                        placeholder="Phone">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-outline-secondary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modaldelete -->
                                    <div class="modal fade" id="Modaldelete{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/destroy')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete Housenumber
                                                        {{$item->housenumber}}
                                                    </div>
                                                    <input type="hidden" name="id" value={{$item->id}}>
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
                    {{ $houses->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@endsection
