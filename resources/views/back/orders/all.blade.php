@extends('layouts.dashboard')


@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				  <div class="box-header">
					 <h3 class="box-title">Te gjitha porosite</h3>

					 {{-- <div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
						  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

						  <div class="input-group-btn">
							 <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						  </div>
						</div>
					 </div> --}}
				  </div>
				  <!-- /.box-header -->
				  <div class="box-body table-responsive no-padding">
					 <table class="table table-hover ltd-table">
						<tbody>
						<tr>
						  <th>ID</th>
						  <th>Personi</th>
						  <th>Telefon</th>
						  <th>Data e porosise</th>
						  <th>Porosia</th>
						  <th>Statusi</th>
						</tr>
						@foreach($orders as $o)
							<tr data-href="{{route('view.order', $o->id)}}">
								<td>{{$o->id}}</td>
								<td>{{$o->user->name}}</td>
								<td>{{$o->user->location->phone_number}}</td>
								<td>{{$o->created_at}}</td>
								<td>{{$o->products->count()}} Produkte</td>
								<td style="font-size:17px;">
									@if($o->status_id == 1)
									<span class="label label-md label-warning">Ne pritje</span>
									@elseif($o->status_id == 2)
									<span class="label label-success">Konfirmuar</span>
									@elseif($o->status_id == 3)
									<span class="label label-danger">Anulluar</span>
									@endif
								</td>
							</tr>
							@endforeach
					 </tbody>
					</table>
				  </div>
				  <!-- /.box-body -->
				</div>
				<!-- /.box -->
			 </div>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$(function(){
		$(".table").on("click", "tr[data-href]", function (e) {
			window.location = $(this).data("href");
		});
	});
</script>
@endsection