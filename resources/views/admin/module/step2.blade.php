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
        <a class="nav-link btn btn-flex btn-active-primary active" href="{{ route('module-create.step2', ['id' => $id]) }}">
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
        <a class="nav-link btn btn-flex btn-active-primary" href="{{ route('module-create.step4', ['id' => $id]) }}">
            <span class="svg-icon svg-icon-2"><svg>...</svg></span>
            <span class="d-flex flex-column align-items-start">
                <span class="fs-4 fw-bolder">Step 1</span>
                <span class="fs-7">Configuration</span>
            </span>
        </a>
    </li>
  </ul>

  <div class="card">
    <div class="card-header">
        <h3 class="card-title">Table Display</h3>
    </div>
    <form method="post" action="{{ route('module-create.step3') }}">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{ $id }}">

        <div class="card-body">
            <table class="table-display table table-striped">
                <thead>
                <tr>
                    <th>Column</th>
                    <th>Name</th>
                    <th colspan='2'>Join (Optional)</th>
                    <th>CallbackPHP</th>
                    <th width="90px">Width (px)</th>
                    <th width='80px'>Image</th>
                    <th width='80px'>Download</th>
                    <th width="180px">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div align="d-flex justify-content-end">
                <a 
                    href="javascript:void(0);" 
                    onclick="location.href='{{ route('module-create.step1', ['id' => $id]) }}'" 
                    class="btn btn-default"
                >&laquo; Back</a>
                <input type="submit" class="btn btn-primary" value="Step 3 &raquo;">
            </div>
        </div>
    </form>
  </div>

@endsection
@push('bottom')
@endpush
@push('head')
    <style>
        .table-display tbody tr td {
            position: relative;
        }
    </style>
@endpush
