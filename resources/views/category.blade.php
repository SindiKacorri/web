@extends('layouts.front')

@section('title')
<title>Kategoria {{$category->name}} | Juliette Armand Albania</title>
@endsection

@section('content')
<section id="search-page">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-9 col-md-offset-1">
				<div class="cat-overview">
					<h1 class="category-v-title text-center">{{$category->name}}</h1>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="ltd-s-wrapper">
					@foreach($category->products->chunk(4) as $chunked)
					<div class="row">
						@foreach($chunked as $product)
						<div class="col-xs-12 col-sm-6 col-md-3">
							<div class="ltd-s-item">
								<a href="{{route('view.product', $product->uuid)}}">
									<div class="img-thumb">
										<img src="/front/products/thumbs/{{$product->images->first()->path}}" alt="{{$product->title}}" class="img-responsive">
									</div>
									<div class="description">
										<h3 class="title">{{$product->title}}</h3>
										<div class="price">EUR {{$product->sizes->first()->pivot->price}}</div>
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