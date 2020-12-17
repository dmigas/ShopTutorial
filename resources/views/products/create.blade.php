@extends('layouts.app')

@section('content')
    <h1>Create new product</h1>
    <div class="row">
        <div class="col">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif

            <form method="post" action="/products" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{old('name')}}" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{old('description')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" value="{{old('price')}}" class="form-control" id="price" name="price" placeholder="Price">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" value="{{old('amount')}}" class="form-control" id="amount" name="amount" placeholder="Amount">
                </div>
                <div class="form-group">
                    <label for="categories">Select Attributes</label>
                    <select multiple class="form-control" id="categories" name="categories[]">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product-image">File input</label>
                    <input type="file" class="form-control-file" id="product-image" name="img">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
