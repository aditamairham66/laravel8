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
            </div>

        </div>
    </div>

@endsection
@push('bottom')
@endpush

