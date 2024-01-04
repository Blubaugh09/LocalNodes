<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmailRequest;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Email;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emails = Email::with(['send_to_roles', 'team'])->get();

        return view('admin.emails.index', compact('emails'));
    }

    public function create()
    {
        abort_if(Gate::denies('email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $send_to_roles = Role::pluck('title', 'id');

        return view('admin.emails.create', compact('send_to_roles'));
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create($request->all());
        $email->send_to_roles()->sync($request->input('send_to_roles', []));

        return redirect()->route('admin.emails.index');
    }

    public function edit(Email $email)
    {
        abort_if(Gate::denies('email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $send_to_roles = Role::pluck('title', 'id');

        $email->load('send_to_roles', 'team');

        return view('admin.emails.edit', compact('email', 'send_to_roles'));
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());
        $email->send_to_roles()->sync($request->input('send_to_roles', []));

        return redirect()->route('admin.emails.index');
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->load('send_to_roles', 'team');

        return view('admin.emails.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailRequest $request)
    {
        $emails = Email::find(request('ids'));

        foreach ($emails as $email) {
            $email->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
