<x-app-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Clients |' }}</x-slot>

    <x-slot name="style">
        <link href="{{ asset('hyper/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('hyper/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                    
                    <h4 class="page-title">Client List</h4>
                </div>
            </div>
        </div>
        
        @if ($message = Session::get('success'))
            <div class="alert alert-success" id="notification_alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ url('admin-panel/clients/create') }}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Client</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Client</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th style="width: 75px;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($clients as $key => $client)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td class="table-user">
                                                @if ($client->profile_image)
                                                    <img src="{{ url('images/clients', $client->profile_image) }}" alt="table-user" class="me-2 rounded-circle">
                                                @else
                                                    <img src="{{ asset('hyper/images/avator.png') }}" alt="table-user" class="me-2 rounded-circle">
                                                @endif

                                                <a href="{{ url('admin-panel/clients/'. $client->id . '') }}" class="text-body fw-semibold"> {{ $client->name ?? "" }} </a>
                                            </td>
                                            <td> {{ $client->gender ?? "" }} </td>
                                            <td> {{ $client->email ?? "" }} </td>
                                            <td>
                                                @if ($client->status == "Active")
                                                    <span class="badge badge-success-lighten"> Active </span>
                                                @elseif ($client->status == "Pending")
                                                    <span class="badge badge-warning-lighten"> Pending </span>
                                                @elseif ($client->status == "Suspended")
                                                    <span class="badge badge-danger-lighten"> Suspended </span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ url('admin-panel/clients', $client->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="{{ url('admin-panel/clients/'. $client->id . '') }}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                    <a href="{{ url('admin-panel/clients/'. $client->id . '/edit') }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn action-icon show_confirm" data-toggle="tooltip" title='Delete'><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('hyper/js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('hyper/js/vendor/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('hyper/js/vendor/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('hyper/js/vendor/responsive.bootstrap5.min.js') }}"></script>

        <script src="{{ asset('hyper/js/pages/demo.datatable-init.js') }}"></script>
        <script src="{{ asset('hyper/js/sweetalert2@11') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#DataTable').DataTable();

                $('#notification_alert').delay(3000).fadeOut('slow');

                $('.show_confirm').click(function(event) {
                    var form =  $(this).closest("form");
                    var name = $(this).data("name");

                    event.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this item ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
