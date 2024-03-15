<nav class="navbar navbar-expand-md bg-light">
    <div class="container-fluid">
        @guest
            <a class="navbar-brand ms-4" href="/">
                <img
                    src="{{ asset(config('app.logo')) }}" alt="config('app.name', 'LaraBone')"
                    class="d-inline-block align-top"
                    style="max-height: 35px;">
            </a>
        @else
            @if(auth()->user()->id == 1)
                <a class="btn btn-primary border-0 sidebar-toggle"><i class="bi bi-bar-chart-steps"></i></a>
            @endif
        @endguest

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end">
                {{-- @if(count(config('panel.available_languages', [])) > 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-globe"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach(config('panel.available_languages') as $langLocale => $langName)
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == $langLocale ? 'd-none': '' }}"
                                       href="{{ url()->current() }}?lang={{ $langLocale }}">{{ $langName }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif --}}
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                               href="{{ route('login') }}">{{ __('global.login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="{{ asset(auth()->user()->avatar) }}"
                                 alt="Avatar" class="rounded-circle"
                                 height="30">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('users.show') ? 'active' : '' }}"
                                   href="{{ route('users.show', auth()->user()->id) }}">
                                    {{ __('global.profile') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('global.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            &nbsp;
        </div>
    </div>
</nav>
