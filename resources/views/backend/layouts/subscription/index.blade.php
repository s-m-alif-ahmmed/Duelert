@extends('backend.app')

@section('title', 'Package List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Package List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Package List</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom"
                    style="margin-bottom: 0; display: flex; justify-content: space-between;">
                    <h3 class="card-title">Package Table</h3>
                    {{-- <a href="{{ route('#') }}" class="btn btn-primary">Add New</a> --}}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">SL</th>
                                    <th class="wd-15p border-bottom-0">Name</th>
                                    <th class="wd-15p border-bottom-0">Plan</th>
                                    <th class="wd-15p border-bottom-0">Price</th>
                                    <th class="wd-15p border-bottom-0">Status</th>
                                    <th class="wd-15p border-bottom-0">End Date</th>
                                    <th class="wd-15p border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- dynamic data --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            if (!$.fn.DataTable.isDataTable('#datatable')) {
                let dTable = $('#datatable').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>`
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('package.index') }}",
                        type: "GET",
                    },

                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'paystack_plan',
                            name: 'paystack_plan',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'price',
                            name: 'price',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'paystack_status',
                            name: 'paystack_status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'ends_at',
                            name: 'ends_at',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                dTable.buttons().container().appendTo('#file_exports');
                new DataTable('#example', {
                    responsive: true
                });
            }
        });
              
    </script>

    
    {{-- Status Change start --}}
    <script>
        $(document).on('change', '.status-dropdown', function () {
            let id = $(this).data('id');
            let status = $(this).val();
            let url = "{{ route('package.status', ':id') }}".replace(':id', id);
            let dropdown = $(this); // Dropdown Element Reference
    
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change the subscription status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX Request to update status
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: status
                        },
                        success: function (resp) {
                            if (resp.success) {
                                Swal.fire(
                                    'Updated!',
                                    'Subscription status has been updated.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                            dropdown.val(dropdown.data('previous')); 
                        }
                    });
                } else {
                    dropdown.val(dropdown.data('previous')); 
                }
            });
        });
    
        // Save previous value before changing
        $(document).on('focus', '.status-dropdown', function () {
            $(this).data('previous', $(this).val());
        });
    </script>
    
    {{-- Status Change end --}}
    
@endpush
