<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRelatedToRequest;
use App\Http\Requests\StoreRelatedToRequest;
use App\Http\Requests\UpdateRelatedToRequest;
use App\Models\RelatedTo;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RelatedToController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('related_to_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $relatedTos = RelatedTo::with(['initial_contact', 'related_tos', 'team'])->get();

        return view('admin.relatedTos.index', compact('relatedTos'));
    }

    public function create()
    {
        abort_if(Gate::denies('related_to_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $initial_contacts = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $related_tos = User::pluck('name', 'id');

        return view('admin.relatedTos.create', compact('initial_contacts', 'related_tos'));
    }

    public function store(StoreRelatedToRequest $request)
    {
        $relatedTo = RelatedTo::create($request->all());
        $relatedTo->related_tos()->sync($request->input('related_tos', []));

        return redirect()->route('admin.related-tos.index');
    }

    public function edit(RelatedTo $relatedTo)
    {
        abort_if(Gate::denies('related_to_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $initial_contacts = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $related_tos = User::pluck('name', 'id');

        $relatedTo->load('initial_contact', 'related_tos', 'team');

        return view('admin.relatedTos.edit', compact('initial_contacts', 'relatedTo', 'related_tos'));
    }

    public function update(UpdateRelatedToRequest $request, RelatedTo $relatedTo)
    {
        $relatedTo->update($request->all());
        $relatedTo->related_tos()->sync($request->input('related_tos', []));

        return redirect()->route('admin.related-tos.index');
    }

    public function show(RelatedTo $relatedTo)
    {
        abort_if(Gate::denies('related_to_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $relatedTo->load('initial_contact', 'related_tos', 'team');

        return view('admin.relatedTos.show', compact('relatedTo'));
    }

    public function destroy(RelatedTo $relatedTo)
    {
        abort_if(Gate::denies('related_to_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $relatedTo->delete();

        return back();
    }

    public function massDestroy(MassDestroyRelatedToRequest $request)
    {
        $relatedTos = RelatedTo::find(request('ids'));

        foreach ($relatedTos as $relatedTo) {
            $relatedTo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
