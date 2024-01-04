@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.contacted.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.contacteds.update", [$contacted->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_started_id">{{ trans('cruds.contacted.fields.user_started') }}</label>
                <select class="form-control select2 {{ $errors->has('user_started') ? 'is-invalid' : '' }}" name="user_started_id" id="user_started_id">
                    @foreach($user_starteds as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_started_id') ? old('user_started_id') : $contacted->user_started->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_started'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_started') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contacted.fields.user_started_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_ended_id">{{ trans('cruds.contacted.fields.user_ended') }}</label>
                <select class="form-control select2 {{ $errors->has('user_ended') ? 'is-invalid' : '' }}" name="user_ended_id" id="user_ended_id">
                    @foreach($user_endeds as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_ended_id') ? old('user_ended_id') : $contacted->user_ended->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_ended'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_ended') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contacted.fields.user_ended_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.contacted.fields.contact_type') }}</label>
                @foreach(App\Models\Contacted::CONTACT_TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('contact_type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="contact_type_{{ $key }}" name="contact_type" value="{{ $key }}" {{ old('contact_type', $contacted->contact_type) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="contact_type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('contact_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contacted.fields.contact_type_helper') }}</span>
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