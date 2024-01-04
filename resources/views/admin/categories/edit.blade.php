@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categories.update", [$category->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.category.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="color_code">{{ trans('cruds.category.fields.color_code') }}</label>
                <input class="form-control {{ $errors->has('color_code') ? 'is-invalid' : '' }}" type="text" name="color_code" id="color_code" value="{{ old('color_code', $category->color_code) }}">
                @if($errors->has('color_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('color_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.color_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="icon_path">{{ trans('cruds.category.fields.icon_path') }}</label>
                <input class="form-control {{ $errors->has('icon_path') ? 'is-invalid' : '' }}" type="text" name="icon_path" id="icon_path" value="{{ old('icon_path', $category->icon_path) }}">
                @if($errors->has('icon_path'))
                    <div class="invalid-feedback">
                        {{ $errors->first('icon_path') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.icon_path_helper') }}</span>
            </div>
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection