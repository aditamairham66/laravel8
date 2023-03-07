<!DOCTYPE html>
<html lang="en">
<!--head-->
<head>
    <title>Login : {{Session::get('appname')}}</title>
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
            <!--wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                @if(session('message'))
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <div class="d-flex flex-column">
                            <span>{{ session('message') }}</span>
                        </div>
                    </div>
                @endif

                <form autocomplete='off' action="{{ route('admin.login') }}" method="post" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Please login to start your session</h1>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <input class="form-control form-control-lg form-control-solid" type="email" name="username" autocomplete="off" />
                    </div>
                    <div class="fv-row mb-10">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            <a href="{{ adminRoute('forgot') }}" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                        </div>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                    </div>
                    <div class="text-center">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">Sign in</span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>

</div>
<script>const hostUrl = "{{ asset('metro/assets') }}";</script>
<script src="{{ asset('metro/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/scripts.bundle.js') }}"></script>

<script src="{{ asset('metro/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>

<script src="{{ asset('metro/assets/js/custom/login/login.js?='.date('ymdhis')) }}"></script>
</body>
</html>
