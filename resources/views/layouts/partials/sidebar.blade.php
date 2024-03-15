<div class="sidebar d-flex justify-content-between flex-wrap flex-column">
    <ul class="nav flex-column w-100">
        <!-- brand logo -->
        <a href="{{ route('dashboard') }}" class="h3 p-2">
            <img
                src="{{ asset(config('app.logo')) }}" alt="config('app.name', 'LaraBone')"
                class="d-inline-block align-top"
                style="max-height: 35px;">
        </a>
        @foreach(config('pages') as $menuItem)
            @if(auth()->user()->can($menuItem['permission']))
                @if(count($menuItem['children']) > 0)
                    @php
                        $isActive = request()->route()->getName() === $menuItem['href'] || in_array(request()->route()->getName(), array_column($menuItem['children'], 'href'));
                    @endphp
                    <li class="nav-item {{ $isActive ? 'active' : '' }}">
                        <a href="#"
                           class="nav-link dropdown-toggle collapsed d-flex align-items-center justify-content-between"
                           data-bs-toggle="collapse" data-bs-target="#menu-item-{{ $loop->iteration }}"
                           aria-expanded="true">
                            {{ __($menuItem['name']) }}
                        </a>
                        <div class="collapse {{ $isActive ? 'show' : '' }}"
                             id="menu-item-{{ $loop->iteration }}">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                @if(auth()->user()->can($menuItem['permission']))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs($menuItem['href']) ? 'current' : '' }}"
                                           href="{{ route($menuItem['href']) }}">{{ __($menuItem['text']) }}</a>
                                    </li>
                                @endif
                                @foreach($menuItem['children'] as $childItem)
                                    @if(auth()->user()->can($childItem['permission']) && $childItem['sidebar'] )
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs($childItem['href']) ? 'current' : '' }}"
                                               href="{{ route($childItem['href']) }}">{{ __($childItem['text']) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ request()->routeIs($menuItem['href']) ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route($menuItem['href']) }}">{{ __($menuItem['name']) }}</a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>

</div>
