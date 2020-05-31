@extends('layouts.front')

@section('content')
	<div class="container">
		<form action="{{url('order')}}" method="POST">
				{{csrf_field()}}
		<div class="row mgtb50">
				<div class="col-xs-12 col-sm-6">
					<div class="user-address">
						<h3 class="title">Adresa e Dorëzimit</h3>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6">
									<label>Emri:</label>
									<input type="text" name="first_name" class="form-control" value="" />
								</div>
								<div class="col-xs-6">
									<label>Mbiemri:</label>
									<input type="text" name="last_name" class="form-control" value="" />
								</div>
							</div><!--row-->
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-12">
									<label>Shteti:</label>
									<input type="text" class="form-control" name="country" value="" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-12">
									<label>Qyteti:</label>
									<input type="text" class="form-control" name="city" value="" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-12">
									<label>Adresa:</label>
									<input type="text" class="form-control" name="address" value="" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-6">
									<label>Email:</label>
									<input type="email" name="email" class="form-control" value="" />
								</div>
								<div class="col-xs-6">
									<label>Numri celular:</label>
									<input type="tel" name="phone_number" class="form-control" value="" />
								</div>
							</div><!--row-->
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-12">
									<label>Informacion shtesë:</label>
									<textarea id="" cols="30" rows="10" name="message"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-offset-1">
					<div class="your-order">
						<h3 class="title">Porosia juaj</h3>
						<div class="checkout-list">
							<h4 class="title">Produktet</h4>
							<ul id="products-summary">

							</ul>
						</div>
						<div class="prop-value">
							<div class="prop">Shuma<span class="value" id="sum1">EUR 0.00</span></div>
							<input type="hidden" name="qty" id="pqty">
						</div>

						<div class="prop-value">
							<div class="prop">Transporti<span class="value" style="color:#b6b6b6;">EUR 0.00</span></div>
						</div>

						<div class="prop-value">
							<div class="prop">Totali<span class="value text-red" id="sum2">EUR 0.00</span></div>
							<input type="hidden" name="sIds" id="psi">
						</div>
						<div class="prop-value">
							<input type="hidden" name="pIds" id="pid">
							<div class="prop" style="font-size:12px;text-align:center;color:#ef6a49;font-style:italic;">Pagesa bëhet në momentin e dorëzimit të porosisë.</div>
						</div>
						<div style="margin-top:25px;text-align:center;">
							<button class="btn finish-order" id="ltd-order">përfundo porosinë</button>
						</div>
					</div>
					</div>
				</div>
			</div>
			</form>
	</div>
@endsection

@section('scripts')
<script>
	window.fchojl = true;
</script>
@endsection