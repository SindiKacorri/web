@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile</div>

                <div class="panel-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif

                <form class="form-horizontal" method="POST" action="{{ route ('user.update')}}">
                    {{csrf_field()}}
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-7">
                  <input type="text" class="form-control" name="name" id="inputName" placeholder="Name" value="{{Auth::user()->name}}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-7">
                    <button type="submit" class="btn btn-default pull-right">Update</button>
                  </div>
                </div>
              </form>
            </div>

            </div>

        </div>
    </div>
</div>
@endsection
