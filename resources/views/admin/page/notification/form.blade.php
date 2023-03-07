@extends('admin.layout.index')
@section('page_title', $page_title)
@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{ $page_title }}</h3>
        </div>
        <form action="{{ $link }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="card-body">
                <div class="col-md-10">

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2 required"
                            title="this field required"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-dismiss="click"
                            data-bs-placement="left"
                        >Content</label>
                        <input
                            type="text" name="content" placeholder="You can only enter the letter only"
                            autofocus
                            required
                            class="form-control form-control-solid"
                            value="{{ old('content', (!empty($form->content)?$form->content:null)) }}"
                        >
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("content")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-10">
                        <label
                            class="form-label col-sm-2 required"
                            title="this field required"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-dismiss="click"
                            data-bs-placement="left"
                        >Is Read</label>
                        <input
                            type="text" name="is_read" placeholder="You can only enter the letter only"
                            autofocus
                            class="form-control form-control-solid"
                            value="{{ old('is_read', (!empty($form->is_read)?$form->is_read:0)) }}"
                        >
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("is_read")
                            <i class='fa fa-info-circle'></i> {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer border-0">
                <a
                    href='{{ adminMainRoute("") }}'
                    class='btn btn-default'
                ><i class='fa fa-chevron-circle-left'></i> Back</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>

@endsection
@push('bottom')
@endpush
