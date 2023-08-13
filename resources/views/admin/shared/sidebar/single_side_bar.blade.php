<li class="nav-item {{$value->getName() == Route::currentRouteName() ? 'active' : ''}}">
    <a href="{{route($value->getName())}}">
        {!!$value->getAction()['icon']!!} <span class="menu-title">{{__('admin.'.$value->getAction()['title'])}}</span> 
    </a>
</li>