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
        <a class="nav-link btn btn-flex btn-active-primary active" href="{{ route('module-create.step3', ['id' => $id]) }}">
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
          <h3 class="card-title">Form Display</h3>
      </div>
      <form method="post" autocomplete="off" action="{{ route('module-create.step4') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $id }}">

          <div class="card-body">
              <table class='table-form table table-striped'>
                  <thead>
                  <tr>
                      <th>Label</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Validation</th>
                      <th width="180px">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($column as $row)
                      <tr>
                          <td>
                              <input
                                  type='text'
                                  name='label[]'
                                  class='form-control labels'
                                  placeholder="Input field label"
                                  onclick='showColumnSuggest(this)'
                                  onkeyup="showColumnSuggestLike(this)"
                                  value="{{ $row->label }}"
                                  readonly
                              />
                          </td>
                          <td>
                              <input
                                  type='text'
                                  name='name[]'
                                  class='form-control readonly name'
                                  placeholder="Input field name"
                                  onclick='showNameSuggest(this)'
                                  onkeyup="showNameSuggestLike(this)"
                                  value="{{ $row->name }}"
                              />
                          </td>
                          <td>
                              <input
                                  type='text'
                                  name='type[]'
                                  class='form-control type'
                                  placeholder="Input field type"
                                  onclick='showTypeSuggest(this)'
                                  onkeyup="showTypeSuggestLike(this)"
                              />
                          </td>
                          <td>
                              <input
                                  type='text'
                                  name='validation[]'
                                  class='form-control validation'
                                  placeholder='Enter Laravel Validation'
                                  onclick="showValidationSuggest(this)"
                                  onkeyup="showValidationSuggestLike(this)"
                                  value='required'
                              />
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
                          type='text'
                          name='label[]'
                          class='form-control labels'
                          placeholder="Input field label"
                          onclick='showColumnSuggest(this)'
                          onkeyup="showColumnSuggestLike(this)"
                      />
                  </td>
                  <td>
                      <input
                          type='text'
                          name='name[]'
                          class='form-control name'
                          placeholder="Input field name"
                          onclick='showNameSuggest(this)'
                          onkeyup="showNameSuggestLike(this)"
                      />
                  </td>
                  <td>
                      <input
                          type='text'
                          name='type[]'
                          class='form-control type'
                          placeholder="Input field type"
                          onclick='showTypeSuggest(this)'
                          onkeyup="showTypeSuggestLike(this)"
                      />
                  </td>
                  <td>
                      <input
                          type='text'
                          name='validation[]'
                          class='form-control validation'
                          placeholder='Enter Laravel Validation'
                          onclick="showValidationSuggest(this)"
                          onkeyup="showValidationSuggestLike(this)"
                          value='required'
                      />
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

        $(document).on('click', '.table-form .btn-delete', function () {
            $(this).parent().parent().remove();
        })

        $(document).on('click', '.table-form .btn-up', function () {
            var tr = $(this).parent().parent();
            var trPrev = tr.prev('tr');
            if (trPrev.length != 0) {

                tr.prev('tr').before(tr.clone());
                tr.remove();
            }
        })

        $(document).on('click', '.table-form .btn-down', function () {
            var tr = $(this).parent().parent();
            var trPrev = tr.next('tr');
            if (trPrev.length != 0) {

                tr.next('tr').after(tr.clone());
                tr.remove();
            }
        })
    </script>
@endpush
@push('head')
    <style>
        .table-form tbody tr td {
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

        .sub li {
            padding: 5px;
            background: #eae9e8;
            cursor: pointer;
            display: block;
            width: 180px;
        }

        .sub li:hover {
            background: #ECF0F5;
        }
    </style>
@endpush
