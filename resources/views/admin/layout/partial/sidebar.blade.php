<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{url('admin/dashboard')}}">
                    <img class="brand-logo img-logo w-auto h-auto" src="{{Cache::get('settings')['logo']}}" alt="">
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {!! \App\Traits\SideBarTrait::sidebar() !!}
        </ul>
    </div>
</div>