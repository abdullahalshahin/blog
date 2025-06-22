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
                                        {!! (json_decode($content->data, true)) !!}
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
                                            new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: chartData.labels,
                                                    datasets: chartData.series.map((series, i) => ({
                                                        label: series.name,
                                                        data: series.values,
                                                        backgroundColor: series.color || `rgba(75, 192, 192, 0.${i + 2})`,
                                                        borderColor: series.color || `rgba(75, 192, 192, 1)`,
                                                        borderWidth: 1
                                                    }))
                                                },
                                                options: {
                                                    responsive: true,
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
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
            // Additional scripts can be added here if needed
        </script>
    </x-slot>
</x-guest-layout>
