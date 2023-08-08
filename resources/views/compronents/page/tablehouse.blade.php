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
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header">
                    เพิ่มรายชื่อบ้าน
                </div>
                <div class="card-body">
                    <form action="{{url('addhome')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group my-2">
                                    <strong>House Number:</strong>
                                    <input type="text" name="housenumber" class="form-control"
                                        placeholder="House Number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-2">
                                    <strong>Owner:</strong>
                                    <input type="text" name="owner" class="form-control" placeholder="Owner">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-2">
                                    <strong>Email:</strong>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-2">
                                    <strong>Phone:</strong>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-header">
                    รายชื่อบ้าน
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead class='table-secondary'>
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
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#Modaledit{{$item->id}}">
                                            Edit
                                        </button>
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
                                                                        <input type="text"
                                                                            value="{{$item->housenumber}}"
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
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#Modaldelete{{$item->id}}">
                                            Delete
                                        </button>
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
