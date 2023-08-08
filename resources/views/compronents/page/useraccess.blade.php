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
        <div class="card mb-2">
            <div class="card-body">
                <div class="ms-5 me-5">
                    <form method="POST" action="{{ url('create') }}">
                        @csrf
                        <div class="row mt-3">
                            <div class="col">

                                <input type="text" name="name" class="form-control" placeholder="name"
                                    aria-label="First name">
                            </div>
                            <div class="col">
                                <input type="text" name="email" class="form-control" placeholder="Email"
                                    aria-label="Last name">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input id="password" type="password" placeholder="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <input id="password-confirm" type="password" class="form-control"
                                    placeholder="confirm password" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="row text-center">
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-body">
                <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
                    <div class="col-3">
                        <form method="GET" action="{{ url('usersreach') }}">
                            @csrf
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" placeholder="search" name="name"
                                    value="{{Request::get("name")}}" aria-label="Recipient's username"
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                @if($item->role==0)
                                <td>Noaml User</td>
                                @endif
                                @if($item->role==1)
                                <td>Staff</td>
                                @endif
                                <td>{{$item->email_verified_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaledit{{$item->id}}">
                                            Edit Role
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaldelete{{$item->id}}">
                                            Delete
                                        </button>
                                    </div>

                                    <div class="modal fade" id="Modaledit{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('updaterole') }}" method="PUT"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <strong>Role:</strong>
                                                            <select class="form-select"
                                                                aria-label="Default select example" name="role">
                                                                <option selected>Open this select menu</option>
                                                                <option value="0">Noaml User</option>
                                                                <option value="1">staff</option>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="id" value={{$item->id}}>
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

                                    <div class="modal fade" id="Modaldelete{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/destroy/')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete User ID
                                                        {{$item->id}}
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
