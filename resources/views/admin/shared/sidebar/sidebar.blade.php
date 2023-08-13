@foreach ($routes as $value)
    @if ($value->getName() !== null && isset($value->getAction()['title']) && isset($value->getAction()['icon']) && isset($value->getAction()['type']) && $value->getAction()['type'] == 'parent') 
        @if (in_array($value->getName(), $my_routes) && isset($value->getAction()['sub_route']) && $value->getAction()['sub_route'] == true && isset($value->getAction()['child']) && count($value->getAction()['child'])) 
            @include('admin.shared.sidebar.dropdown', compact('value' , 'routes_data'))
        @elseif (in_array($value->getName(), $my_routes))
            @include('admin.shared.sidebar.single_side_bar' , compact('value'))
        @endif
    @endif
@endforeach