@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" type="text/css"
    href="{{asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css')}}">

<style>
    .permissionCard {
        border: 0;
        margin-bottom: 13px;
    }

    .role-title {
        background: #5d54d4;
        padding: 12px;
        border-radius: 7px;
        /* margin-bottom: 10px; */
    }

    .list-unstyled {
        padding: 10px;
        height: 300px;
        /* scroll-behavior: smooth; */
        overflow: auto;
    }

    .selectP {
        margin-right: 10px;
        margin-top: 11px;
    }

    .title_lable {
        color: #4762dd !important;
    }

</style>
@endsection
@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.add')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{route('admin.roles.store')}}" method="post" novalidate>
                            @csrf
                            <div class="container mt-2">
                                <div style="display: flex; flex-direction: row-reverse; align-items: center">
                                    <p class="selectP">{{__('admin.select_all')}}</p>
                                    <input type="checkbox" id="checkedAll">
                                </div>
                            </div>
                            
                            <div class="row">
                                @foreach (languages() as $lang)
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">{{__('site.name_'.$lang)}}</label>
                                        <div class="controls">
                                            <input type="text" name="name[{{$lang}}]" class="form-control"
                                                placeholder="{{__('site.write') . __('site.name_'.$lang)}}" required
                                                data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="container mt-2">
                                <div class="row">
                                    @foreach ($routes as $routeKey => $value)
                                        @if (isset($value->getAction()['title']) && isset($value->getAction()['type']) && $value->getAction()['type'] == 'parent') 
                                            <div class="col-md-4">
                                                <div class="card permissionCard package bg-white shadow">

                                                    {{-- card title  --}}
                                                    <div class="role-title text-white" style="display: flex; justify-content: space-between;">
                                                        <div style="display: flex; flex-direction: row; align-items: center">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" name="permissions[]" value="{{$value->getName()}}" id="gtx_{{$routeKey}}" class="roles-parent">
                                                                <label for="gtx_{{$routeKey}}" dir="ltr"></label>
                                                            </div>
                                                            <p class="text-white selectP" for="gtx_{{$routeKey}}">{{__('admin.'.$value->getAction()["title"]) }}</p>
                                                        </div>
                                                        <div style="display: flex; flex-direction: row-reverse; align-items: center">
                                                            <p class="text-white selectP">{{__('admin.select_all')}}</p>
                                                            <input type="checkbox" class="checkChilds checkChilds_gtx_{{$routeKey}}" data-parent="gtx_{{$routeKey}}">
                                                        </div>
                                                    </div>

                                                    {{-- card list  --}}
                                                    <ul class="list-unstyled">
                                                        @if (isset($value->getAction()['child']) && count($value->getAction()['child'])) 
                                                            @foreach ($value->getAction()['child'] as $key => $child) 
                                                                <div class="form-group clearfix">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox"  name="permissions[]" data-parent="gtx_{{$routeKey}}" value="admin.{{$child}}"  id="{{$value->getName()}} {{$key}}" class="childs gtx_{{$routeKey}}">
                                                                        <label  for="{{$value->getName()}} {{$key}}" dir="ltr"></label>
                                                                    </div>
                                                                    <label class="title_lable" for=" {{$value->getName()}} {{$key}}">{{__('admin.'.$routes_data['"admin.' . $child . '"']['title'])}}</label>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <span class="text-danger position-absolute" style="top:50% ; left: 32%;">
                                                                {{__('admin.no_sub_routes')}}
                                                            </span>
                                                        @endif
                                                    </ul>

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <button type="submit"
                                    class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.add')}}</button>
                                <a href="{{ url()->previous() }}" type="reset"
                                    class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@section('js')
<script src="{{asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script>
    $(function () {
            // $('.roles-parent').change(function () {
            //     var childClass = '.' + $(this).attr('id');
            //     if (this.checked) {
            //         $(childClass).prop("checked", true);
            //     } else {
            //         $(childClass).prop("checked", false);
            //     }
            // });

            $('.roles-parent').change(function (e) {
                var id =  $(this).attr('id');
                if (!this.checked) {
                    var count = 0 
                    $("."+id).each(function() {
                        if (this.checked) {
                            count = count + 1 
                        }
                    });

                    if (count > 0 ) {
                        $('#'+id).prop('checked' , true)
                    }else{
                        $('#'+id).prop('checked' , false)
                    }
                }
            });
            $('.checkChilds').change(function () {
                var childClass =  $(this).data('parent');
                if (this.checked) {
                    $('.' +childClass).prop("checked", true);
                    $('#' +childClass).prop("checked", true);
                } else {
                    $('.' +childClass).prop("checked", false);
                    $('#' +childClass).prop("checked", false);
                }
            });

            $('.childs').change(function () {
                var parent =  $(this).data('parent');
                if (this.checked) {
                    $('#' +parent).prop("checked", true);
                    var count = 0 
                    $("."+parent).each(function() {
                        if (! this.checked) {
                            count = count + 1 
                        }
                    });
                    if (count > 0 ) {
                        $('.checkChilds_'+parent).prop('checked' , false)
                    }else{
                        $('.checkChilds_'+parent).prop('checked' , true)
                    }
                }else{
                    $('.checkChilds_'+parent).prop('checked' , false)
                }
            });
        });


        $("#checkedAll").change(function () {
            if (this.checked) {
                $("input[type=checkbox]").each(function () {
                    this.checked = true
                })
            } else {
                $("input[type=checkbox]").each(function () {
                    this.checked = false;
                })
            }
        });
</script>
@endsection