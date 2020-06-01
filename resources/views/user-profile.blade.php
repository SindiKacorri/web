@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Porosite e mia </h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kodi porosise</th>
                <th>Adresa</th>
                <th>Statusi</th>
                <th>Produkte</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach (Auth::user()->orders as $o)
                <th>{{$o->id}}</th>
                <td>{{Auth::user()->location->address}}</td>
                <td>{{App\Models\OrderStatus::where('id', $o->status_id)->first()->name}}</td>
                <td>{{$o->products->count()}}</td>
                @endforeach

            </tr>
        </tbody>
    </table>
</div>
@endsection