<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Resources\Admin\EmailResource;
use App\Models\Email;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailResource(Email::with(['send_to_roles', 'team'])->get());
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create($request->all());
        $email->send_to_roles()->sync($request->input('send_to_roles', []));

        return (new EmailResource($email))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailResource($email->load(['send_to_roles', 'team']));
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());
        $email->send_to_roles()->sync($request->input('send_to_roles', []));

        return (new EmailResource($email))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
