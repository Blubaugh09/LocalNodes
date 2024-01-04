<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContactedRequest;
use App\Http\Requests\StoreContactedRequest;
use App\Http\Requests\UpdateContactedRequest;
use App\Models\Contacted;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ContactedController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contacted_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacteds = Contacted::with(['user_started', 'user_ended', 'team'])->get();

        return view('admin.contacteds.index', compact('contacteds'));
    }

    public function create()
    {
        abort_if(Gate::denies('contacted_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_starteds = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_endeds = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.contacteds.create', compact('user_endeds', 'user_starteds'));
    }

    public function store(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
    
            // Validate the incoming request
            $request->validate([
                'contact_type' => 'required|string',
                'user_ended_id' => 'required|integer|exists:users,id'
            ]);
    
            // Create the Contacted record
            $contacted = Contacted::create([
                'contact_type' => $request->contact_type,
                'user_started_id' => Auth::id(), // The ID of the currently authenticated user
                'user_ended_id' => $request->user_ended_id
            ]);
    
            // Return a success response
            return response()->json(['message' => 'Contacted information stored successfully', 'contacted' => $contacted]);
    
        } catch (\Exception $e) {
            // Return a JSON response with the error message
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Contacted $contacted)
    {
        abort_if(Gate::denies('contacted_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_starteds = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_endeds = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contacted->load('user_started', 'user_ended', 'team');

        return view('admin.contacteds.edit', compact('contacted', 'user_endeds', 'user_starteds'));
    }

    public function update(UpdateContactedRequest $request, Contacted $contacted)
    {
        $contacted->update($request->all());

        return redirect()->route('admin.contacteds.index');
    }

    public function show(Contacted $contacted)
    {
        abort_if(Gate::denies('contacted_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacted->load('user_started', 'user_ended', 'team');

        return view('admin.contacteds.show', compact('contacted'));
    }

    public function destroy(Contacted $contacted)
    {
        abort_if(Gate::denies('contacted_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacted->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactedRequest $request)
    {
        $contacteds = Contacted::find(request('ids'));

        foreach ($contacteds as $contacted) {
            $contacted->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
