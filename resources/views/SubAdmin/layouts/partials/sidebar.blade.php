<div>
    <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt=""><img
                class="img-fluid for-dark" src="{{ static_asset('admin/assets/images/logo/logo.png') }}"
                alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                src="{{ static_asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                            src="{{ static_asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>

                {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                    <label class="badge badge-light-primary">New</label>
                    <a class="sidebar-link sidebar-title @if ($url == 'dashboard') badge-light-primary @endif"
                        href="{{ route('dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg><span class="lan-3">Dashboard</span>
                    </a>
                </li> --}}

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'my-session.index' || $url == 'my-session.create' || $url == 'my-session.edit') badge-light-primary @endif"
                        href="{{ route('my-session.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-editors') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-editors') }}">
                            </use>
                        </svg><span>My Session</span></a></li>



                <li class="sidebar-list"><a
                    class="sidebar-link sidebar-title link-nav @if ($url == 'my-booking.index' || $url == 'my-booking.create' || $url == 'my-booking.edit') badge-light-primary @endif"
                    href="{{ route('my-booking.index') }}">
                    <svg class="stroke-icon">
                        <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-calendar') }}">
                        </use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-calendar') }}">
                        </use>
                    </svg><span>My Booking</span></a></li>



                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav"
                        href="{{ route('calendar.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-search') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-search') }}">
                            </use>
                        </svg><span>Add Slot</span></a></li>


            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
