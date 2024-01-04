@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.email.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.emails.update", [$email->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="body">{{ trans('cruds.email.fields.body') }}</label>
                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="body" required>{{ old('body', $email->body) }}</textarea>
                @if($errors->has('body'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.body_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to_send">{{ trans('cruds.email.fields.date_to_send') }}</label>
                <input class="form-control date {{ $errors->has('date_to_send') ? 'is-invalid' : '' }}" type="text" name="date_to_send" id="date_to_send" value="{{ old('date_to_send', $email->date_to_send) }}">
                @if($errors->has('date_to_send'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_to_send') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.date_to_send_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_to_send">{{ trans('cruds.email.fields.time_to_send') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_to_send') ? 'is-invalid' : '' }}" type="text" name="time_to_send" id="time_to_send" value="{{ old('time_to_send', $email->time_to_send) }}">
                @if($errors->has('time_to_send'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_to_send') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.time_to_send_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sent_to_men') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sent_to_men" value="0">
                    <input class="form-check-input" type="checkbox" name="sent_to_men" id="sent_to_men" value="1" {{ $email->sent_to_men || old('sent_to_men', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sent_to_men">{{ trans('cruds.email.fields.sent_to_men') }}</label>
                </div>
                @if($errors->has('sent_to_men'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sent_to_men') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.sent_to_men_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sent_to_women') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sent_to_women" value="0">
                    <input class="form-check-input" type="checkbox" name="sent_to_women" id="sent_to_women" value="1" {{ $email->sent_to_women || old('sent_to_women', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sent_to_women">{{ trans('cruds.email.fields.sent_to_women') }}</label>
                </div>
                @if($errors->has('sent_to_women'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sent_to_women') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.sent_to_women_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="send_to_roles">{{ trans('cruds.email.fields.send_to_roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('send_to_roles') ? 'is-invalid' : '' }}" name="send_to_roles[]" id="send_to_roles" multiple>
                    @foreach($send_to_roles as $id => $send_to_role)
                        <option value="{{ $id }}" {{ (in_array($id, old('send_to_roles', [])) || $email->send_to_roles->contains($id)) ? 'selected' : '' }}>{{ $send_to_role }}</option>
                    @endforeach
                </select>
                @if($errors->has('send_to_roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('send_to_roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.send_to_roles_helper') }}</span>
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