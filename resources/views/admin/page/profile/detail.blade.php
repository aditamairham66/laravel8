@extends('admin.layout.index')
@section('page_title', $page_title)
@section('content')

    <a href='{{ $link }}' class='btn btn-default'>
        <i class='fa fa-chevron-circle-left'></i> Back
    </a>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{ $page_title }}</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group mb-10">
                        <label class="form-check-label">Name</label>
                        <p class="text-dark fw-bolder">{{ $form->name }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-10">
                        <label class="form-check-label">Email</label>
                        <p class="text-dark fw-bolder">{{ $form->email }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-10">
                        <label class="form-check-label">Privileges</label>
                        <p class="text-dark fw-bolder">{{ optional($form->privileges)->name }}</p>
                    </div>
                </div>
            </div>

            <div class="form-group mb-10">
                <label class="form-check-label">Photo</label>
                <a
                    class="d-block overlay w-175px mb-5"
                    data-fslightbox="lightbox-hot-sales"
                    href="{{ asset($form->photo) }}"
                >
                    <div
                        class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                        style="background-image:url('{{ asset($form->photo) }}')"
                    ></div>
                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                        <i class="bi bi-eye-fill fs-2x text-white"></i>
                    </div>
                </a>
            </div>

        </div>
    </div>

@endsection
@push('bottom')
@endpush

