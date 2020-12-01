@extends('layouts.app')

@section('content')
    <div class="row row-cols-1 row-cols-md-3">
        @foreach($products as $product)
            <div class="col mb-4">
                <div class="card">
                    <img src="{{ asset('storage/images/card_img.svg') }}" class="card-img-top" alt="a product">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <a href="/products/{{ $product->id }}" class="btn btn-primary">Show</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection


