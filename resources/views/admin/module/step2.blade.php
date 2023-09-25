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
                    <th width='90px'>Image</th>
                    <th width='80px'>Download</th>
                    <th width="180px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($column as $row)
                <tr>
                    <td>
                        <input 
                            type='text' name='column[]'
                            class='column form-control notfocus' 
                            onclick='showColumnSuggest(this)' 
                            onKeyUp='showColumnSuggestLike(this)' 
                            placeholder='Column Name' 
                            value='{{ $row->label }}'
                        />
                    </td>
                    <td>
                        <input 
                            type='text' name='name[]' 
                            class='name form-control notfocus' 
                            onclick='showNameSuggest(this)' 
                            onKeyUp='showNameSuggestLike(this)'
                            placeholder='Field Name' 
                            value='{{ $row->name }}'
                        />
                    </td>
                    <td>
                        <select class='form-select is_image' name='is_image[]'>
                            <option value='0'>N</option>
                            <option value='1'>Y</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-select is_download' name='is_download[]'>
                            <option value='0'>N</option>
                            <option value='1'>Y</option>
                        </select>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-info btn-plus"><i class='fa fa-plus'></i></a>
                        <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-danger btn-delete"><i class='fa fa-trash'></i></a>
                        <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-success btn-up"><i class='fa fa-arrow-up'></i></a>
                        <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-success btn-down"><i class='fa fa-arrow-down'></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <input type="submit" class="btn btn-primary" value="Next &raquo;">
            </div>
        </div>
    </form>
  </div>

@endsection
@push('bottom')
  <script>
    $(document).on('click', '.btn-plus', function () {
        var tr_parent = $(this).parent().parent('tr');
        clone = `
        <tr>
            <td>
                <input 
                    type='text' name='column[]'
                    class='column form-control notfocus' 
                    onclick='showColumnSuggest(this)' 
                    onKeyUp='showColumnSuggestLike(this)' 
                    placeholder='Column Name' 
                    value=''
                />
            </td>
            <td>
                <input 
                    type='text' name='name[]' 
                    class='name form-control notfocus' 
                    onclick='showNameSuggest(this)' 
                    onKeyUp='showNameSuggestLike(this)'
                    placeholder='Field Name' 
                    value=''
                />
            </td>
            <td>
                <select class='form-select is_image' name='is_image[]'>
                    <option value='0'>N</option>
                    <option value='1'>Y</option>
                </select>
            </td>
            <td>
                <select class='form-select is_download' name='is_download[]'>
                    <option value='0'>N</option>
                    <option value='1'>Y</option>
                </select>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-info btn-plus"><i class='fa fa-plus'></i></a>
                <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-danger btn-delete"><i class='fa fa-trash'></i></a>
                <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-success btn-up"><i class='fa fa-arrow-up'></i></a>
                <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-success btn-down"><i class='fa fa-arrow-down'></i></a>
            </td>
        </tr>
        `;
        tr_parent.after(clone);
    })

    // init row
    $('.btn-plus').last().click();

    $(document).mouseup(function (e) {
        var container = $(".sub");
        if (!container.is(e.target)
            && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    $(document).on('click', '.sub li', function () {
        var v = $(this).text();
        $(this).parent('ul').prev('input[type=text]').val(v);
        $(this).parent('ul').remove();
    })
    
    $(document).on('click', '.table-display .btn-delete', function () {
        $(this).parent().parent().remove();
    })

    $(document).on('click', '.table-display .btn-up', function () {
        var tr = $(this).parent().parent();
        var trPrev = tr.prev('tr');
        if (trPrev.length != 0) {

            tr.prev('tr').before(tr.clone());
            tr.remove();
        }
    })

    $(document).on('click', '.table-display .btn-down', function () {
        var tr = $(this).parent().parent();
        var trPrev = tr.next('tr');
        if (trPrev.length != 0) {

            tr.next('tr').after(tr.clone());
            tr.remove();
        }
    })

    $(document).on('change', '.is_image', function () {
        var tr = $(this).parent().parent();
        if ($(this).val() == 1) {
            tr.find('.is_download').val(0);
        }
    })

    $(document).on('change', '.is_download', function () {
        var tr = $(this).parent().parent();
        if ($(this).val() == 1) {
            tr.find('.is_image').val(0);
        }
    })
  </script>
@endpush
@push('head')
    <style>
        .table-display tbody tr td {
            position: relative;
        }

        .sub {
            position: absolute;
            top: inherit;
            left: inherit;
            padding: 0 0 0 0;
            list-style-type: none;
            height: 180px;
            overflow: auto;
            z-index: 1;
        }
        .sub > li {
            padding: 5px;
            background: #eae9e8;
            cursor: pointer;
            display: block;
            width: 180px;
        }
        .sub > li:hover {
            background: #ECF0F5;
        }
    </style>
@endpush
