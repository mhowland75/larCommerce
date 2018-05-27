@extends('layouts.app')
@section('content')
<form class="form-horizontal" method="POST" action='/basket/create'>
  {{ csrf_field()}}
<input name="product_id" type="hidden" value="{{ $product->id}}">
<div class="form-group">
    <label for="usr">Qty:</label>
    <select name="quantity">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
    </select>
    <button type="submit" class="btn btn-primary">Add to cart</button>
</form>
 @foreach($product->images as $image)

       <img src="{{$image->image}}" style="width:100%">
 @endforeach

  {{$product->name}}
  {{$product->price}}
  @foreach($product->reviews as $review)
    {{$review->title}}
  @endforeach
@endsection
