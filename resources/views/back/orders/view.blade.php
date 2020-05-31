@extends('layouts.dashboard')

@section('content')
	<div class="container bg-white">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="content-heading">
				<a href="{{url('admin/orders/all')}}">
						<button type="button" class="btn btn-md btn-default pull-left" style="margin-right: 15px;">
								<i class="fa fa-arrow-left" style="color:#000;"></i> <strong>Kthehu</strong>
						</button>
					</a>
					@if($order->status_id != 2)
						<a href="{{ route('confirm.order', $order->id) }}">
							<button type="button" class="btn btn-md btn-success pull-right">
									<i class="fa fa-check text-success mr-5" style="color:#fff;"></i> <strong>Konfirmo</strong>
							</button>
						</a>
					@endif

					@if($order->status_id != 3)
						<a href="{{route('cancel.order', $order->id)}}">
							<button type="button" class="btn btn-md btn-danger pull-right" style="margin-right: 5px;">
									<i class="fa fa-times mr-5" style="color:#fff;"></i> <strong>Anullo</strong>
							</button>
						</a>
					@endif
					POROSIA NUMER : {{$order->id}}
				</h2>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="block block-rounded">
					<div class="block-header block-header-default">
							<h3 class="block-title">Adresa e porosise</h3>
					</div>
					<div class="block-content">
							<h4>{{$order->user->getNameAttribute($order->user->name)}}</h4>
							<address>
							{{$order->user->location->address}}<br>
								{{$order->user->location->city}}<br>
								{{$order->user->location->country}}<br><br>
								<i class="fa fa-phone mr-5"></i> {{$order->user->location->phone_number}}<br>
								<i class="fa fa-envelope-o mr-5"></i> <a href="javascript:void(0)">{{$order->user->email}}</a>
							</address>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-9">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Produktet e porosise</h3>
						<div style="display: block;float: right;font-size: 18px;">Gjithsej : <span id="gjithsej" style="color:#d9534f;">EUR 0.00</span></div>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>#</th>
									<th>Emri</th>
									<th>Kodi</th>
									<th>Masa</th>
									<th>Cmimi</th>
									<th>Sasia</th>
									<th>Totali</th>
								</tr>
								@foreach($order->products as $product)
									<tr>
										<td>{{$loop->index + 1}}</td>
										<td>{{$product->title}}</td>
										<td>{{(!empty($product->product_code)) ? $product->product_code : '--'}}</td>
										<td>{{$product->getSizeName($product->pivot->size_id)}}</td>
										<td>EUR {{$product->getPriceFromSize($product->pivot->size_id)}}</td>
										<td>{{$product->pivot->qty}}</td>
										<td class="price_add">{{$product->getPriceFromSize($product->pivot->size_id) * $product->pivot->qty}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>

			<div class="col-xs-12"></div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var a = document.querySelectorAll('.price_add');
		var s = 0;

		a.forEach(e => {
			s += parseFloat(e.innerHTML);
		});

		document.getElementById("gjithsej").innerHTML = `EUR ${s}`;
	</script>
@endsection