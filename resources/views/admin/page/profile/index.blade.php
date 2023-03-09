@extends('admin.layout.table.index')
@section('table')

    <div class="table-responsive">
        <table id="table_dashboard" class="table table-hover table-rounded table-striped gs-4 gy-4 gx-4">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" id="checkall">
                </th>
                <th>Privileges</th>
                <th>Name</th>
                <th>Image</th>
                <th>Email</th>
                <th style="text-align:right">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(count($result) <= 0)
                <tr>
                    <td colspan="6" class="text-center">Data not found.</td>
                </tr>
            @endif
            @foreach($result as $rowRes)
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" name="checkbox[]" value="{{ $rowRes->id }}">
                    </td>
                    <td>{{ optional($rowRes->privileges)->name }}</td>
                    <td>{{ $rowRes->name }}</td>
                    <td>
                        <a
                            data-fslightbox="lightbox-basic"
                            rel="group_{{ $rowRes->name }}"
                            title="Self Photo: {{ $rowRes->name }}"
                            href="{{ asset($rowRes->photo) }}"
                        >
                            <img width="40px" height="40px" src="{{ asset($rowRes->photo) }}">
                        </a>
                    </td>
                    <td>{{ $rowRes->email }}</td>
                    <td>
                        @include('admin.layout.table.action', [
                            "buttonAction" => $buttonAction,
                            "isEdit" => $button->isEdit,
                            "isDelete" => $button->isDelete,
                            "isDetail" => $button->isDetail,
                            "id" => $rowRes->id
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
