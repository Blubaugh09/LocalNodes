<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\Contacted;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\MemberCategory;
use App\Models\Roles;

class HomeController
{
   
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $authUser = Auth::user(); // Get the authenticated user
    
        // Check if the authenticated user has a role with id 1
        if ($authUser->roles()->where('id', 1)->exists()) {
            // User has role_id of 1, fetch all users
            $users = User::with(['mother', 'father', 'roles', 'team', 'media'])->get();
        } else {
            // User does not have role_id of 1, fetch users from the same team
            $users = User::with(['mother', 'father', 'roles', 'team', 'media'])
                         ->where('team_id', $authUser->team_id)
                         ->get();
        }
        $roles = Role::get();
        $teams = Team::get();
     
        // Logic to prepare nodes and links for GoJS
        $nodes = [];
        $links = [];
        $lastContactedDates = $this->getLastContactedDates();
    
        foreach ($users as $user) {
            $canEdit = Gate::allows('user_edit', $user);

            // Fetch category colors for the user
            $categoryColors = $user->memberCategories()->with('category')->get()->pluck('category.color_code')->toArray();
            $categoryData = $user->memberCategories()->with('category')->get()->map(function ($memberCategory) {
                return [
                    'color_code' => $memberCategory->category->color_code,
                    'icon_path' => $memberCategory->category->icon_path
                ];
            })->toArray();
            
            $nodes[] = [
                'key' => $user->id,
                'name' => $user->name,
                'categoryColors' => $categoryColors, // Include category colors
                'canEdit' => $canEdit,
                'phone' => $user->phone,
                'email' => $user->email,
                'categoryData' => $categoryData,
                // ... other details ...
            ];
    
            // Assuming phone, email, and address are attributes of the User model
            if ($user->phone) {
                $nodes[] = [
                    'key' => $user->id . '_phone', 
                    'name' => 'Call ' . $user->phone, 
                    'phone' => $user->phone, // Include the phone number here
                    'color' => 'orange'
                ];
                $links[] = ['from' => $user->id, 'to' => $user->id . '_phone'];
            }
            
            if ($user->email) {
                $nodes[] = [
                    'key' => $user->id . '_email', 
                    'name' => 'Email ' . $user->email, 
                    'email' => $user->email, // Include the email here
                    'color' => 'yellow'
                ];
                $links[] = ['from' => $user->id, 'to' => $user->id . '_email'];
            }
            
            if ($user->address) {
                $nodes[] = ['key' => $user->id . '_address', 'name' => $user->address, 'color' => 'green'];
                $links[] = ['from' => $user->id, 'to' => $user->id . '_address'];
            }
            if ($user->notes) {
                $nodes[] = ['key' => $user->id . '_notes', 'name' => $user->notes, 'color' => 'orange'];
                $links[] = ['from' => $user->id, 'to' => $user->id . '_notes'];
            }
        }
        $categories = Category::all();
        // Make sure to pass nodes and links to the view
        return view('home', compact('roles', 'teams', 'users', 'nodes', 'links', 'lastContactedDates', 'categories'));
    }

    public function getLastContactedDates()
    {
        $authUserId = Auth::id();
        $lastContactedDates = Contacted::select('user_ended_id', DB::raw('MAX(updated_at) as last_contacted'))
                                       ->where('user_started_id', $authUserId)
                                       ->groupBy('user_ended_id')
                                       ->get()
                                       ->pluck('last_contacted', 'user_ended_id');

        return $lastContactedDates;
    }


    

}
