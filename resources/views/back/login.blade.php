<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Login Page | JA </title>
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />

  <link rel="stylesheet" href="{{asset('back/css/login.css')}}" type="text/css" />

</head>
<body>
<div class="app app-header-fixed ">

<div class="container w-xxl w-auto-xs">
  <a href class="navbar-brand block m-t" tabindex="-1">JA</a>
  <div class="m-b-lg">
    <div class="wrapper text-center">
      <strong>Please note that unauthorized access is forbidden!</strong>
    </div>
    <form name="form" class="form-validation" method="POST" action="{{ url('/admin-login') }}">
      {{ csrf_field() }}
      <div class="text-danger wrapper text-center" >
          <!-- show error-->
      </div>
      <div class="list-group list-group-sm">
        <div class="list-group-item">
          <input type="text" name="email" placeholder="Username" autocomplete="username" class="form-control no-border" required>
        </div>
        @if($errors->has('email'))
          <div class="text-danger wrapper text-center">
            {{ $errors->first('email') }}
          </div>
        @endif
        <div class="list-group-item">
           <input type="password" name="password" placeholder="Password" autocomplete="current-password" class="form-control no-border" required autofocus>
        </div>
        @if($errors->has('password'))
          <div class="text-danger wrapper text-center">
            {{ $errors->first('password') }}
          </div>
        @endif
      </div>
      <button type="submit" class="btn btn-lg btn-primary btn-block">Log in</button>
      <div class="line line-dashed"></div>
    </form>
  </div>
  <div class="text-center">
    <p>
  <small class="text-muted">JA |  Login &copy; 2019</small>
</p>
  </div>
</div>

</div>

</body>
</html>