<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title',isset(\Request::route()->getAction()['title']) ? __('admin.'.\Request::route()->getAction()['title']) : '')</title>
    
    @if (lang() == 'ar')
        <link rel="stylesheet" href="{{asset('css/rtl.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @endif
    <link rel="apple-touch-icon" href="{{Cache::get('settings')['fav_icon']}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{Cache::get('settings')['fav_icon']}}">   
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        .navigation.navigation-main {
            font-family: 'Cairo', sans-seri;
            font-weight: 600;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @yield('css')

</head>

<body style="font-family: 'Cairo', sans-serif !important;font-weight:700;" id="content_body" class="position-relative vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <div class="loader">
        <div class="sk-chase">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>
    </div>