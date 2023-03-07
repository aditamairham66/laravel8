<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', 'Dashboard')</title>

    @include('admin.layout.plugin.css')

    @stack('head')
</head>
<body
    id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px"
>

<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <!--SIDEBAR-->
        @include('admin.layout.sidebar')
        <!--END SIDEBAR-->

        <!--CONTENT WRAPPER-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--HEADER-->
            @include('admin.layout.header')
            <!--END HEADER-->

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--TOOLBAR-->
                <div class="toolbar" id="kt_toolbar">
                    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                                {{ env('APP_NAME') }}
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">@yield('page_title', 'Dashboard')</small>
                            </h1>
                        </div>

                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            @if($button->isShow)
                                <a
                                    href="{{ adminMainRoute("") }}"
                                    class="btn btn-sm btn-primary"
                                    id="btn_show_data"
                                    title="Show Data"
                                >
                                    <i class="fa fa-table"></i>
                                    Show Data
                                </a>
                            @endif

                            @if($button->isAdd)
                                <a
                                    href="{{ adminMainRoute("add") }}"
                                    class="btn btn-sm btn-success"
                                    id="btn_add_new_data"
                                    title="Add Data"
                                >
                                    <i class="fa fa-plus-circle"></i>
                                    Add Data
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--END TOOLBAR-->
                <!--CONTENT-->
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <div id="kt_content_container" class="container-xxl">
                        @include('admin.layout.alert')

                        @include('admin.layout.message')

                        @yield('content')
                    </div>
                </div>
                <!--END CONTENT-->
            </div>

            <!--FOOTER-->
            @include('admin.layout.footer')
            <!--END FOOTER-->

        </div>
        <!--END CONTENT WRAPPER-->
    </div>
</div>

@include('admin.layout.plugin.js')

@stack('bottom')

</body>
</html>
