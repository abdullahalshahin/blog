<x-guest-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Home' }} | {{ config('app.name', 'Laravel') }}</x-slot>

    <div class="tf-sp-1">
        
    </div>

    <section>
        <div class="container">
            <div class="d-flex gap-36">
                <div class="tf-grid-layout sm-col-2 md-col-3">
                    @forelse ($posts as $post)
                        <div class="news-item hover-img">
                            <a href="{{ url('posts', $post->slug) }}" class="entry_image img-style">
                                @if ($post->featured_image)
                                    <img src="{{ url($post->featured_image) }}" data-src="{{ url($post->featured_image) }}" alt="" class="lazyload">
                                @else
                                    <img src="{{ asset('hyper/images/no_image.png') }}" data-src="{{ asset('hyper/images/no_image.png') }}" alt="" class="lazyload">
                                @endif
                            </a>

                            <div class="content">
                                <div class="entry_meta">
                                    <div class="tags">
                                        <img src="{{ url('onsus/images/folder.svg') }}" alt="">
                                    </div>

                                    <div class="date">
                                        <p class="caption font-2">
                                            {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d-M-Y g:i:s A') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="entry_infor_news">
                                    <h6>
                                        <a href="{{ url('posts', $post->slug) }}" class="link fw-semibold">
                                            {{ $post->title ?? "" }}
                                        </a>
                                    </h6>

                                    <p class="subs body-text-3">
                                        {{ $post->excerpt ?? "" }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        
                    @endforelse
                </div>

                <div class="blog-sidebar d-xl-flex d-none sidebar-content-wrap">
                    <div class="sidebar-item style-2">
                        <h6 class="sb-title fw-semibold">
                            Categories
                        </h6>
                        <div class="sb-content sb-category">
                            <ul>
                                <li>
                                    <a href="#" class="link">
                                        <span class="body-text-3">Apparel</span>
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="link">
                                        <span class="body-text-3">Automotive parts & accessories</span>
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="link">
                                        <span class="body-text-3">Beauty & personal care</span>
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="link">
                                        <span class="body-text-3">Consumer Electronics</span>
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
