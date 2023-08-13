<?php

namespace App\Traits;

trait MenuTrait {
  public function home() {

    $menu = [
      [
        'name'  => __('admin.admins'),
        'count' => \App\Models\Admin::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/admins'),
      ], [
        'name'  => __('admin.users'),
        'count' => \App\Models\User::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/clients'),
      ], [
        'name'  => __('admin.socials'),
        'count' => \App\Models\Social::count(),
        'icon'  => 'icon-thumbs-up',
        'url'   => url('admin/socials'),
      ], [
        'name'  => __('admin.complaints_and_proposals'),
        'count' => \App\Models\Complaint::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/all-complaints'),
      ], [
        'name'  => __('admin.reports'),
        'count' => \App\Models\LogActivity::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/reports'),
      ], [
        'name'  => __('admin.cities'),
        'count' => \App\Models\Country::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/countries'),
      ], [
        'name'  => __('admin.countries'),
        'count' => \App\Models\City::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/cities'),
      ], [
        'name'  => __("admin.common_questions"),
        'count' => \App\Models\Fqs::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/fqs'),
      ], [
        'name'  => __('admin.definition_pages'),
        'count' => \App\Models\Intro::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/intros'),
      ], [
        'name'  => __('admin.advertising_banners'),
        'count' => \App\Models\Image::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/images'),
      ], [
        'name'  => __('admin.message_packages'),
        'count' => \App\Models\SMS::count(),
        'icon'  => 'icon-list',
        'url'   => url('admin/sms'),
      ], [
        'name'  => __('admin.Validities'),
        'count' => \App\Models\Role::count(),
        'icon'  => 'icon-eye',
        'url'   => url('admin/roles'),
      ],
    ];

    return $menu;
  }

  public function introSiteCards() {
    $menu = [
      [
        'name'  => __('admin.insolder'),
        'count' => \App\Models\IntroSlider::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introsliders'),
      ],
      [
        'name'  => __('admin.Service_Suite'),
        'count' => \App\Models\IntroService::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introservices'),
      ],
      [
        'name'  => __('admin.questions_sections'),
        'count' => \App\Models\IntroFqsCategory::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introfqscategories'),
      ],
      [
        'name'  => __('admin.common_questions'),
        'count' => \App\Models\IntroFqs::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introfqs'),
      ],
      [
        'name'  => __('admin.Success_Partners'),
        'count' => \App\Models\IntroPartener::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introparteners'),
      ],
      [
        'name'  => __('admin.Customer_messages'),
        'count' => \App\Models\IntroMessages::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/intromessages'),
      ],
      [
        'name'  => __('admin.socials'),
        'count' => \App\Models\IntroSocial::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introsocials'),
      ],
      [
        'name'  => __('admin.how_the_site_works_section'),
        'count' => \App\Models\IntroHowWork::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introhowworks'),
      ],
    ];
    return $menu;
  }

}