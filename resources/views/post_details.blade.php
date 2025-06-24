<x-guest-layout>
    <x-slot name="page_title">{{ $post->title ?? '' }} | {{ config('app.name', 'Laravel') }}</x-slot>

    <div class="tf-sp-1">
        <!-- Optional spacer section -->
    </div>

    <section class="tf-sp-2">
        <div class="container">
            <div class="s-blog-detail">
                <div class="box-direction sticky content-left">
                    <div class="bottom">
                        <p class="caption font-2 text-main-2">
                            Share this post:
                        </p>
                        <span class="br-line bg-gray-5"></span>
                        <ul class="social-list style-2 justify-content-start flex-wrap">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="icon-facebook"></i></a></li>
                            <li><a href="https://x.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"><i class="icon-x"></i></a></li>
                            <li><a href="https://www.instagram.com/"><i class="icon-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}"><i class="icon-linkin"></i></a></li>
                            <li><a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}"><i class="icon-whatapp"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="content-blog">
                    <div class="main-content">
                        <div class="box-title">
                            <h2 class="fw-semibold">
                                {{ $post->title }}
                            </h2>
                            <div class="entry_meta">
                                <div class="tags">
                                    <img src="{{ url('onsus/images/folder.svg') }}" alt="">
                                    <p class="caption fw-medium text-secondary font-2">
                                        {{ $post->categories->pluck('name')->implode(', ') }}
                                    </p>
                                </div>
                                <div class="date">
                                    <p class="caption font-2">
                                        {{ $post->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="post-content">
                            @foreach ($post->contents as $index => $content)
                                @if ($content->content_type === 'text')
                                    <div class="text-content mb-4">
                                        {!! json_decode($content->data, true) !!}
                                    </div>
                                @elseif ($content->content_type === 'graph')
                                    <div class="graph-content mb-4">
                                        <div class="chart-container" style="position: relative; max-height: 400px; width: 100%;">
                                            <canvas id="chart-{{ $index }}"></canvas>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const ctx = document.getElementById('chart-{{ $index }}').getContext('2d');
                                            const chartData = @json(json_decode($content->data));
                                            const chartTypeRaw = chartData.chart_type || 'bar'; // Fallback to 'bar'
                                            // Map chart types: column -> bar, area -> line with fill
                                            const chartType = chartTypeRaw === 'column' ? 'bar' : chartTypeRaw === 'area' ? 'line' : chartTypeRaw;
                                            const isFilled = chartTypeRaw === 'area'; // Enable fill for area charts
                                            const isAreaChart = chartTypeRaw === 'area'; // For area-specific settings
                                            new Chart(ctx, {
                                                type: chartType,
                                                data: {
                                                    labels: chartData.labels,
                                                    datasets: chartData.series.map((series, i) => ({
                                                        label: series.name,
                                                        data: series.values,
                                                        backgroundColor: series.color || `rgba(75, 192, 192, 0.${i + 2})`,
                                                        borderColor: series.color || `rgba(75, 192, 192, 1)`,
                                                        borderWidth: chartType === 'pie' || chartType === 'doughnut' ? 0 : 1,
                                                        fill: isFilled // Enable fill for area charts
                                                    }))
                                                },
                                                options: {
                                                    responsive: true,
                                                    scales: chartType === 'pie' || chartType === 'doughnut' ? {} : {
                                                        y: {
                                                            beginAtZero: true,
                                                            display: !isAreaChart // Hide y-axis for area charts
                                                        },
                                                        x: {
                                                            display: !isAreaChart // Hide x-axis for area charts
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: !isAreaChart && chartType !== 'pie' && chartType !== 'doughnut' // Hide legend for area, pie, doughnut
                                                        },
                                                        tooltip: {
                                                            enabled: !isAreaChart // Disable tooltips for area charts
                                                        }
                                                    },
                                                    elements: {
                                                        line: {
                                                            tension: isFilled ? 0.4 : 0 // Smoother curves for area charts
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="main-preview">
                        <div class="comment-wrap">
                            <h5 class="fw-semibold">{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</h5>
                        
                            <div class="comment-list">
                                @forelse ($post->comments as $comment)
                                    <div class="author-wrap">
                                        <div class="avt">
                                            <img src="{{ $comment->commenter->profile_image ?? asset('hyper/images/avator.png') }}" alt="{{ $comment->commenter->name ?? 'User' }}">
                                        </div>
                        
                                        <div class="wrap">
                                            <div class="box-comment">
                                                <div class="entry_meta">
                                                    <h6 class="name fw-semibold">{{ $comment->commenter->name ?? 'Anonymous' }}</h6>
                                                    <p class="body-small">{{ $comment->formatted_created_at }}</p>
                                                </div>
                                                <p>{{ $comment->content }}</p>
                                            </div>

                                            {{-- @if (Auth::guard('web')->check())
                                                <div class="reply-form-wrap mt-3">
                                                    <form action="{{ url('user-panel/comment', $post->id) }}" method="POST" class="form-add-comment reply-form" data-parent-id="{{ $comment->id }}">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <fieldset class="align-items-sm-start">
                                                            <label for="reply-comment-{{ $comment->id }}" class="d-none">Reply</label>
                                                            <textarea id="reply-comment-{{ $comment->id }}" name="comment" placeholder="Write your reply..." required maxlength="1000" aria-describedby="reply-error-{{ $comment->id }}"></textarea>
                                                            <div id="reply-error-{{ $comment->id }}" class="invalid-feedback d-none"></div>
                                                        </fieldset>
                                                        <div class="btn-submit mt-2">
                                                            <button type="submit" class="tf-btn btn-gray btn-sm" aria-label="Submit reply">
                                                                <span class="text-white">Reply</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif --}}
                        
                                            @if ($comment->sub_comments->count())
                                                <div class="rep-comment">
                                                    @foreach ($comment->sub_comments as $sub_comment)
                                                        <div class="author-wrap">
                                                            <div class="avt">
                                                                <img src="{{ $sub_comment->commenter->profile_image ?? asset('hyper/images/avator.png') }}" alt="{{ $sub_comment->commenter->name ?? 'User' }}">
                                                            </div>
                                                            <div class="box-comment">
                                                                <div class="entry_meta">
                                                                    <h6 class="name fw-semibold">{{ $sub_comment->commenter->name ?? 'Anonymous' }}</h6>
                                                                    <p class="body-small">{{ $sub_comment->formatted_created_at }}</p>
                                                                </div>
                                                                <p>{{ $sub_comment->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p>No comments yet.</p>
                                @endforelse
                            </div>
                        </div>

                        @if (Auth::guard('client')->check())
                            <div class="add-comment-wrap">
                                <h5 class="fw-semibold">Add Your Comment</h5>

                                <div id="form-errors" class="alert alert-danger d-none">
                                    <strong>Whoops!</strong> There were some problems with your input. <br><br>
                                    <ul id="error-list"></ul>
                                </div>

                                <div id="form-success" class="alert alert-success d-none"></div>

                                <div>
                                    <form action="{{ url('client-panel/comment', $post->id) }}" method="POST" class="form-add-comment" id="comment_form">
                                        @csrf

                                        <fieldset>
                                            <label>Name:</label>
                                            <input type="text" placeholder="Your name" value="{{ Auth::guard('client')->user()->name ?? "" }}" readonly>
                                        </fieldset>

                                        <fieldset class="align-items-sm-start">
                                            <label>Comment:</label>
                                            <textarea name="comment" placeholder="Message" required>{{ old('comment') }}</textarea>
                                        </fieldset>

                                        <div class="btn-submit">
                                            <button type="submit" class="tf-btn btn-gray btn-large-2">
                                                <span class="text-white">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="box-direction content-right">
                    <div class="bottom d-xxl-block d-none">
                        <div class="blog-sidebar sidebar-content-wrap">
                            <div class="sidebar-item style-2">
                                <h6 class="sb-title fw-semibold">
                                    Categories
                                </h6>
                                <div class="sb-content sb-category">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('categories.show', $category->slug) }}" class="link">
                                                    <span class="body-text-3">{{ $category->name }}</span>
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#comment_form").on("submit", function(e) {
                e.preventDefault();

                const $form = $(this);
                const $errorContainer = $("#form-errors");
                const $errorList = $("#error-list");
                const $successContainer = $("#form-success");
                const $submitButton = $form.find('button[type="submit"]');
                const originalButtonText = $submitButton.html();

                // Disable button and show loading state
                $submitButton.prop('disabled', true).html('<span>Loading...</span>');

                // Clear previous messages
                $errorContainer.addClass('d-none');
                $successContainer.addClass('d-none');
                $errorList.empty();

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $successContainer.removeClass('d-none').text(response.success);
                            $form[0].reset(); // Clear form
                            // Optionally reload comments section or append new comment dynamically
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            $errorContainer.removeClass('d-none');
                            $errorList.append(`<li>${xhr.responseJSON.error}</li>`);
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $errorContainer.removeClass('d-none');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $errorList.append(`<li>${value}</li>`);
                            });
                        } else {
                            $errorContainer.removeClass('d-none');
                            $errorList.append('<li>An unexpected error occurred. Please try again.</li>');
                        }
                    },
                    complete: function() {
                        // Re-enable button and restore text
                        $submitButton.prop('disabled', false).html(originalButtonText);
                    }
                });
            });
            });
        </script>
    </x-slot>
</x-guest-layout>