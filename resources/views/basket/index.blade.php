@extends('layouts.app')
@section('content')
<form method="POST" action="/basket/update">
  {{ csrf_field()}}
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th>
        <th>Product</th>
        <th>Qty.</th>
        <th>Unit Price</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
        @foreach($basket as $product)
        <tr>
          <td><img style="width:100px;" src="{{$product->image}}" alt="{{$product->name}}" /></td>
          <td>{{$product->name}}</td>
          <td><input type="text" name="{{$product->id}}" value="{{$product->quantity}}"></td>
          <td>{{$product->price}}</td>
          <td>{{$product->totalProductPriceByQty}}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <input type="submit" value="Submit">
</form>
@endsection
