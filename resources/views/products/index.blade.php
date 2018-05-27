@extends('layouts.app')
@section('content')
<div id="page">
  <div class="page-header">
    <div class="row">
     <div class="col-sm-8"><center><h2>{{$primary_category}} {{$secondary_category}}</h2></center></div>
     <div class="col-sm-4">

        <!--
        <form action="/products/primary/{{$primary_category}}/secondary/{{$secondary_category}}">
          <div class="col-md-10 col-md-offset-1">
        <select class="form-control" name='sort' onchange='this.form.submit()'>
          <option<?php //if($sort == 'Sort By:'){echo' selected';} ?>>Sort By:</option>
          <option<?php //if($sort == 'Price: Low to High'){echo' selected';} ?>>Price: Low to High</option>
          <option<?php// if($sort == 'Price: High to Low'){echo' selected';} ?>>Price: High to Low</option>
          <option<?php// if($sort == 'Average Rating'){echo' selected';} ?>>Average Rating </option>
          <option<?php //if($sort == 'Popularity'){echo' selected';} ?>>Popularity</option>
        </select>
        <noscript><input type="submit" value="Submit"></noscript>
      </div>
      </form>
      -->

   </div>
    </div>
  </div>
  <div class="row">
  <div id="productIndexContainer">
    @forelse ($products as $product)
    <a href="/products/{{$product->id}}">
      <div class="col-xs-6 col-sm-4 col-lg-3">
        <div class="panel panel-default">
          <div style="height:355px" class="panel-body">
            @if(!empty($product->image))
              <img src="{{$product->image}}" alt="{{$product->name}}" />
            @endif
            {{$product->name}}
            </center>
          </div>
        </div>
      </div>
        </a>
          @empty
              <p>No products</p>
          @endforelse
    </div>
</div>
</div>
@endsection
