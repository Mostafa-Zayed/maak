<li class="nav-item {{in_array(substr(Route::currentRouteName(), 6), $value->getAction()['child']) ? 'has-sub sidebar-group-active open' : '' }}">
    <a href="javascript:void(0);">
        <span class="menu-title">{!!$value->getAction()['icon']!!} {{__('admin.'.$value->getAction()['title'])}}</span>
    </a>
    <ul class="menu-content">
        @foreach ($value->getAction()['child'] as $child)
            @if (isset($routes_data['"admin.' . $child . '"']) && $routes_data['"admin.' . $child . '"']['title'] && $routes_data['"admin.' . $child . '"']['icon'])
                <li class="{{('admin.'.$child) == Route::currentRouteName() ? 'active' : ''}}">
                    <a href="{{route('admin.'.$child)}}">
                        <i class="feather icon-circle"></i>{{ __('admin.'.$routes_data['"admin.' . $child . '"']['title'])}}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
