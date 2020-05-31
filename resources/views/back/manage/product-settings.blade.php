@extends('layouts.dashboard')

@section('css')
<style>
	.nav-data li a {
		position: relative;
		display: block;
		padding: 10px 15px;
	}
	.nav-data li a:hover {
		cursor: pointer;
		background-color: #f1f1f1;
	}
</style>
@endsection
@section('content')
<div class="container">
	<div class="row">
		@if ($errors->any())
			<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
			</div>
		@endif
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Shto kategori per produkt</h3>
				</div>
				<div class="box-body">
					<form method="POST" action="{{ url('admin/category/create') }}">
						{{ csrf_field() }}
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" name="name">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-flat">Create!</button>
								</span>
						</div>
					</form>
					<!-- /input-group -->
				</div><!-- /.box-body -->
				<div class="box-body no-padding" style="">
					<ul class="nav nav-pills nav-stacked nav-m440 nav-data">
						@foreach($categories as $category)
						<form action="/admin/category/{{ $category->id }}/delete" class="delete-cat"  method="POST">
							{{ csrf_field() }}
						<li><a style="color: #000;">{{ $category->name }} <i class="fa fa-remove text-red pull-right"></i></a></li>
						</form>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Shto permase per produkt</h3>
				</div>
				<div class="box-body">
					<form method="POST" action="{{ url('admin/size/create') }}">
						{{ csrf_field() }}
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" name="name">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-flat">Create!</button>
								</span>
						</div>
					</form>
						<!-- /input-group -->
				</div><!-- /.box-body -->
				<div class="box-body no-padding" style="">
					<ul class="nav nav-pills nav-stacked nav-m440 nav-data">
						@foreach($sizes as $s)
						<form action="/admin/size/{{ $s->id }}/delete" class="delete-cat" method="POST">
							{{ csrf_field() }}
						<li><a style="color: #000;">{{ $s->name }}<i class="fa fa-remove text-red pull-right"></i></a></li>
						</form>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Shto Skin Type per produkt</h3>
				</div>
				<div class="box-body">
					<form method="POST" action="{{ url('admin/skin-type/create') }}">
						{{ csrf_field() }}
						<div class="input-group input-group-sm">
							<div class="col-xs-12 col-md-6">
								<input type="text" class="form-control" name="name" placeholder="Skin Name">
							</div>
							<div class="col-xs-12 col-md-6">
								<input type="text" class="form-control" name="code" placeholder="Skin Code">
							</div>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-flat">Create!</button>
								</span>
						</div>
					</form>
					<!-- /input-group -->
				</div><!-- /.box-body -->
				<div class="box-body no-padding" style="">
					<ul class="nav nav-pills nav-stacked nav-m440 nav-data">
						@foreach($skin_types as $skin_type)
						<form action="/admin/skin-type/{{ $skin_type->id }}/delete" class="delete-cat" method="POST">
							{{ csrf_field() }}
						<li><a style="color: #000;">{{ $skin_type->name }} ({{$skin_type->code}})<i class="fa fa-remove text-red pull-right"></i></a></li>
						</form>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>


</div>
@endsection

@section('scripts')
<script type="text/javascript">

	$("form.delete-cat").on('click', function(e){
		e.preventDefault();
		 var $this = $(this);

		e.preventDefault();
		swal({
		  title: "Are you sure?",
		  text: "You will not be able to recover articles in this category!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete!",
		  cancelButtonText: "No, cancel!",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  if (isConfirm) {
			 $this.submit();
		  }
		});
	});
</script>
@endsection