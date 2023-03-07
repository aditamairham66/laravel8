@extends('admin.layout.index')
@section('page_title', $page_title)
@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{ $page_title }}</h3>
        </div>
        <form action="{{ $link }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="card-body">
                <div class="col-md-10">

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2 required"
                            title="this field required"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-dismiss="click"
                            data-bs-placement="left"
                        >Name</label>
                        <input
                            type="text" name="name" placeholder="You can only enter the letter only"
                            autofocus
                            class="form-control form-control-solid"
                            value="{{ old('name', (!empty($form->name)?$form->name:null)) }}"
                        >
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("name")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2 required"
                            title="this field required"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-dismiss="click"
                            data-bs-placement="left"
                        >Email</label>
                        <input
                            type="email" name="email"
                            class="form-control form-control-solid" placeholder="Please enter a valid email address"
                            value="{{ old('email', (!empty($form->email)?$form->email:null)) }}"
                        >
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("email")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label class="form-label col-sm-3 required" title="this field required"
                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                               data-bs-dismiss="click" data-bs-placement="left">Privilege</label>
                        <select name="privilege" id="privilege" data-control="select2" class="form-select form-select-solid">
                            <option value="">Choose Privilege**</option>
                            @foreach($privileges as $rowPrivilege)
                                <option
                                    value="{{ $rowPrivilege->id }}"
                                    @if($rowPrivilege->id == old('privilege', (!empty($form->cms_privileges_id)?$form->cms_privileges_id:null))) selected @endif
                                >{{ $rowPrivilege->name }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("privilege")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2 required"
                            title="this field required"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-dismiss="click"
                            data-bs-placement="left"
                        >Photo</label>
                        @if(!empty($form->photo))
                            <a
                                class="d-block overlay mb-5 w-175px"
                                data-fslightbox="lightbox-hot-sales"
                                href="{{ asset($form->photo) }}"
                            >
                                <div
                                    class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                    style="background-image:url('{{ asset($form->photo) }}');"
                                ></div>
                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                    <i class="bi bi-eye-fill fs-2x text-white"></i>
                                </div>
                            </a>

                            <a
                                class='btn btn-danger btn-delete btn-sm mb-2'
                                onclick="if(!confirm('Are you sure?')) return false"
                                href='{{ adminRoute("profile/delete-image/$form->id?field=photo") }}'
                            ><i class='fa fa-ban'></i> Delete</a>
                        @else
                            <input type="file" name="photo" class="form-control form-control-solid" accept="image/*">
                        @endif
                        <p class="text-muted">Recommended resolution is 200x200px</p>
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("photo")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2"
                        >Password</label>
                        <input
                            type="password" name="password"
                            class="form-control form-control-solid"
                        >
                        <p class="text-muted">Please leave empty if not change</p>
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("password")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2"
                        >Password Confirmation</label>
                        <input
                            type="password" name="password_confirmation"
                            class="form-control form-control-solid"
                        >
                        <p class="text-muted">Please leave empty if not change</p>
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("password")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer border-0">
                <a
                    href='{{ adminMainRoute("") }}'
                    class='btn btn-default'
                ><i class='fa fa-chevron-circle-left'></i> Back</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>

@endsection
@push('bottom')
    <script type="javascript">
        $("#privilege").select2()
            .on('select2:select', function (e) {

            })
    </script>
@endpush
