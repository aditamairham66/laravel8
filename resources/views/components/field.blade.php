<div class="form-group mb-10">
    <label
        @if($isRequired)
        class="form-label col-sm-2"
        @else
        class="form-label col-sm-2 required"
        title="this field required"
        data-bs-toggle="tooltip"
        data-bs-trigger="hover"
        data-bs-dismiss="click"
        data-bs-placement="left"
        @endif
    >{{ $columnName }}</label>
    <input
        type="{{ $type }}" name="{{ $column }}" id="{{ $column }}"
        class="form-control form-control-solid"
        @if(!empty($column))
        value="{{ old("$column", (!empty($form->$column)?$form->$column:null)) }}"
        @endif
    >
    <div class="fv-plugins-message-container invalid-feedback">
        @error("$column")
        <i class='fa fa-info-circle'></i> {{ $message }}
        @enderror
    </div>
</div>
