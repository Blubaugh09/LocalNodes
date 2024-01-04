@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.relatedTo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.related-tos.update", [$relatedTo->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="initial_contact_id">{{ trans('cruds.relatedTo.fields.initial_contact') }}</label>
                <select class="form-control select2 {{ $errors->has('initial_contact') ? 'is-invalid' : '' }}" name="initial_contact_id" id="initial_contact_id">
                    @foreach($initial_contacts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('initial_contact_id') ? old('initial_contact_id') : $relatedTo->initial_contact->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('initial_contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('initial_contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.relatedTo.fields.initial_contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="related_tos">{{ trans('cruds.relatedTo.fields.related_to') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('related_tos') ? 'is-invalid' : '' }}" name="related_tos[]" id="related_tos" multiple>
                    @foreach($related_tos as $id => $related_to)
                        <option value="{{ $id }}" {{ (in_array($id, old('related_tos', [])) || $relatedTo->related_tos->contains($id)) ? 'selected' : '' }}>{{ $related_to }}</option>
                    @endforeach
                </select>
                @if($errors->has('related_tos'))
                    <div class="invalid-feedback">
                        {{ $errors->first('related_tos') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.relatedTo.fields.related_to_helper') }}</span>
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