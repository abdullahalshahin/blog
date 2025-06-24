<x-client-layout>
    <x-slot name="page_title">{{ $page_title ?? 'My Account Edit |' }}</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"> {{ config('app.name', 'Laravel') }} </a></li>
                            <li class="breadcrumb-item"><a href="{{ url('client-panel/dashboard') }}"> Dashboard </a></li>
                            <li class="breadcrumb-item active"> My Account Edit </li>
                        </ol>
                    </div>

                    <h4 class="page-title"> My Account Edit </h4>
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

                        <form action="{{ url('client-panel/my-account-update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="text-start mt-3">
                                        <div class="row g-2">
                                            <div class="mb-2 col-md-6">
                                                <label for="name"> Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $client->name ?? "") }}" placeholder="" required>
                                            </div>
                                    
                                            <div class="mb-2 col-md-3">
                                                <label for="gender"> Gender <span class="text-danger">*</span> </label>
                                                <select id="gender" name="gender" class="form-select" required>
                                                    <option value=""> Choose Gender </option>
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender }}" {{ (old('gender') ?? ($client->gender ?? '')) == $gender ? 'selected' : '' }}>
                                                            {{ $gender }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    
                                            <div class="mb-2 col-md-3">
                                                <label for="date_of_birth"> Date Of Birth </label>
                                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $client->date_of_birth ?? "") }}" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    
                                        <div class="row g-2">
                                            <div class="mb-2 col-md-12">
                                                <label for="email"> Email </label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email ?? "") }}" placeholder="" readonly>
                                            </div>
                                        </div>
                                    
                                        <div class="row g-2">
                                            <div class="mb-2 col-md-12">
                                                <label for="address"> Address </label>
                                                <textarea class="form-control" id="address" name="address" rows="5">{{ old('address', $client->address ?? "") }}</textarea>
                                            </div>
                                        </div>
                                    
                                        <div class="row g-2">
                                            <div class="mb-2 col-md-12">
                                                <label for="bio"> BIO </label>
                                                <textarea class="form-control" id="bio" name="bio" rows="5">{{ old('bio', $client->bio ?? "") }}</textarea>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="mb-2 col-md-6">
                                                <label for="facebook_profile_url"> Facebook Profile URL </label>
                                                <input type="text" class="form-control" id="facebook_profile_url" name="facebook_profile_url" value="{{ old('facebook_profile_url', $client->facebook_profile_url ?? "") }}" placeholder="">
                                            </div>
                                            
                                            <div class="mb-2 col-md-6">
                                                <label for="you_tube_profile_url"> YouTube Profile URL </label>
                                                <input type="text" class="form-control" id="you_tube_profile_url" name="you_tube_profile_url" value="{{ old('you_tube_profile_url', $client->you_tube_profile_url ?? "") }}" placeholder="">
                                            </div>

                                            <div class="mb-2 col-md-6">
                                                <label for="instagram_profile_url"> Instagram Profile URL </label>
                                                <input type="text" class="form-control" id="instagram_profile_url" name="instagram_profile_url" value="{{ old('instagram_profile_url', $client->instagram_profile_url ?? "") }}" placeholder="">
                                            </div>

                                            <div class="mb-2 col-md-6">
                                                <label for="twitter_profile_url"> Twitter Profile URL </label>
                                                <input type="text" class="form-control" id="twitter_profile_url" name="twitter_profile_url" value="{{ old('twitter_profile_url', $client->twitter_profile_url ?? "") }}" placeholder="">
                                            </div>

                                            <div class="mb-2 col-md-6">
                                                <label for="linkedin_profile_url"> Linkedin Profile URL </label>
                                                <input type="text" class="form-control" id="linkedin_profile_url" name="linkedin_profile_url" value="{{ old('linkedin_profile_url', $client->linkedin_profile_url ?? "") }}" placeholder="">
                                            </div>
                                        </div>
                                    
                                        <div class="row g-2">
                                            <div class="mb-2 col-md-6">
                                                <label for="profile_image"> Profile Image </label>
                                                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="float-end">
                                <a href="{{ url('client-panel/dashboard/my-account') }}" class="btn btn-primary"> Go Back </a>
                                <button type="submit" class="btn btn-success"> Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
