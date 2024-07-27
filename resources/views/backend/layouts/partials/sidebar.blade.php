<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header" style="padding: 10px 17px;">
            <a class="header-brand1" href="{{ route('dashboard') }}" style="width: -webkit-fill-available;">
                <img src="{{ asset('backend/images/brand/logo-white.png') }}" class="header-brand-img desktop-logo" alt="logo" style="width: -webkit-fill-available;">
                <img src="{{ asset('backend/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ asset('backend/images/brand/logo-2.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('backend/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo" style="width: -webkit-fill-available;">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                {{-- @canany(['request_a_quote', 'view_pending_quotes', 'view_proposals', 'view_insurance_requests'])
                    <li class="sub-category">
                        <h3>{{ auth()->user()->roles[0]->name == 'client' ? 'Client' : 'SRC' }} Panel Area</h3>
                    </li>
                @endcanany
                @canany(['request_a_quote', 'view_pending_quotes'])
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-cast"></i><span class="side-menu__label">Quotes</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            @can('request_a_quote')
                                <li><a href="{{ route('backend.request-a-quote') }}" class="slide-item"> Request a Quote</a></li>
                            @endcan
                            @can('view_pending_quotes')
                                <li><a href="{{ route('pending-quotes') }}" class="slide-item"> Pending Quotes</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany --}}
                @canany(['view_reports', 'write_prescription'])
                    <li class="sub-category">
                        <h3>Reporting</h3>
                    </li>
                    @can('write_prescription')
                        <li class="slide">
                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('reports.write-prescription') }}">
                                <i class="side-menu__icon fe fe-edit-3"></i>
                                <span class="side-menu__label">Write Prescription</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_reports')
                    <li class="slide {{ Request::is('reports*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Request::is('reports*') ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-file-text"></i><span class="side-menu__label">Reports</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu {{ Request::is('reports*') ? 'open' : '' }}">
                            <li class="{{ Request::is('reports/all*') ? 'is-expanded' : '' }}"><a href="{{ route('reports.index', 'all') }}" class="slide-item {{ Request::is('reports/all*') ? 'active' : '' }}"> All Reports</a></li>
                            <li class="{{ Request::is('reports/pending*') ? 'is-expanded' : '' }}"><a href="{{ route('reports.index', 'pending') }}" class="slide-item {{ Request::is('reports/pending*') ? 'active' : '' }}"> Pending Reports</a></li>
                            <li class="{{ Request::is('reports/accepted*') ? 'is-expanded' : '' }}"><a href="{{ route('reports.index', 'accepted') }}" class="slide-item {{ Request::is('reports/accepted*') ? 'active' : '' }}"> Accepted Reports</a></li>
                            <li class="{{ Request::is('reports/rejected*') ? 'is-expanded' : '' }}"><a href="{{ route('reports.index', 'rejected') }}" class="slide-item {{ Request::is('reports/rejected*') ? 'active' : '' }}"> Rejected Reports</a></li>
                        </ul>
                    </li>
                    @endcan
                @endcanany
                @canany(['view_patients', 'view_users', 'view_roles'])
                    <li class="sub-category">
                        <h3>Manage</h3>
                    </li>
                @endcanany
                @can('view_patients')
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('patients.index') }}">
                            <i class="side-menu__icon mdi mdi-account-plus"></i>
                            <span class="side-menu__label">Patients</span>
                        </a>
                    </li>
                @endcan
                @can('view_users')
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('users.index') }}">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Users</span>
                        </a>
                    </li>
                @endcan
                @can('view_roles')
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('roles.index') }}">
                            <i class="side-menu__icon fe fe-check-square"></i>
                            <span class="side-menu__label">Role & Permissions</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
