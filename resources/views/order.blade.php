@extends('layouts.front')

@section('content')
	<div class="container">
		<div class="row">
			<div class="orders-wrapper">
				<div class="head">
					<div class="pname w45 xs-w-100">Përshkrimi</div>
					<div class="pprice w15 hidden-xs">Çmimi</div>
					<div class="pqty w15 hidden-xs">Sasia</div>
					<div class="ptotal w25 hidden-xs">Totali</div>
					<div class="clearfix"></div>
				</div>
				<div class="orders-items-wrapper" id="odp">

				</div>
				<div class="foot">
					<div class="button-group">
						<a href="{{url('/')}}">
							<button class="btn btn-favourite">Vazhdo me blerjet</button>
						</a>
						<div class="clear-shop"><i class="fas fa-times"></i> Pastro shportën</div>
					</div>
					<div class="subtotal">Totali: <span class="price" id="sum">EUR 0.00</span>
					</div>
				</div>
				<div class="process">
					<a href="{{url('checkout')}}">
						<button class="btn finish-order">përfundo porosinë</button>
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	window.genjopt = true;
</script>
@endsection