@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create name code</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/products_images/create" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="product_id" value="{{$product_id->id}}">

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-2 control-label">Image</label>
                            <div class="col-md-6">
                                <input id="image" type="file" name="image[]" multiple="True" value="{{ old('image') }}" required autofocus>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add Admin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
