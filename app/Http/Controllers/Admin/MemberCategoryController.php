<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMemberCategoryRequest;
use App\Http\Requests\StoreMemberCategoryRequest;
use App\Http\Requests\UpdateMemberCategoryRequest;
use App\Models\Category;
use App\Models\MemberCategory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MemberCategoryController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('member_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $memberCategories = MemberCategory::with(['category', 'members', 'team'])->get();

        return view('admin.memberCategories.index', compact('memberCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('member_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::pluck('name', 'id');

        return view('admin.memberCategories.create', compact('categories', 'members'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $categoryId = $request->input('category_id');
            $selectedNodes = $request->input('members', []);
    
            // First, remove nodes from their previous categories if they are being reassigned
            foreach ($selectedNodes as $nodeId) {
                // Find categories other than the current one that this node is part of
                $previousCategories = MemberCategory::where('category_id', '<>', $categoryId)
                                    ->whereHas('users', function ($query) use ($nodeId) {
                                        $query->where('user_id', $nodeId);
                                    })->get();
    
                // Detach the node from these categories
                foreach ($previousCategories as $prevCat) {
                    $prevCat->users()->detach($nodeId);
                }
            }
    
            // Now, add the nodes to the new category
            $memberCategory = MemberCategory::firstOrCreate(
                ['category_id' => $categoryId, 'team_id' => Auth::user()->team_id]
            );
            $memberCategory->users()->syncWithoutDetaching($selectedNodes);
    
            DB::commit();
            return response()->json(['message' => 'Members updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
    
    
    

    

    public function edit(MemberCategory $memberCategory)
    {
        abort_if(Gate::denies('member_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::pluck('name', 'id');

        $memberCategory->load('category', 'members', 'team');

        return view('admin.memberCategories.edit', compact('categories', 'memberCategory', 'members'));
    }

    public function update(UpdateMemberCategoryRequest $request, MemberCategory $memberCategory)
    {
        $memberCategory->update($request->all());
        $memberCategory->members()->sync($request->input('members', []));

        return redirect()->route('admin.member-categories.index');
    }

    public function show(MemberCategory $memberCategory)
    {
        abort_if(Gate::denies('member_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $memberCategory->load('category', 'members', 'team');

        return view('admin.memberCategories.show', compact('memberCategory'));
    }

    public function destroy(MemberCategory $memberCategory)
    {
        abort_if(Gate::denies('member_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $memberCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyMemberCategoryRequest $request)
    {
        $memberCategories = MemberCategory::find(request('ids'));

        foreach ($memberCategories as $memberCategory) {
            $memberCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}
