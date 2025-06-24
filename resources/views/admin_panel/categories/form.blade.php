<div class="row g-2">
    <div class="mb-2 col-md-12">
        <label for="name"> Name <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name ?? "") }}" placeholder="" required>
    </div>
</div>

<div class="row g-2">
    <div class="mb-2 col-md-12">
        <label for="description"> Description </label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description ?? "") }}</textarea>
    </div>
</div>
