@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contacted.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacteds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contacted.fields.id') }}
                        </th>
                        <td>
                            {{ $contacted->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contacted.fields.user_started') }}
                        </th>
                        <td>
                            {{ $contacted->user_started->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contacted.fields.user_ended') }}
                        </th>
                        <td>
                            {{ $contacted->user_ended->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contacted.fields.contact_type') }}
                        </th>
                        <td>
                            {{ App\Models\Contacted::CONTACT_TYPE_RADIO[$contacted->contact_type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacteds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection