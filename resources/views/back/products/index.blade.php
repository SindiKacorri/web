@extends('layouts.dashboard')

@section('content')
<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				  <div class="box-header">
					 <h3 class="box-title">Te gjitha produktet</h3>

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
						  <th>Titulli</th>
						  <th>Kategoria</th>
						  <th>Cmimi</th>
						  <th>Data</th>
						  <th>Veprime</th>
						</tr>
						@foreach($products as $p)
							<tr data-href="{{route('view.order', $p->id)}}">
								<td>{{$p->id}}</td>
								<td>{{$p->title}}</td>
								<td>{{$p->category->name}}</td>
								@if($p->sizes)
									<td>{{$p->sizes->first()->pivot->price}}</td>
									@else
									<td><span class="label label-md label-success">Special</span></td>
								@endif
								<td>{{$p->created_at->diffForHumans()}}</td>
								<td style="font-size:17px;">
									<a href="{{route('view.product', $p->uuid)}}">
										<span class="label label-md label-success">Shiko</span>
									</a>
									<a href="{{route('edit.product', $p->id)}}">
									{{-- @if($o->status_id == 1) --}}
										<span class="label label-md label-warning">Ndrysho</span>
									</a>
									{{-- @elseif($o->status_id == 2) --}}
									{{-- <span class="label label-success">Konfirmuar</span> --}}
									{{-- @elseif($o->status_id == 3) --}}
									{{-- <span class="label label-danger">Anulluar</span> --}}
									{{-- @endif --}}
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