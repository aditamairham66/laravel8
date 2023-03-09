<div
    class="button_action"
    style="text-align:right"
>
    @foreach($buttonAction as $rowButtonAction)
        <a
            class="btn @if(empty($rowButtonAction['label'])) btn-icon @endif btn-sm btn-{{ $rowButtonAction['type'] }}"
            title="Detail Data"
            href="{{ $rowButtonAction['link'] }}"
        >
            @if($rowButtonAction['icon'])
            <i class="{{ $rowButtonAction['icon'] }}"></i>
            @endif
            {{ $rowButtonAction['label'] }}
        </a>
    @endforeach

    @if($isDetail)
    <a
        class="btn btn-icon btn-sm btn-primary btn-detail"
        title="Detail Data"
        href="{{ adminMainRoute("detail/$id") }}"
    ><i class="fa fa-eye"></i></a>
    @endif
    @if($isEdit)
    <a
        class="btn btn-icon btn-sm btn-success btn-edit"
        title="Edit Data"
        href="{{ adminMainRoute("edit/$id") }}"
    ><i class="fa fa-pen"></i></a>
    @endif
    @if($isDelete)
    <a
        class="btn btn-icon btn-sm btn-warning btn-delete"
        title="Delete"
        href="javascript:;"
        onclick="Swal.fire({
            title: 'Are you sure ?',
            text: 'You will not be able to recover this record data!',
            showCancelButton: true,
            confirmButtonColor: '#ff0000',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
        }).then(function(e) {
            (e.isConfirmed) && (location.href='{{ adminMainRoute("delete/$id") }}')
        });
        "
    ><i class="fa fa-trash"></i></a>
    @endif
</div>
