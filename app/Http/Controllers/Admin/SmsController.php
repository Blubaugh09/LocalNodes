<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySmsRequest;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Models\Role;
use App\Models\Sms;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $smss = Sms::with(['send_to_roles', 'team'])->get();

        return view('admin.smss.index', compact('smss'));
    }

    public function create()
    {
        abort_if(Gate::denies('sms_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $send_to_roles = Role::pluck('title', 'id');

        return view('admin.smss.create', compact('send_to_roles'));
    }

    public function store(StoreSmsRequest $request)
    {
        $sms = Sms::create($request->all());
        $sms->send_to_roles()->sync($request->input('send_to_roles', []));

        return redirect()->route('admin.smss.index');
    }

    public function edit(Sms $sms)
    {
        abort_if(Gate::denies('sms_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $send_to_roles = Role::pluck('title', 'id');

        $sms->load('send_to_roles', 'team');

        return view('admin.smss.edit', compact('send_to_roles', 'sms'));
    }

    public function update(UpdateSmsRequest $request, Sms $sms)
    {
        $sms->update($request->all());
        $sms->send_to_roles()->sync($request->input('send_to_roles', []));

        return redirect()->route('admin.smss.index');
    }

    public function show(Sms $sms)
    {
        abort_if(Gate::denies('sms_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->load('send_to_roles', 'team');

        return view('admin.smss.show', compact('sms'));
    }

    public function destroy(Sms $sms)
    {
        abort_if(Gate::denies('sms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->delete();

        return back();
    }

    public function massDestroy(MassDestroySmsRequest $request)
    {
        $smss = Sms::find(request('ids'));

        foreach ($smss as $sms) {
            $sms->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
