@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <img src="{{ asset('storage/images/card_img.svg') }}" class="card-img-top" alt="a product">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>XXXXXX
                    @foreach($product->productAttributes as $attribute)
                        <p>{{$attribute->name}}: {{ $attribute->pivot->value }}</p>
                    @endforeach
                    <a href="#" class="btn btn-primary">Show</a>
                </div>
            </div>
        </div>
    </div>
@endsection
