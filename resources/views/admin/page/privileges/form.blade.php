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
                        >Name</label>
                        <input
                            type="text" name="name" placeholder="You can only enter the letter only"
                            autofocus
                            class="form-control form-control-solid"
                            value="{{ old('name', (!empty($form->name)?$form->name:null)) }}"
                        >
                        <div class="fv-plugins-message-container invalid-feedback">
                            @error("name")
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
