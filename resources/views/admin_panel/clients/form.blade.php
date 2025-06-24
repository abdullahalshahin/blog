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
        <label for="email"> Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email ?? "") }}" placeholder="" required>
    </div>
</div>

<div class="row g-2">
    <div class="mb-2 col-md-6">
        <label for="password"> Password <span class="text-danger">*</span></label>
        <div class="input-group input-group-merge">
            <input type="password" id="password" name="password" value="{{ old('password', $client->security ?? "") }}" class="form-control" placeholder="" {{ (Request::segment(4) == "edit") ? "disabled" : "required" }}>
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
        </div>
    </div>

    <div class="mb-2 col-md-6">
        <label for="password_confirmation"> Confirm Password <span class="text-danger">*</span></label>
        <div class="input-group input-group-merge">
            <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation', $client->security ?? "") }}" class="form-control" placeholder="" {{ (Request::segment(4) == "edit") ? "disabled" : "required" }}>
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
        </div>
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

        @if ($client->profile_image)
            <img src="{{ url('images/clients', $client->profile_image) }}" alt="profile_image" class="mt-1 img-fluid img-thumbnail" width="200" />
        @endif
    </div>

    <div class="mb-2 col-md-6">
        <label for="input_status"> Status <span class="text-danger">*</span> </label>
        <select id="input_status" name="input_status" class="form-select" required>
            <option value=""> Choose Status </option>
            @foreach ($status as $stat)
                <option value="{{ $stat }}" {{ (old('input_status') ?? ($client->status ?? '')) == $stat ? 'selected' : '' }}>
                    {{ $stat }}
                </option>
            @endforeach
        </select>
    </div>
</div>
