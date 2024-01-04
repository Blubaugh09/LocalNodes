<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberCategoryRequest;
use App\Http\Requests\UpdateMemberCategoryRequest;
use App\Http\Resources\Admin\MemberCategoryResource;
use App\Models\MemberCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('member_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MemberCategoryResource(MemberCategory::with(['category', 'members', 'team'])->get());
    }

    public function store(StoreMemberCategoryRequest $request)
    {
        $memberCategory = MemberCategory::create($request->all());
        $memberCategory->members()->sync($request->input('members', []));

        return (new MemberCategoryResource($memberCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MemberCategory $memberCategory)
    {
        abort_if(Gate::denies('member_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MemberCategoryResource($memberCategory->load(['category', 'members', 'team']));
    }

    public function update(UpdateMemberCategoryRequest $request, MemberCategory $memberCategory)
    {
        $memberCategory->update($request->all());
        $memberCategory->members()->sync($request->input('members', []));

        return (new MemberCategoryResource($memberCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MemberCategory $memberCategory)
    {
        abort_if(Gate::denies('member_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $memberCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
