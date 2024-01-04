<div id="sidebar" class="c-sidebar c-sidebar-fixed ">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.user.title') }}
                </a>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/teams*") ? "c-show" : "" }} {{ request()->is("admin/related-tos*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('team_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.teams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.team.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('related_to_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.related-tos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/related-tos") || request()->is("admin/related-tos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.relatedTo.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('contacted_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.contacteds.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contacteds") || request()->is("admin/contacteds/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contacted.title') }}
                </a>
            </li>
        @endcan
        @can('email_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.emails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emails") || request()->is("admin/emails/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.email.title') }}
                </a>
            </li>
        @endcan
        @can('sms_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.smss.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/smss") || request()->is("admin/smss/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-comment c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.sms.title') }}
                </a>
            </li>
        @endcan
        @can('category_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.category.title') }}
                </a>
            </li>
        @endcan
        @can('member_category_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.member-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/member-categories") || request()->is("admin/member-categories/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.memberCategory.title') }}
                </a>
            </li>
        @endcan
        @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
            <li class="c-sidebar-nav-item">
                <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "c-active" : "" }} c-sidebar-nav-link" href="{{ route("admin.team-members.index") }}">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-users">
                    </i>
                    <span>{{ trans("global.team-members") }}</span>
                </a>
            </li>
        @endif
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>