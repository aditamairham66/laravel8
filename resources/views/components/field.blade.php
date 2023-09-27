@props([
    'type',
    'isRequired',
    'label',
    'column',
    'value'
])

<div class="form-group mb-10">
    <labe
        @class([
            "form-label col-sm-2",
            "required" => $isRequired
        ])
        @if($isRequired)
            title="this field required"
            data-bs-toggle="tooltip"
            data-bs-trigger="hover"
            data-bs-dismiss="click"
            data-bs-placement="left"
        @endif
    >{{ $label }}</labe>
    <input
        type="{{ $type }}" name="{{ $column }}" id="{{ $column }}"
        class="form-control form-control-solid"
        @if($value)
            value="{{ old("$column", (!empty($value)?$value:null)) }}"
        @endif
    >
    <div class="fv-plugins-message-container invalid-feedback">
        @error("$column")
        <i class='fa fa-info-circle'></i> {{ $message }}
        @enderror
    </div>
</div>
