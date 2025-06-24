<x-client-layout>
    <x-slot name="page_title">{{ $page_title ?? 'My Account |' }}</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"> {{ config('app.name', 'Laravel') }} </a></li>
                            <li class="breadcrumb-item"><a href="{{ url('client-panel/dashboard') }}"> Dashboard </a></li>
                            <li class="breadcrumb-item active"> My Account </li>
                        </ol>
                    </div>

                    <h4 class="page-title"> My Account </h4>
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
                <div class="card text-center">
                    <div class="card-body">
                        @if ($client->profile_image)
                            <img src="{{ url('images/clients', $client->profile_image) }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile_image" />
                        @else
                            <img src="{{ asset('hyper/images/avator.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile_image" />
                        @endif

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="text-start mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Name :</strong> <span class="ms-2"> {{ $client->name ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ms-2"> {{ $client->date_of_birth ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Gender :</strong> <span class="ms-2"> {{ $client->gender ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2"> {{ $client->email ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ms-2"> {{ $client->address ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>BIO :</strong> <span class="ms-2"> {{ $client->bio ?? "" }} </span></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-start mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Facebook :</strong> <span class="ms-2"> {{ $client->facebook_profile_url ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>YouTube :</strong> <span class="ms-2"> {{ $client->you_tube_profile_url ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Instagram :</strong> <span class="ms-2"> {{ $client->instagram_profile_url ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Twitter :</strong> <span class="ms-2"> {{ $client->twitter_profile_url ?? "" }} </span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Linkedin :</strong> <span class="ms-2"> {{ $client->linkedin_profile_url ?? "" }} </span></p>

                                    <p class="text-muted mb-2 font-13"><strong>Status :</strong>
                                        <span class="ms-2">
                                            @if ($client->status == "Active")
                                                <span class="badge badge-success-lighten"> Active </span>
                                            @elseif ($client->status == "Pending")
                                                <span class="badge badge-warning-lighten"> Pending </span>
                                            @elseif ($client->status == "Suspended")
                                                <span class="badge badge-danger-lighten"> Suspended </span>
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <a href="{{ url('client-panel/my-account-edit') }}" class="btn btn-success button-last"> Edit </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
