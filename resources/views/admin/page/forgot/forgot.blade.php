<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot : </title>
    <meta charset="utf-8" />
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon" href="{{ asset('metro/assets/media/logos/favicon.ico') }}">
    <!--fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--fonts-->
    <!--css-->
    <link href="{{ asset('metro/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metro/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--css-->
</head>
<body
    id="kt_body"
    {{--    class="bg-dark"--}}
>
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset('metro/assets/media/illustrations/sketchy-1/14.png') }})">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <a href="{{url('/')}}" class="mb-12">
                <img alt="Logo" src="{{ asset('metro/assets/media/logos/logo-1.svg') }}" class="h-40px" />
            </a>
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                @if ( Session::get('message') != '' )
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <div class="d-flex flex-column">
                            <span>{{ Session::get('message') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.forgot') }}" method="post" class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Forgot Password ?</h1>
                        <div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
                        <input class="form-control form-control-solid" type="email" placeholder="" name="email" autocomplete="off" />
                    </div>

                    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                        <button type="button" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                            <span class="indicator-label">Forgot Password</span>
                            <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <a href="{{ adminRoute('login') }}" class="btn btn-lg btn-light-primary fw-bolder">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>const hostUrl = "{{ asset('metro/assets') }}";</script>
<script src="{{ asset('metro/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('metro/assets/js/custom/forgot/forgot.js') }}"></script>
</body>
</html>
