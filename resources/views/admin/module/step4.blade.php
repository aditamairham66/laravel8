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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Configuration</h3>
        </div>
        <form method='post' action='{{ route('module-create.step4') }}'>
            {{csrf_field()}}
            <input type="hidden" name="id" value='{{ $id }}'>

            <div class="card-body">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Bulk Action Button</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_bulk_action1" type='radio' name='button_bulk_action' checked value='true'/>
                                            <label class="form-check-label" for="button_bulk_action1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_bulk_action2" type='radio' name='button_bulk_action' value='false'/>
                                            <label class="form-check-label" for="button_bulk_action2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Button Show Data</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_show1" type='radio' name='button_show' checked value='true'/>
                                            <label class="form-check-label" for="button_show1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_show2" type='radio' name='button_show' value='false'/>
                                            <label class="form-check-label" for="button_show2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Button Add</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_add1" type='radio' name='button_add' checked value='true'/>
                                            <label class="form-check-label" for="button_add1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_add2" type='radio' name='button_add' value='false'/>
                                            <label class="form-check-label" for="button_add2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Button Edit</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_edit1" type='radio' name='button_edit' checked value='true'/>
                                            <label class="form-check-label" for="button_edit1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_edit2" type='radio' name='button_edit' value='false'/>
                                            <label class="form-check-label" for="button_edit2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Button Delete</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_delete1" type='radio' name='button_delete' checked value='true'/>
                                            <label class="form-check-label" for="button_delete1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_delete2" type='radio' name='button_delete' value='false'/>
                                            <label class="form-check-label" for="button_delete2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-10">
                                    <label class="form-label">Show Button Detail</label>
                                    <div class="row mt-4 pe-2 ps-2">
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_detail1" type='radio' name='button_detail' checked value='true'/>
                                            <label class="form-check-label" for="button_detail1">
                                                TRUE
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid col-md-3">
                                            <input class="form-check-input" id="button_detail2" type='radio' name='button_detail' value='false'/>
                                            <label class="form-check-label" for="button_detail2">
                                                FALSE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <input type="submit" name="submit" class='btn btn-primary' value='Save Module'>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('bottom')
@endpush
