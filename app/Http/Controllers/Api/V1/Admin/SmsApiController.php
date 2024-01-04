<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Http\Resources\Admin\SmsResource;
use App\Models\Sms;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SmsResource(Sms::with(['send_to_roles', 'team'])->get());
    }

    public function store(StoreSmsRequest $request)
    {
        $sms = Sms::create($request->all());
        $sms->send_to_roles()->sync($request->input('send_to_roles', []));

        return (new SmsResource($sms))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Sms $sms)
    {
        abort_if(Gate::denies('sms_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SmsResource($sms->load(['send_to_roles', 'team']));
    }

    public function update(UpdateSmsRequest $request, Sms $sms)
    {
        $sms->update($request->all());
        $sms->send_to_roles()->sync($request->input('send_to_roles', []));

        return (new SmsResource($sms))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Sms $sms)
    {
        abort_if(Gate::denies('sms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
