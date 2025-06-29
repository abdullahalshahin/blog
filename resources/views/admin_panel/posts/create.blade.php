<x-app-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Post Create |' }}</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin-panel/posts') }}">Posts</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Post Create</h4>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input. <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div id="form-errors" class="alert alert-danger d-none">
            <strong>Whoops!</strong> There were some problems with your input. <br><br>
            <ul id="error-list"></ul>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-aside-left">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <button type="button" class="btn m-0 p-0" id="form_field_ckeditor_input">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-secondary-lighten text-secondary font-20 rounded-circle">
                                                <i class="dripicons-align-justify"></i>
                                            </span>
                                        </div>
                                        <p class="mb-0 font-14 mt-1 text-start">CKEditor</p>
                                    </button>
                                </div>

                                <div class="col-6 mb-2">
                                    <button type="button" class="btn m-0 p-0" id="form_field_graph_table_input">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-secondary-lighten text-secondary font-20 rounded-circle">
                                                <i class="dripicons-view-thumb"></i>
                                            </span>
                                        </div>
                                        <p class="mb-0 font-14 mt-1 text-start">Graph Table</p>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="page-aside-right">
                            <form action="{{ url('admin-panel/posts') }}" method="POST" enctype="multipart/form-data" id="post_form">
                                @csrf

                                <div class="row g-2">
                                    <div class="mb-2 col-md-12">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="mb-2 col-md-12">
                                        <label for="excerpt">Excerpt</label>
                                        <textarea class="form-control" id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="mb-2 col-md-12">
                                        <label for="category_ids"> Category <span class="text-danger">*</span> </label>
                                        <select class="select2 form-control select2-multiple" id="category_ids" name="category_ids[]" data-toggle="select2" multiple="multiple">
                                            <option value=""> Choose Category </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ in_array($category->id, (old('category_ids', []) ? old('category_ids', []) : ($selected_category_ids ?? []))) ? 'selected' : '' }}>
                                                    {{ $category->name ?? "" }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 

                                <div class="row g-2">
                                    <div class="mb-2 col-md-6">
                                        <label for="featured_image">Featured Image</label>
                                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/png, image/gif, image/jpeg">
                                        @if ($post->featured_image ?? false)
                                            <img src="{{ url('images/posts', $post->featured_image) }}" alt="featured_image" class="mt-1 img-fluid img-thumbnail" width="200" />
                                        @endif
                                    </div>

                                    <div class="mb-2 col-md-6">
                                        <label for="input_status">Status <span class="text-danger">*</span></label>
                                        <select id="input_status" name="input_status" class="form-select" required>
                                            <option value="">Choose Status</option>
                                            @foreach ($status as $stat)
                                                <option value="{{ $stat }}" {{ old('input_status', $post->status ?? '') == $stat ? 'selected' : '' }}>
                                                    {{ $stat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-2" id="dynamic_fields">
                                    <!-- Dynamic CKEditor and Graph Table sections will be added here -->
                                </div>

                                <div class="float-end">
                                    <a href="{{ url('admin-panel/posts') }}" class="btn btn-primary button-last">Go Back</a>
                                    <button type="submit" class="btn btn-success button-last">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
        <script type="text/javascript">
            // Counter for unique field IDs
            let fieldCounter = 0;

            // Initialize CKEditor on existing textareas
            function initializeCKEditor(textareaId) {
                if (CKEDITOR.instances[textareaId]) {
                    CKEDITOR.instances[textareaId].destroy(true);
                }
                CKEDITOR.replace(textareaId, {
                    height: 200
                });
            }

            // Add CKEditor section
            document.getElementById('form_field_ckeditor_input').addEventListener('click', function () {
                const fieldId = `ckeditor_${fieldCounter++}`;

                const html = `
                    <div class="mb-3 col-md-12 dynamic-field" data-field-id="${fieldId}">
                        <label for="${fieldId}">CKEditor Title</label>
                        <input type="text" class="form-control mb-1" name="contents[${fieldId}][title]" value="" placeholder="Section Title">
                        <textarea class="form-control" id="${fieldId}" name="contents[${fieldId}][data]" rows="5"></textarea>
                        <input type="hidden" name="contents[${fieldId}][content_type]" value="text">
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-field">Remove</button>
                    </div>`;

                document.getElementById('dynamic_fields').insertAdjacentHTML('beforeend', html);

                initializeCKEditor(fieldId);

                // Add remove functionality
                document.querySelector(`[data-field-id="${fieldId}"] .remove-field`).addEventListener('click', function () {
                    document.querySelector(`[data-field-id="${fieldId}"]`).remove();
                });
            });

            // Add Graph Chart Input Panel
            document.getElementById('form_field_graph_table_input').addEventListener('click', function () {
                const fieldId = `chart_${fieldCounter++}`;
                const html = `
                    <div class="mb-3 col-md-12 dynamic-field" data-field-id="${fieldId}">
                        <label>Graph Chart Title</label>
                        <input type="text" class="form-control mb-1" name="contents[${fieldId}][title]" value="" placeholder="Section Title">
                        
                        <div class="mb-2">
                            <label for="chart_type_${fieldId}">Chart Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="contents[${fieldId}][data][chart_type]" id="chart_type_${fieldId}" required>
                                <option value="">Select Chart Type</option>
                                <option value="line">Line Chart</option>
                                <option value="bar">Single Bar Chart</option>
                                <option value="bar_distributed">Distributed Bar Chart</option>
                                <option value="column">Column Chart</option>
                                <option value="area">Area Chart</option>
                                <option value="pie">Pie Chart</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="${fieldId}">
                                <thead>
                                    <tr id="header_${fieldId}">
                                        <th>Label</th>
                                        <th>
                                            <input type="text" class="form-control" name="contents[${fieldId}][data][series][0][name]" value="Series 1" placeholder="Series Name">
                                            <select class="form-control mt-1" name="contents[${fieldId}][data][series][0][color]">
                                                <option value="">No Color</option>
                                                <option value="red">Red</option>
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                                <option value="orange">Orange</option>
                                            </select>
                                            <button type="button" class="btn btn-danger btn-sm mt-1 remove-series">Remove</button>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="body_${fieldId}">
                                    <tr>
                                        <td><input type="text" class="form-control" name="contents[${fieldId}][data][labels][0]" value="Label 1" placeholder="Label"></td>
                                        <td><input type="number" class="form-control" name="contents[${fieldId}][data][series][0][values][0]" value="0" placeholder="Value"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm mt-2 add-row" data-table-id="${fieldId}">Add Row</button>
                        <button type="button" class="btn btn-primary btn-sm mt-2 add-series" data-table-id="${fieldId}">Add Series</button>
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-field">Remove Chart</button>
                        <input type="hidden" name="contents[${fieldId}][content_type]" value="graph">
                    </div>`;

                document.getElementById('dynamic_fields').insertAdjacentHTML('beforeend', html);

                // Initialize chart table controls
                initializeChartControls(fieldId);
            });

            // Initialize chart table controls
            function initializeChartControls(tableId) {
                const table = document.getElementById(tableId);
                const headerRow = document.getElementById(`header_${tableId}`);
                const tbody = document.getElementById(`body_${tableId}`);

                document.querySelector(`[data-table-id="${tableId}"].add-series`).addEventListener('click', function () {
                    const seriesIndex = headerRow.querySelectorAll('th').length - 2;

                    if (seriesIndex >= 4) {
                        alert("You can only add up to 4 series.");
                        return;
                    }

                    const seriesHtml = `
                        <th>
                            <input type="text" class="form-control" name="contents[${tableId}][data][series][${seriesIndex}][name]" value="Series ${seriesIndex + 1}" placeholder="Series Name">
                            <select class="form-control mt-1" name="contents[${tableId}][data][series][${seriesIndex}][color]">
                                <option value="">No Color</option>
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="orange">Orange</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm mt-1 remove-series">Remove</button>
                        </th>`;
                    headerRow.insertBefore(document.createElement('th'), headerRow.lastElementChild).outerHTML = seriesHtml;

                    // Add value input to each row
                    tbody.querySelectorAll('tr').forEach((row, rowIndex) => {
                        const cellHtml = `<td><input type="number" class="form-control" name="contents[${tableId}][data][series][${seriesIndex}][values][${rowIndex}]" value="0" placeholder="Value"></td>`;
                        row.insertBefore(document.createElement('td'), row.lastElementChild).outerHTML = cellHtml;
                    });

                    // Rebind remove series event
                    bindRemoveSeries(tableId);
                });

                // Add Row
                document.querySelector(`[data-table-id="${tableId}"].add-row`).addEventListener('click', function () {
                    const seriesCount = headerRow.querySelectorAll('th').length - 2; // Exclude Label and Actions columns
                    const rowIndex = tbody.querySelectorAll('tr').length;
                    let rowHtml = `
                        <tr>
                            <td><input type="text" class="form-control" name="contents[${tableId}][data][labels][${rowIndex}]" value="Label ${rowIndex + 1}" placeholder="Label"></td>`;
                    for (let i = 0; i < seriesCount; i++) {
                        rowHtml += `<td><input type="number" class="form-control" name="contents[${tableId}][data][series][${i}][values][${rowIndex}]" value="0" placeholder="Value"></td>`;
                    }
                    rowHtml += `<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td></tr>`;
                    tbody.insertAdjacentHTML('beforeend', rowHtml);

                    // Rebind remove row event
                    bindRemoveRow(tableId);
                });

                // Remove Chart
                document.querySelector(`[data-field-id="${tableId}"] .remove-field`).addEventListener('click', function () {
                    document.querySelector(`[data-field-id="${tableId}"]`).remove();
                });

                // Bind remove series and row events
                bindRemoveSeries(tableId);
                bindRemoveRow(tableId);
            }

            // Bind remove series events
            function bindRemoveSeries(tableId) {
                const headerRow = document.getElementById(`header_${tableId}`);
                headerRow.querySelectorAll('.remove-series').forEach(button => {
                    button.addEventListener('click', function () {
                        const th = button.closest('th');
                        const columnIndex = Array.from(headerRow.querySelectorAll('th')).indexOf(th);
                        th.remove();

                        // Remove corresponding cell from each row
                        document.getElementById(`body_${tableId}`).querySelectorAll('tr').forEach(row => {
                            row.children[columnIndex].remove();
                        });
                    });
                });
            }

            // Bind remove row events
            function bindRemoveRow(tableId) {
                document.getElementById(`body_${tableId}`).querySelectorAll('.remove-row').forEach(button => {
                    button.addEventListener('click', function () {
                        button.closest('tr').remove();
                    });
                });
            }

            $(document).ready(function() {
                $("#post_form").on("submit", function(e) {
                    e.preventDefault();

                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
    
                    let formData = new FormData(this);
                    let errorContainer = $("#form-errors");
                    let errorList = $("#error-list");

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            window.location.href = "{{ url('admin-panel/posts') }}";
                        },
                        error: function(xhr) {
                            errorList.empty();
                            errorContainer.addClass('d-none');
    
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorContainer.removeClass('d-none');
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorList.append('<li>' + value + '</li>');
                                });
                            }
                            else if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorContainer.removeClass('d-none');
                                errorList.append('<li>' + xhr.responseJSON.error + '</li>');
                            } 
                            else {
                                errorContainer.removeClass('d-none');
                                errorList.append('<li>An unexpected error occurred. Please try again.</li>');
                            }
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
