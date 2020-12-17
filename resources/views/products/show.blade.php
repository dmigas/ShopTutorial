@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                @foreach($product->productImages as $image)
                    <img src="{{ asset('storage/' . str_replace('public/', '', $product->productImages()->first()->path)) }}" class="card-img-top" alt="a product">
                @endforeach
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>

                    @foreach($product->categories as $category)
                        <h4><span class="badge badge-secondary">{{$category->name}}</span></h4>
                    @endforeach

                    <p><h3>{{$product->price}} €</h3></p>
                    <a href="#" class="btn btn-primary">In den Einkaufswagen</a>
                </div>
            </div>
        </div>
    </div>
@endsection
