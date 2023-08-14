<div class="position-relative">
    {{-- table loader  --}}
    <div class="table_loader" >
        {{__('admin.loading')}}
    </div>
    {{-- table loader  --}}
    
    {{-- table content --}}
    <table class="table " id="tab">
        <thead>
            <tr>
                <th>
                    <label class="container-checkbox">
                        <input type="checkbox" value="value1" name="name1" id="checkedAll">
                        <span class="checkmark"></span>
                    </label>
                </th>

                <th>{{__('admin.name')}}</th>
                <th>{{__('admin.category_name')}}</th>
                <th>{{ __('admin.activation') }}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $service->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>

                    <td>{{ $service->name }}</td>
                    <td>{{$service->category->name}}</td>
                    <td>
                        @if ($service->status)
                            <span class="btn btn-sm round btn-outline-success">
                        {{ __('admin.activate') }} <i class="la la-close font-medium-2"></i>
                    </span>
                        @else
                            <span class="btn btn-sm round btn-outline-danger">
                        {{ __('admin.dis_activate') }} <i class="la la-check font-medium-2"></i>
                    </span>
                        @endif
                    </td>
                    
                    <td class="product-action"> 
                        <span class="text-primary"><a href="{{ route('admin.services.show', ['id' => $service->id]) }}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{ route('admin.services.edit', ['id' => $service->id]) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ url('admin/services/' . $service->id) }}"><i class="feather icon-trash"></i></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($services->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($services->count() > 0 && $services instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$services->links()}}
    </div>
@endif
{{-- pagination  links div --}}

