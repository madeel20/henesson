<header class="sticky-header" v-if="!isMobile()">
        <div class=" d-flex align-content-center">
            <img onClick="$('#c-sidebar, #sidebar-backdrop').addClass('show')" class="sidebar-icon" src="{{ asset('assets/images/sidebar-icon.png') }}" />
            <logo-component></logo-component>
        </div>
        <searchbar-component></searchbar-component>
        <div class="locale-container">
                <div class="dropdown">
                    @php
                        $localeImage = null;
                    @endphp
                    @foreach (core()->getCurrentChannel()->locales as $locale)
                        @if ($locale->code == app()->getLocale())
                            @php
                                $localeImage = $locale->locale_image;
                            @endphp
                        @endif
                    @endforeach

                    <div class="locale-icon">
                        @if ($localeImage)
                            <img src="{{ asset('/storage/' . $localeImage) }}" onerror="this.src = '{{ asset($localeImage) }}'" />
                        @elseif (app()->getLocale() == 'en')
                            <img src="{{ asset('/themes/velocity/assets/images/flags/en.png') }}" />
                        @endif
                    </div>

                    <select
                        class="btn btn-link dropdown-toggle control locale-switcher styled-select"
                        onchange="window.location.href = this.value"
                        @if (count(core()->getCurrentChannel()->locales) == 1)
                            disabled="disabled"
                        @endif>

                        @foreach (core()->getCurrentChannel()->locales as $locale)
                            @if (isset($searchQuery) && $searchQuery)
                                <option
                                    value="?{{ $searchQuery }}&locale={{ $locale->code }}"
                                    {{ $locale->code == app()->getLocale() ? 'selected' : '' }}>
                                    {{ $locale->name }}
                                </option>
                            @else
                                <option value="?locale={{ $locale->code }}" {{ $locale->code == app()->getLocale() ? 'selected' : '' }}>{{ $locale->name }}</option>
                            @endif
                        @endforeach
                    </select>

                    <div class="select-icon-container">
                        <span class="select-icon rango-arrow-down"></span>
                    </div>
                </div>
            </div>
          @include('velocity::layouts.top-nav.login-section')
                    {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
                        @include('shop::checkout.cart.mini-cart')
                    {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}
                <c-sidebar-component
                    main-sidebar=true
                    id="c-sidebar"
                    url="{{ url()->to('/') }}"
                   >
                </c-sidebar-component>

</header>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 20){
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })()
    </script>
@endpush
