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
        <h3 class="card-title">Module Information</h3>
    </div>
    <form method="post" action="{{ route('module-create.step2') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="card-body">
            <div class="form-group mb-10">
                <label for="" class="form-label col-sm-2">Table</label>
                <select name="table" id="table" required class="form-select form-select-solid" data-control="select2" value="">
                    <option value="">**Please select a Table</option>
                    @foreach ($table as $rowTable)
                        <option 
                            value="{{ $rowTable }}"
                        >{{ $rowTable }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-10">
                <label for="" class="form-label col-sm-2">Module Name</label>
                <input type="text" class="form-control form-control-solid" required name="name" value="">
            </div>
            <div class="form-group mb-10">
                <label for="" class="form-label col-sm-2">Icon</label>
                <select name="icon" id="icon" required class="form-select form-select-solid">
                    @include('admin.module.component.icon.option')
                </select>
            </div>
            <div class="form-group mb-10">
                <label for="" class="form-label col-sm-2">Module Slug</label>
                <input type="text" class="form-control form-control-solid" required name="path" value="">
                <div class="text-muted">Please alpha numeric only, without space instead _ and or special character</div>
            </div>
        </div>
        <div class="card-footer">
            <div class='d-flex justify-content-end'>
                <a class='btn btn-default' href=''> Back</a>
                <input type="submit" class="btn btn-primary" value="Step 2 &raquo;">
            </div>
        </div>
    </form>
  </div>
  
@endsection
@push('bottom')
    <script>
        // Format options
        const format = (item) => {
            if (!item.id) {
                return item.text;
            }

            const span = $("<span>", {
                text: `${item.text}`
            });
            span.prepend(`
                <i class="${item.element.getAttribute('data-icon')} text-dark fs-1"></i>&nbsp; 
            `);
            return span;
        }

        $('#icon').select2({
            templateResult: function (item) {
                return format(item);
            }
        });

        $('select[name=table]').change(function () {
            const v = $(this).val().replace(".", "_");
            $('input[name=path]').val(v);
        })
    </script>
@endpush
