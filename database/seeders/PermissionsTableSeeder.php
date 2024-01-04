<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'contacted_create',
            ],
            [
                'id'    => 23,
                'title' => 'contacted_edit',
            ],
            [
                'id'    => 24,
                'title' => 'contacted_show',
            ],
            [
                'id'    => 25,
                'title' => 'contacted_delete',
            ],
            [
                'id'    => 26,
                'title' => 'contacted_access',
            ],
            [
                'id'    => 27,
                'title' => 'related_to_create',
            ],
            [
                'id'    => 28,
                'title' => 'related_to_edit',
            ],
            [
                'id'    => 29,
                'title' => 'related_to_show',
            ],
            [
                'id'    => 30,
                'title' => 'related_to_delete',
            ],
            [
                'id'    => 31,
                'title' => 'related_to_access',
            ],
            [
                'id'    => 32,
                'title' => 'email_create',
            ],
            [
                'id'    => 33,
                'title' => 'email_edit',
            ],
            [
                'id'    => 34,
                'title' => 'email_show',
            ],
            [
                'id'    => 35,
                'title' => 'email_delete',
            ],
            [
                'id'    => 36,
                'title' => 'email_access',
            ],
            [
                'id'    => 37,
                'title' => 'sms_create',
            ],
            [
                'id'    => 38,
                'title' => 'sms_edit',
            ],
            [
                'id'    => 39,
                'title' => 'sms_show',
            ],
            [
                'id'    => 40,
                'title' => 'sms_delete',
            ],
            [
                'id'    => 41,
                'title' => 'sms_access',
            ],
            [
                'id'    => 42,
                'title' => 'category_create',
            ],
            [
                'id'    => 43,
                'title' => 'category_edit',
            ],
            [
                'id'    => 44,
                'title' => 'category_show',
            ],
            [
                'id'    => 45,
                'title' => 'category_delete',
            ],
            [
                'id'    => 46,
                'title' => 'category_access',
            ],
            [
                'id'    => 47,
                'title' => 'member_category_create',
            ],
            [
                'id'    => 48,
                'title' => 'member_category_edit',
            ],
            [
                'id'    => 49,
                'title' => 'member_category_show',
            ],
            [
                'id'    => 50,
                'title' => 'member_category_delete',
            ],
            [
                'id'    => 51,
                'title' => 'member_category_access',
            ],
            [
                'id'    => 52,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
