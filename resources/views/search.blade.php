@extends('layouts.front')

@section('title')
<title>Kerko produkte | Juliette Armand Albania</title>
@endsection

@section('content')
<section id="search-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<div class="search-section">
					<div class="title">Kategoritë</div>
					<div class="options">
						<ul class="s-categories">
							@foreach($categories as $cat)
							<li data-id="{{ $cat->id }}">{{ $cat->name }} ({{$cat->products_count}})</li>
							@endforeach
						</ul>
					</div>
				</div><!-- sc-->

				<div class="search-section">
					<div class="title">Përmasat</div>
					<div class="options sizes">
						@foreach($sizes as $size)
						<div class="s-size" data-id="{{ $size->id }}">
							<a>{{$size->name}}</a>
						</div>
						@endforeach

						<div class="clearfix"></div>
					</div>
				</div>

				<div class="search-section" style="border-bottom:none;">
					<button id="c_s_c" class="btn-clear">Pastro Filtrat</button>
					<button id="c_s" class="btn-search pull-right">Kërko</button>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8">
				<div class="ltd-s-wrapper">
					@foreach($products->chunk(4) as $chunked)
					<div class="row">
						@foreach($chunked as $product)
						<div class="col-xs-12 col-sm-2 col-md-3">
							<div class="ltd-s-item">
								<a href="{{ route('view.product', $product->uuid) }}">
									<div class="img-thumb">
										<img src="/front/products/thumbs/{{count($product->images) ? $product->images->first()->path : 'default.png'}}" alt="{{$product->title}}" class="img-responsive">
									</div>
									<div class="description">
										<h3 class="title">{{$product->title}}</h3>
										<div class="price">EUR {{$product->getPriceFromSize($product->sizes->first()->pivot->size_id)}}</div>
									</div>
								</a>
							</div>
						</div>
						@endforeach
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
	<script src="{{ mix('front/search.js') }}" defer></script>
@endsection