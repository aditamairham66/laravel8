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

            <div class="form-group mb-10">
                <label class="form-check-label">Content</label>
                <p class="text-dark fw-bolder">{!! $form->content !!}</p>
            </div>

            <div class="form-group mb-10">
                <label class="form-check-label">Is Read</label>
                <p class="text-dark fw-bolder">{{ ($form->is_read == 1 ? "Yes" : "No") }}</p>
            </div>

        </div>
    </div>

@endsection
@push('bottom')
@endpush

