@extends('admin.layout.table.index')
@section('table')

    <div class="table-responsive">
        <table id="table_dashboard" class="table table-hover table-rounded table-striped gs-4 gy-4 gx-4">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" id="checkall">
                </th>
                <th>Name</th>
                <th style="text-align:right">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(count($result) <= 0)
                <tr>
                    <td colspan="3" class="text-center">Data not found.</td>
                </tr>
            @endif
            @foreach($result as $rowRes)
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" name="checkbox[]" value="{{ $rowRes->id }}">
                    </td>
                    <td>{{ $rowRes->name }}</td>
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
