@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.email.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.id') }}
                        </th>
                        <td>
                            {{ $email->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.body') }}
                        </th>
                        <td>
                            {{ $email->body }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.date_to_send') }}
                        </th>
                        <td>
                            {{ $email->date_to_send }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.time_to_send') }}
                        </th>
                        <td>
                            {{ $email->time_to_send }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.sent_to_men') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $email->sent_to_men ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.sent_to_women') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $email->sent_to_women ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.send_to_roles') }}
                        </th>
                        <td>
                            @foreach($email->send_to_roles as $key => $send_to_roles)
                                <span class="label label-info">{{ $send_to_roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection