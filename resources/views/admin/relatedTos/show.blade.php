@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.relatedTo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.related-tos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.relatedTo.fields.id') }}
                        </th>
                        <td>
                            {{ $relatedTo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.relatedTo.fields.initial_contact') }}
                        </th>
                        <td>
                            {{ $relatedTo->initial_contact->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.relatedTo.fields.related_to') }}
                        </th>
                        <td>
                            @foreach($relatedTo->related_tos as $key => $related_to)
                                <span class="label label-info">{{ $related_to->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.related-tos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection