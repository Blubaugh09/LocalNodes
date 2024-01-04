@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sms.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.smss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.id') }}
                        </th>
                        <td>
                            {{ $sms->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.message') }}
                        </th>
                        <td>
                            {{ $sms->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.date_to_send') }}
                        </th>
                        <td>
                            {{ $sms->date_to_send }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.time_to_send') }}
                        </th>
                        <td>
                            {{ $sms->time_to_send }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.sent_to_men') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $sms->sent_to_men ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.sent_to_woman') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $sms->sent_to_woman ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.send_to_roles') }}
                        </th>
                        <td>
                            @foreach($sms->send_to_roles as $key => $send_to_roles)
                                <span class="label label-info">{{ $send_to_roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.smss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection