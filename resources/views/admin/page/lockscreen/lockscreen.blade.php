<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOCKSCREEN : {{Session::get('appname')}}</title>
    <meta charset="utf-8" />
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon" href="{{ asset('metro/assets/media/logos/favicon.ico') }}">
    <!--fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--fonts-->
    <link href="{{ asset('metro/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--css-->
    <link href="{{ asset('metro/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metro/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--css-->
</head>
<!--head-->
<!--Body-->
<body
    id="kt_body"
    {{--    class="bg-dark"--}}
>
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset('metro/assets/media/illustrations/sketchy-1/14.png')}})">
        <!--content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--logo-->
            <a href="{{url('/')}}" class="mb-12">
                <img alt="Logo" src="{{ asset('metro/assets/media/logos/logo-1.svg') }}" class="h-40px" />
            </a>
            <!--logo-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                @if(session('message'))
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <div class="d-flex flex-column">
                            <span>{{ session('message') }}</span>
                        </div>
                    </div>
                @endif

                <form autocomplete='off' action="{{ route('admin.lockscreen') }}" method="post" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="d-flex mb-10">
                        <div class="d-flex align-items-center me-auto ms-auto">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-75px symbol-circle">
                                @if(fileExists(\App\Traits\Admin\Authentication::auth()->photo) && \App\Traits\Admin\Authentication::auth()->photo)
                                    <img alt="Logo" src="{{ asset(\App\Traits\Admin\Authentication::auth()->photo) }}" alt="Pic" />
                                @else
                                    <img alt="Logo" src="{{ asset('metro/assets/media/avatars/300-1.jpg') }}" alt="Pic" />
                                @endif
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Details-->
                            <div class="ms-5">
                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">
                                    {{ \App\Traits\Admin\Authentication::auth()->name  }}
                                </a>
                                <div class="fw-bold text-muted">
                                    {{ \App\Traits\Admin\Authentication::auth()->email  }}
                                </div>
                            </div>
                            <!--end::Details-->
                        </div>
                    </div>
                    <div class="fv-row mb-10">
                        <div class="form-label fw-bolder text-gray-900 fs-6 text-center">Enter your password to retrieve your session</div>
                        <input type="password" class="form-control form-control-solid" required name='password' placeholder="password"/>
                    </div>

                    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                        <button type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <a href="{{ route("admin.logout") }}" class="btn btn-lg btn-light-primary fw-bolder">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>const hostUrl = "{{ asset('metro/assets') }}";</script>
<script src="{{ asset('metro/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/custom/lockscreen/lockscreen.js') }}"></script>
</body>
</html>
