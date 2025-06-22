<div class="row g-2">
    <div class="mb-2 col-md-5">
        <label for="product_name"> Product Name <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $banner->product_name ?? "") }}" placeholder="" required>
    </div>

    <div class="mb-2 col-md-7">
        <label for="title"> Title <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $banner->title ?? "") }}" placeholder="" required>
    </div>
</div>

<div class="row g-2">
    <div class="mb-2 col-md-12">
        <label for="short_description"> Short Description </label>
        <textarea class="form-control" id="short_description" name="short_description" rows="2">{{ old('short_description', $banner->short_description ?? "") }}</textarea>
    </div>
</div>

<div class="row g-2">
    <div class="mb-2 col-md-3">
        <label for="price"> Price <span class="text-danger">*</span> </label>
        <input type="number" min="0" class="form-control" id="price" name="price" value="{{ old('price', $banner->price ?? "") }}" placeholder="" required>
    </div>
    
    <div class="mb-2 col-md-6">
        <label for="url"> URL </label>
        <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $banner->url ?? "") }}" placeholder="">
    </div>

    <div class="mb-2 col-md-3">
        <label for="priority"> Priority <span class="text-danger">*</span> </label>
        <input type="number" min="0" class="form-control" id="priority" name="priority" value="{{ old('priority', $banner->priority ?? "") }}" placeholder="" required>
    </div>
</div>

<div class="row g-2">
    <div class="mb-2 col-md-6">
        <label for="background_image"> Background Image </label>
        <input type="file" class="form-control" id="background_image" name="background_image" accept="image/png, image/gif, image/jpeg">

        @if ($banner->background_image)
            <img src="{{ url('images/banners', $banner->background_image) }}" alt="background_image" class="mt-1 img-fluid img-thumbnail" width="200" />
        @endif
    </div>

    <div class="mb-2 col-md-6">
        <label for="input_status"> Status <span class="text-danger">*</span> </label>
        <select id="input_status" name="input_status" class="form-select" required>
            <option value=""> Choose Status </option>
            @foreach ($status as $stat)
                <option value="{{ $stat }}" {{ (old('input_status') ?? ($banner->status ?? '')) == $stat ? 'selected' : '' }}>
                    {{ $stat }}
                </option>
            @endforeach
        </select>
    </div>
</div>
