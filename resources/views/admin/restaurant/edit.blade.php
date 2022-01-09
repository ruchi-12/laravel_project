@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('global.restaurant.title_singular') }}
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.restaurant.update", [$restaurant->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="name">{{ trans('global.restaurant.fields.name') }}*</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($restaurant) ? $restaurant->name : '') }}">
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.name_helper') }}
                            </p>

                            <label for="code">{{ trans('global.restaurant.fields.code') }}*</label>
                            <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($restaurant) ? $restaurant->code : '') }}">
                            @if($errors->has('code'))
                                <p class="help-block">
                                    {{ $errors->first('code') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.code_helper') }}
                            </p>

                            <label for="description">{{ trans('global.restaurant.fields.description') }}*</label>
                            <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($restaurant) ? $restaurant->description : '') }}">
                            @if($errors->has('description'))
                                <p class="help-block">
                                    {{ $errors->first('description') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.description_helper') }}
                            </p>

                            <label for="phone">{{ trans('global.restaurant.fields.phone') }}*</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($restaurant) ? $restaurant->phone : '') }}">
                            @if($errors->has('phone'))
                                <p class="help-block">
                                    {{ $errors->first('phone') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.phone_helper') }}
                            </p>

                            <label for="email">{{ trans('global.restaurant.fields.email') }}*</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($restaurant) ? $restaurant->email : '') }}">
                            @if($errors->has('email'))
                                <p class="help-block">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.email_helper') }}
                            </p>

                            <label for="image">{{ trans('global.restaurant.fields.image') }}*</label><br />
                            <img src="{{asset('uploads/'.$restaurant->images->image)}}" alt="restaurant_image" height="50px" width="50px"/>
                            <input type="file" id="image" name="image" class="form-control" value="{{ old('image', isset($restaurant) ? $restaurant->images->image : '') }}">
                            @if($errors->has('image'))
                                <p class="help-block">
                                    {{ $errors->first('image') }}
                                </p>
                            @endif
                            <p class="helper-block">
                                {{ trans('global.restaurant.fields.image_helper') }}
                            </p>


                        </div>
                        <div>
                            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection