<x-guest-layout>
    <x-slot name="page_title">{{ $page_title ?? 'Privacy Policy |' }}</x-slot>

    <div class="tf-sp-1 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ url('/') }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">Privacy</span>
                </li>
            </ul>
        </div>
    </div>

    <section class="tf-sp-2">
        <div class="container">
            <div class="privary-wrap">
                <div class="entry-privary">
                    {!! $privacy_policy_data['value'] ?? "" !!}
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
