@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.memberCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.member-categories.update", [$memberCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.memberCategory.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $memberCategory->category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.memberCategory.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="members">{{ trans('cruds.memberCategory.fields.members') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('members') ? 'is-invalid' : '' }}" name="members[]" id="members" multiple>
                    @foreach($members as $id => $member)
                        <option value="{{ $id }}" {{ (in_array($id, old('members', [])) || $memberCategory->members->contains($id)) ? 'selected' : '' }}>{{ $member }}</option>
                    @endforeach
                </select>
                @if($errors->has('members'))
                    <div class="invalid-feedback">
                        {{ $errors->first('members') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.memberCategory.fields.members_helper') }}</span>
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