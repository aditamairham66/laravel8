@extends('admin.layout.index')
@section('page_title', 'Module Generator : Step 1')
@section('content')

    <ul class="nav nav-tabs nav-pills border-0 flex-row me-5 mb-3 mb-md-0 fs-6">
        <li class="nav-item me-0 mb-md-2">
            <a class="nav-link btn btn-flex btn-active-primary" href="{{ route('module-create.step1', ['id' => $id]) }}">
                <span class="svg-icon svg-icon-2"><svg>...</svg></span>
                <span class="d-flex flex-column align-items-start">
                <span class="fs-4 fw-bolder">Step 1</span>
                <span class="fs-7">Module Information</span>
            </span>
            </a>
        </li>
        <li class="nav-item me-0 mb-md-2">
            <a class="nav-link btn btn-flex btn-active-primary" href="{{ route('module-create.step2', ['id' => $id]) }}">
                <span class="svg-icon svg-icon-2"><svg>...</svg></span>
                <span class="d-flex flex-column align-items-start">
                <span class="fs-4 fw-bolder">Step 2</span>
                <span class="fs-7">Table Display</span>
            </span>
            </a>
        </li>
        <li class="nav-item me-0 mb-md-2">
            <a class="nav-link btn btn-flex btn-active-primary" href="{{ route('module-create.step3', ['id' => $id]) }}">
                <span class="svg-icon svg-icon-2"><svg>...</svg></span>
                <span class="d-flex flex-column align-items-start">
                <span class="fs-4 fw-bolder">Step 3</span>
                <span class="fs-7">Form Display</span>
            </span>
            </a>
        </li>
        <li class="nav-item me-0 mb-md-2">
            <a class="nav-link btn btn-flex btn-active-primary active" href="{{ route('module-create.step4', ['id' => $id]) }}">
                <span class="svg-icon svg-icon-2"><svg>...</svg></span>
                <span class="d-flex flex-column align-items-start">
                <span class="fs-4 fw-bolder">Step 4</span>
                <span class="fs-7">Configuration</span>
            </span>
            </a>
        </li>
    </ul>

@endsection
@push('bottom')
@endpush
