@props([
    'isRequired',
    'label',
    'column',
    'columnId',
    'file',
])

<div class="form-group mb-10">
    <label
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
    >{{ $label }}</label>
    @if(!empty($file))
        <a
            class="d-block overlay mb-5 w-175px"
            data-fslightbox="lightbox-hot-sales"
            href="{{ asset($file) }}"
        >
            <div
                class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                style="background-image:url('{{ asset($file) }}');"
            ></div>
            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                <i class="bi bi-eye-fill fs-2x text-white"></i>
            </div>
        </a>
        @if($columnId && $column)
            <a
                class='btn btn-danger btn-delete btn-sm mb-2'
                onclick="if(!confirm('Are you sure?')) return false"
                href='{{ adminMainRoute("delete-image/$columnId?field=$column") }}'
            ><i class='fa fa-ban'></i> Delete</a>
        @endif
    @else
        <input type="file" name="{{ $column }}" class="form-control form-control-solid" accept="image/*">
    @endif
    <div class="fv-plugins-message-container invalid-feedback">
        @error("$column")
        <i class='fa fa-info-circle'></i> {{ $message }}
        @enderror
    </div>
</div>
