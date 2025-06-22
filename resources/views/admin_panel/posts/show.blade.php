<x-app-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Banner Show |' }}</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/banners') }}"> Banners </a></li>
                            <li class="breadcrumb-item active">Show</li>
                        </ol>
                    </div>

                    <h4 class="page-title">Banner Show</h4>
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
                        @if ($banner->background_image)
                            <img src="{{ url('images/banners', $banner->background_image) }}" class="rounded avatar-xl img-thumbnail" alt="background_image" />
                        @else
                            <img src="{{ asset('assets/images/no_image.png') }}" class="rounded avatar-xl img-thumbnail" alt="background_image" />
                        @endif

                        <div class="row mb-2">
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Product Name :</strong> <span class="ms-2"> {{ $banner->product_name ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Title :</strong> <span class="ms-2"> {{ $banner->title ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Short Description :</strong> <span class="ms-2"> {{ $banner->short_description ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Price :</strong> <span class="ms-2"> {{ $banner->price ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>URL :</strong> <span class="ms-2"> {{ $banner->url ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Priority :</strong> <span class="ms-2"> {{ $banner->priority ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Status :</strong>
                                    <span class="ms-2"> 
                                        @if ($banner->status == "Active")
                                            <span class="badge badge-success-lighten"> Active </span>
                                        @elseif ($banner->status == "Inactive")
                                            <span class="badge badge-danger-lighten"> Inactive </span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="float-end">
                            <a href="{{ url('admin-panel/banners') }}" class="btn btn-primary button-last"> Go Back </a>
                            <a href="{{ url('admin-panel/banners/'. $banner->id .'/edit') }}" class="btn btn-success button-last"> Edit </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
