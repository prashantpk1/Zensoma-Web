<div>
    <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                src="{{ static_asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('dashboard') }}"></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="sidebar-list">

                    <a class="sidebar-link sidebar-title  link-nav  @if ($url == 'dashboard') badge-light-primary @endif"
                        href="{{ route('dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg><span class="lan-3">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'customer.index' || $url == 'customer.create' || $url == 'customer.edit') badge-light-primary @endif"
                        href="{{ route('customer.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"> </use>
                        </svg><span>Customers</span></a></li>



                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                        class="sidebar-link sidebar-title @if ($url == 'language.index' || $url == 'language.create' || $url == 'language.edit')  @endif" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-layout') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-layout') }}"></use>
                        </svg><span class="lan-7">Setting</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('advertisement.index') }}"
                            class="@if ($url == 'advertisement.index' || $url == 'advertisement.create' || $url == 'advertisement.edit') badge-light-primary active @endif">
                            Advertisements</a></li>
                        <li><a href="{{ route('language.index') }}"
                                class="@if ($url == 'language.index' || $url == 'language.create' || $url == 'language.edit') badge-light-primary active @endif">Languages</a>
                        </li>
                        <li><a href="{{ route('category.index') }}"
                                class="@if ($url == 'category.index' || $url == 'category.create' || $url == 'category.edit') badge-light-primary active @endif">Categories</a>
                        </li>
                        <li><a href="{{ route('category-type.index') }}"
                            class="@if ($url == 'category-type.index' || $url == 'category-type.create' || $url == 'category-type.edit') badge-light-primary active @endif">
                            Category Types</a></li>
                        <li><a href="{{ route('quote.index') }}"
                                class="@if ($url == 'quote.index' || $url == 'quote.create' || $url == 'quote.edit') badge-light-primary active @endif">Quotes</a>
                        </li>
                        <li><a href="{{ route('coupon.index') }}"
                                class="@if ($url == 'coupon.index' || $url == 'coupon.create' || $url == 'coupon.edit') badge-light-primary active @endif">Discount
                                Coupons</a></li>
                        <li><a href="{{ route('word.index') }}"
                                class="@if ($url == 'word.index' || $url == 'word.create' || $url == 'word.edit') badge-light-primary active @endif">Search Word
                                List</a></li>
                        <li><a href="{{ route('multi-language.index') }}"
                                class="@if ($url == 'multi-language.index' || $url == 'multi-language.create' || $url == 'multi-language.edit') badge-light-primary active @endif">Multi
                                Language Keys</a></li>
                        <li><a href="{{ route('cms.index') }}"
                                class="@if ($url == 'cms.index' || $url == 'cms.create' || $url == 'cms.edit') badge-light-primary active @endif">Cms
                                Pages</a></li>
                        <li><a href="{{ route('question.index') }}"
                                class="@if ($url == 'question.index' || $url == 'question.create' || $url == 'question.edit') badge-light-primary active @endif">Predefined
                                Questions</a></li>








                    </ul>
                </li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'blog.index' || $url == 'blog.create' || $url == 'blog.edit') badge-light-primary @endif"
                        href="{{ route('blog.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>Blogs</span></a></li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'notification.index' || $url == 'notification.create' || $url == 'notification.edit') badge-light-primary @endif"
                        href="{{ route('notification.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-blog') }}"> </use>
                        </svg><span>Customized Notification</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'buddy-network.index' || $url == 'buddy-network.create' || $url == 'buddy-network.edit') badge-light-primary @endif"
                        href="{{ route('buddy-network.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-social') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-social') }}">
                            </use>
                        </svg><span>Buddy Network</span></a></li>


                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subscription.index' || $url == 'subscription.create' || $url == 'subscription.edit') badge-light-primary @endif"
                        href="{{ route('subscription.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-task') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-task') }}">
                            </use>
                        </svg><span>Subscriptions</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if (
                            $url == 'running-subscription.index' ||
                                $url == 'running-subscription.create' ||
                                $url == 'running-subscription.edit') badge-light-primary @endif"
                        href="{{ route('running-subscription.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-task') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-task') }}">
                            </use>
                        </svg><span>Running Subscription</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'transaction.index' || $url == 'transaction.create' || $url == 'transaction.edit') badge-light-primary @endif"
                        href="{{ route('transaction.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-task') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-task') }}">
                            </use>
                        </svg><span>Transactions</span></a></li>



                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'subadmin.index' || $url == 'subadmin.create' || $url == 'subadmin.edit') badge-light-primary @endif"
                        href="{{ route('subadmin.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-user') }}">
                            </use>
                        </svg><span>Sub Admin</span></a></li>

                <li class="sidebar-list"><a
                        class="sidebar-link sidebar-title link-nav @if ($url == 'content.index' || $url == 'content.create' || $url == 'content.edit') badge-light-primary @endif"
                        href="{{ route('content.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-editors') }}">
                            </use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#fill-editors') }}">
                            </use>
                        </svg><span>Contents</span></a></li>


            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
