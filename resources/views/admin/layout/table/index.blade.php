@extends('admin.layout.index')
@section('page_title', $page_title)
@section('content')

    <div class="card shadow-sm">

        <div class="card-header">
            <h3 class="card-title">
                @if($button->isBulkButton)
                <div class="dropdown selected-action">
                    <button
                        class="btn btn-sm btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton1"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Bulk Actions
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton1"
                    >
                        <li>
                            <a
                                href="javascript:void(0)"
                                data-name="delete"
                                class="dropdown-item"
                                title="Delete Selected"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover"
                                data-bs-dismiss="click"
                                data-bs-placement="right"
                                data-bs-original-title="Delete Selected"
                            >
                                <i class="fa fa-trash"></i> Delete Selected
                            </a>
                        </li>
                        @foreach($buttonBulk as $rowButtonBulk)
                            <li>
                                <a
                                    href="javascript:void(0)"
                                    data-name="{{ $rowButtonBulk['type'] }}"
                                    class="dropdown-item"
                                    title="{{ $rowButtonBulk['name'] }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="hover"
                                    data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    data-bs-original-title="{{ $rowButtonBulk['name'] }}"
                                >
                                    <i class="fa fa-trash"></i> {{ $rowButtonBulk['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </h3>
            <div class="card-toolbar">
                <form method='get' action='{{Request::url()}}'>

                    <div class="form-group me-5">
                        <div class="input-group input-group-solid input-group-sm">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                    </svg>
                                </span>
                            </span>
                            <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" placeholder="" />
                            @if(Request::get('q'))
                                <?php
                                $parameters = Request::all();
                                unset($parameters['q']);
                                $build_query = urldecode(http_build_query($parameters));
                                $build_query = ($build_query) ? "?".$build_query : "";
                                $build_query = (Request::all()) ? $build_query : "";
                                ?>
                                <button type='button' onclick='location.href="{{ adminMainRoute().$build_query}}"'
                                        title="" class='btn btn-sm btn-warning'><i class='fa fa-ban'></i></button>
                            @endif
                            <button type='submit' class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <form id='form-table' method='post' action='{{ adminMainRoute("action-selected") }}'>
                {{ csrf_field() }}
                <input type='hidden' name='button_name' value=''/>

                @yield('table')

            </form>
        </div>
        <div class="card-footer border-0">
            <form method='get' id="form-limit-paging" action='{{ Request::url() }}'>

                <div class="row">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="dataTables_length">
                            <label>
                                <select name="limit" id="kt_customers_table_length" class="form-select form-select-sm form-select-solid" onchange="$('#form-limit-paging').submit()">
                                    <option {{($limit==5)?'selected':''}}  value="5">5</option>
                                    <option {{($limit==10)?'selected':''}}  value="10">10</option>
                                    <option {{($limit==25)?'selected':''}}  value="25">25</option>
                                    <option {{($limit==50)?'selected':''}}  value="50">50</option>
                                    <option {{($limit==100)?'selected':''}}  value="100">100</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-end justify-content-md-end">
                        <?php
                        $from = $result->count() ? ($result->perPage() * $result->currentPage() - $result->perPage() + 1) : 0;
                                $to = $result->perPage() * $result->currentPage() - $result->perPage() + $result->count();
                                $total = $result->total();
                                ?>
                        <span class="text-dark pull-right me-5">
                            Total rows: {{ $from }} to {{ $to }} of {{ $total }}
                        </span>
                        {!! urldecode(str_replace("/?", "?", $result->appends(Request::all())->links('admin.layout.pagination')->render())) !!}
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection
@push('bottom')
    <script type="text/javascript">
        $("#table_dashboard .checkbox").click(function () {
            var is_any_checked = $("#table_dashboard .checkbox:checked").length;
            if (is_any_checked) {
                $(".btn-delete-selected").removeClass("disabled");
            } else {
                $(".btn-delete-selected").addClass("disabled");
            }
        })

        $("#table_dashboard #checkall").click(function () {
            var is_checked = $(this).is(":checked");
            $("#table_dashboard .checkbox").prop("checked", !is_checked).trigger("click");
        })

        $('.selected-action ul li a').click(function () {
            const name = $(this).data('name');
            $('#form-table input[name="button_name"]').val(name);
            const title = $(this).attr('title');

            Swal.fire({
                title: "Confirmation",
                text: `Are you sure want to ${title}`,
                showCancelButton: true,
                confirmButtonColor: "#008D4C",
                confirmButtonText: "Yes!",
            }).then((function(e) {
                e.isConfirmed && ($('#form-table').submit())
            }))

        })

        $('table tbody tr .button_action a').click(function (e) {
            e.stopPropagation();
        })
    </script>
@endpush

