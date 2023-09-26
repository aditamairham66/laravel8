@props([
    'type',
    'isRequired',
    'label',
    'column',
    'data',
])

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
    >{{ $label }}</label>
    <input
        type="{{ $type }}" name="{{ $column }}" id="{{ $column }}"
        class="form-control form-control-solid"
        value="{{ old("$column", (!empty($data)?$data:null)) }}"
    >
    <div class="fv-plugins-message-container invalid-feedback">
        @error("$column")
        <i class='fa fa-info-circle'></i> {{ $message }}
        @enderror
    </div>
</div>
