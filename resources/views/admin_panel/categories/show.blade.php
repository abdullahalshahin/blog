<x-app-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Category Show |' }}</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/categories') }}"> Categories </a></li>
                            <li class="breadcrumb-item active">Show</li>
                        </ol>
                    </div>

                    <h4 class="page-title">Category Show</h4>
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
                        <div class="row mb-2">
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Name :</strong> <span class="ms-2"> {{ $category->name ?? "" }} </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Description :</strong> <span class="ms-2"> {{ $category->description ?? "" }} </span></p>
                            </div>
                        </div>

                        <div class="float-end">
                            <a href="{{ url('admin-panel/categories') }}" class="btn btn-primary button-last"> Go Back </a>
                            <a href="{{ url('admin-panel/categories/'. $category->id .'/edit') }}" class="btn btn-success button-last"> Edit </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
