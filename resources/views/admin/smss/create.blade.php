@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sms.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.smss.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.sms.fields.message') }}</label>
                <input class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" type="text" name="message" id="message" value="{{ old('message', '') }}" required>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to_send">{{ trans('cruds.sms.fields.date_to_send') }}</label>
                <input class="form-control date {{ $errors->has('date_to_send') ? 'is-invalid' : '' }}" type="text" name="date_to_send" id="date_to_send" value="{{ old('date_to_send') }}">
                @if($errors->has('date_to_send'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_to_send') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.date_to_send_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_to_send">{{ trans('cruds.sms.fields.time_to_send') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_to_send') ? 'is-invalid' : '' }}" type="text" name="time_to_send" id="time_to_send" value="{{ old('time_to_send') }}">
                @if($errors->has('time_to_send'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_to_send') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.time_to_send_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sent_to_men') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sent_to_men" value="0">
                    <input class="form-check-input" type="checkbox" name="sent_to_men" id="sent_to_men" value="1" {{ old('sent_to_men', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sent_to_men">{{ trans('cruds.sms.fields.sent_to_men') }}</label>
                </div>
                @if($errors->has('sent_to_men'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sent_to_men') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.sent_to_men_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sent_to_woman') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sent_to_woman" value="0">
                    <input class="form-check-input" type="checkbox" name="sent_to_woman" id="sent_to_woman" value="1" {{ old('sent_to_woman', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sent_to_woman">{{ trans('cruds.sms.fields.sent_to_woman') }}</label>
                </div>
                @if($errors->has('sent_to_woman'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sent_to_woman') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.sent_to_woman_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="send_to_roles">{{ trans('cruds.sms.fields.send_to_roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('send_to_roles') ? 'is-invalid' : '' }}" name="send_to_roles[]" id="send_to_roles" multiple>
                    @foreach($send_to_roles as $id => $send_to_role)
                        <option value="{{ $id }}" {{ in_array($id, old('send_to_roles', [])) ? 'selected' : '' }}>{{ $send_to_role }}</option>
                    @endforeach
                </select>
                @if($errors->has('send_to_roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('send_to_roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.send_to_roles_helper') }}</span>
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