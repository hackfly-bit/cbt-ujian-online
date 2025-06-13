<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu d-flex flex-column px-2" style="padding-bottom: 0px !important;">

    @php
        $branding = [
            'logoPutih' => \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoPutih')->value('value') ?? '',
            'logoHitam' => \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ?? '',
            'favLogoPutih' => \App\Models\SystemSetting::where('group', 'branding')->where('key', 'favLogoPutih')->value('value') ?? '',
            'favLogoHitam' => \App\Models\SystemSetting::where('group', 'branding')->where('key', 'favLogoHitam')->value('value') ?? '',
        ];
    @endphp

    <!-- Logo -->
    <a href="{{ route('any', 'index') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ $branding['logoPutih'] ? asset($branding['logoPutih']) : asset('images/placeholder.jpeg') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ $branding['favLogoPutih'] ? asset($branding['favLogoPutih']) : asset('images/placeholder.jpeg') }}" alt="small logo">
        </span>
    </a>
    <a href="{{ route('any', 'index') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ $branding['favLogoHitam'] ? asset($branding['favLogoHitam']) : asset('images/placeholder.jpeg') }}" alt="small logo">
        </span>
    </a>

    <!-- Optional toggle button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar scrollable content -->
    <div id="leftside-menu-container" class="flex-grow-1" data-simplebar style="min-height: 0;">
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="{{ route('second', ['pages', 'profile']) }}">
                <img src="/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Tosha Minner</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            {{-- MENU UJIAN ONLINE --}}
            <li class="side-nav-item">
                <a href="{{ route('any', 'index') }}" class="side-nav-link">
                    <i class="ri-home-4-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            {{-- MENU UJIAN ONLINE --}}
            <li class="side-nav-item">
                <a href="{{ route('bank-soal.index') }}" class="side-nav-link">
                    <i class="ri-book-line"></i>
                    <span> Bank Soal </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('ujian.index') }}" class="side-nav-link">
                    <i class="ri-file-edit-line"></i>
                    <span> Ujian </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('hasil-ujian.index') }}" class="side-nav-link">
                    <i class="ri-bar-chart-box-line"></i>
                    <span> Hasil Ujian </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('sertifikat.index') }}" class="side-nav-link">
                    <i class="ri-award-line"></i>
                    <span> Sertifikat </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMaster" aria-expanded="false" aria-controls="sidebarMaster"
                    class="side-nav-link">
                    <i class="ri-database-2-line"></i>
                    <span> Master Data </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMaster">
                    <ul class="side-nav-second-level mt-2">
                        <li class="side-nav-second-level mb-1">
                            <a href="{{ route('jenis-ujian.index') }}">Jenis Ujian</a>
                        </li>
                        <li class="side-nav-second-level mb-1">
                            <a href="{{ route('kategori.index') }}">Kategori</a>
                        </li>
                        <li class="side-nav-second-level">
                            <a href="{{ route('subkategori.index') }}">Sub Kategori</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('pengaturan.index') }}" class="side-nav-link">
                    <i class="ri-settings-3-line"></i>
                    <span> Pengaturan </span>
                </a>
            </li>
            {{-- END MENU UJIAN ONLINE --}}

            <li>
                <a data-bs-toggle="collapse" href="#sidebarComponents" aria-expanded="false"
                    aria-controls="sidebarComponents" class="side-nav-link">
                    <i class="ri-briefcase-line"></i>
                    <span> Components </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarComponents">
                    <ul class="side-nav-second-level">
                        <li class="side-nav-title">Apps</li>

                        <li class="side-nav-item">
                            <a href="{{ route('second', ['apps', 'calendar']) }}" class="side-nav-link">
                                <i class="ri-calendar-event-line"></i>
                                <span> Calendar </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('second', ['apps', 'chat']) }}" class="side-nav-link">
                                <i class="ri-message-3-line"></i>
                                <span> Chat </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false"
                                aria-controls="sidebarEmail" class="side-nav-link">
                                <i class="ri-mail-line"></i>
                                <span> Email </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEmail">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['email', 'inbox']) }}">Inbox</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['email', 'read']) }}">Read Email</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false"
                                aria-controls="sidebarTasks" class="side-nav-link">
                                <i class="ri-task-line"></i>
                                <span> Tasks </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarTasks">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['task', 'list']) }}">List</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['task', 'details']) }}">Details</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('second', ['apps', 'kanban']) }}" class="side-nav-link">
                                <i class="ri-list-check-3"></i>
                                <span> Kanban Board </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('second', ['apps', 'file-manager']) }}" class="side-nav-link">
                                <i class="ri-folder-2-line"></i>
                                <span> File Manager </span>
                            </a>
                        </li>

                        <li class="side-nav-title">Custom</li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false"
                                aria-controls="sidebarPages" class="side-nav-link">
                                <i class="ri-pages-line"></i>
                                <span> Pages </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPages">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['pages', 'profile']) }}">Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'invoice']) }}">Invoice</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'faq']) }}">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'pricing']) }}">Pricing</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'maintenance']) }}">Maintenance</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'starter']) }}">Starter Page</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'preloader']) }}">With Preloader</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['pages', 'timeline']) }}">Timeline</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false"
                                aria-controls="sidebarPagesAuth" class="side-nav-link">
                                <i class="ri-shield-user-line"></i>
                                <span> Auth Pages </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPagesAuth">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['auth', 'login']) }}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'login-2']) }}">Login 2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'register']) }}">Register</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'register-2']) }}">Register 2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'logout']) }}">Logout</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'logout-2']) }}">Logout 2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'recoverpw']) }}">Recover Password</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'recoverpw-2']) }}">Recover Password
                                            2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'lock-screen']) }}">Lock Screen</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'lock-screen-2']) }}">Lock Screen 2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'confirm-mail']) }}">Confirm Mail</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['auth', 'confirm-mail-2']) }}">Confirm Mail 2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPagesError" aria-expanded="false"
                                aria-controls="sidebarPagesError" class="side-nav-link">
                                <i class="ri-error-warning-line"></i>
                                <span> Error Pages </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPagesError">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['error', '404']) }}">Error 404</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['error', '404-alt']) }}">Error 404-alt</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['error', '500']) }}">Error 500</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false"
                                aria-controls="sidebarLayouts" class="side-nav-link">
                                <i class="ri-layout-line"></i>
                                <span> Layouts </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="side-nav-second-level">
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'horizontal']) }}"><span
                                                class="menu-text">Horizontal</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'detached']) }}"><span
                                                class="menu-text">Detached</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'full-view']) }}"><span
                                                class="menu-text">Full View</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'fullscreen-view']) }}"><span
                                                class="menu-text">Fullscreen View</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'hover-menu']) }}"><span
                                                class="menu-text">Hover Menu</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'compact']) }}"><span
                                                class="menu-text">Compact</span></a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="menu-link" target="_blank"
                                            href="{{ route('second', ['layouts-eg', 'icon-view']) }}"><span
                                                class="menu-text">Icon View</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-title">Components</li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false"
                                aria-controls="sidebarBaseUI" class="side-nav-link">
                                <i class="ri-briefcase-line"></i>
                                <span> Base UI </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarBaseUI">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['ui', 'accordions']) }}">Accordions</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'alerts']) }}">Alerts</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'avatars']) }}">Avatars</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'badges']) }}">Badges</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'breadcrumb']) }}">Breadcrumb</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'buttons']) }}">Buttons</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'cards']) }}">Cards</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'carousel']) }}">Carousel</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'collapse']) }}">Collapse</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'dropdowns']) }}">Dropdowns</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'embed-video']) }}">Embed Video</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'grid']) }}">Grid</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'links']) }}">Links</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'list-group']) }}">List Group</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'modals']) }}">Modals</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'notifications']) }}">Notifications</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'offcanvas']) }}">Offcanvas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'placeholders']) }}">Placeholders</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'pagination']) }}">Pagination</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'popovers']) }}">Popovers</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'progress']) }}">Progress</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'spinners']) }}">Spinners</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'tabs']) }}">Tabs</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'tooltips']) }}">Tooltips</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'typography']) }}">Typography</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['ui', 'utilities']) }}">Utilities</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarExtendedUI" aria-expanded="false"
                                aria-controls="sidebarExtendedUI" class="side-nav-link">
                                <i class="ri-stack-line"></i>
                                <span> Extended UI </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarExtendedUI">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['extended', 'dragula']) }}">Dragula</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['extended', 'range-slider']) }}">Range Slider</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['extended', 'ratings']) }}">Ratings</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['extended', 'scrollbar']) }}">Scrollbar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['extended', 'scrollspy']) }}">Scrollspy</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('any', 'widgets') }}" class="side-nav-link">
                                <i class="ri-pencil-ruler-2-line"></i>
                                <span> Widgets </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="false"
                                aria-controls="sidebarIcons" class="side-nav-link">
                                <i class="ri-service-line"></i>
                                <span> Icons </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarIcons">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['icons', 'remixicons']) }}">Remix Icons</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['icons', 'bootstrapicons']) }}">Bootstrap
                                            Icons</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarCharts" aria-expanded="false"
                                aria-controls="sidebarCharts" class="side-nav-link">
                                <i class="ri-bar-chart-line"></i>
                                <span> Charts </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCharts">
                                <ul class="side-nav-second-level">
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarApexCharts" aria-expanded="false"
                                            aria-controls="sidebarApexCharts">
                                            <span> Apex Charts </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarApexCharts">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a href="{{ route('second', ['charts', 'apex-area']) }}">Area</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('second', ['charts', 'apex-bar']) }}">Bar</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-bubble']) }}">Bubble</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-candlestick']) }}">Candlestick</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-column']) }}">Column</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-heatmap']) }}">Heatmap</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('second', ['charts', 'apex-line']) }}">Line</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-mixed']) }}">Mixed</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-timeline']) }}">Timeline</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-boxplot']) }}">Boxplot</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-treemap']) }}">Treemap</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('second', ['charts', 'apex-pie']) }}">Pie</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-radar']) }}">Radar</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-radialbar']) }}">RadialBar</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-scatter']) }}">Scatter</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('second', ['charts', 'apex-polar-area']) }}">Polar
                                                        Area</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'apex-sparklines']) }}">Sparklines</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarChartJSCharts"
                                            aria-expanded="false" aria-controls="sidebarChartJSCharts">
                                            <span> ChartJS </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarChartJSCharts">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'chartjs-area']) }}">Area</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'chartjs-bar']) }}">Bar</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'chartjs-line']) }}">Line</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('second', ['charts', 'chartjs-other']) }}">Other</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarForms" aria-expanded="false"
                                aria-controls="sidebarForms" class="side-nav-link">
                                <i class="ri-survey-line"></i>
                                <span> Forms </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarForms">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['forms', 'elements']) }}">Basic Elements</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['forms', 'advanced']) }}">Form Advanced</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['forms', 'validation']) }}">Validation</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['forms', 'wizard']) }}">Wizard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['forms', 'fileuploads']) }}">File Uploads</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['forms', 'editors']) }}">Editors</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarTables" aria-expanded="false"
                                aria-controls="sidebarTables" class="side-nav-link">
                                <i class="ri-table-line"></i>
                                <span> Tables </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarTables">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['tables', 'basic']) }}">Basic Tables</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['tables', 'datatable']) }}">Data Tables</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarMaps" aria-expanded="false"
                                aria-controls="sidebarMaps" class="side-nav-link">
                                <i class="ri-treasure-map-line"></i>
                                <span> Maps </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarMaps">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('second', ['maps', 'google']) }}">Google Maps</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['maps', 'vector']) }}">Vector Maps</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false"
                                aria-controls="sidebarMultiLevel" class="side-nav-link">
                                <i class="ri-share-line"></i>
                                <span> Multi Level </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarMultiLevel">
                                <ul class="side-nav-second-level">
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false"
                                            aria-controls="sidebarSecondLevel">
                                            <span> Second Level </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarSecondLevel">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a href="javascript: void(0);">Item 1</a>
                                                </li>
                                                <li>
                                                    <a href="javascript: void(0);">Item 2</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false"
                                            aria-controls="sidebarThirdLevel">
                                            <span> Third Level </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarThirdLevel">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a href="javascript: void(0);">Item 1</a>
                                                </li>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#sidebarFourthLevel"
                                                        aria-expanded="false" aria-controls="sidebarFourthLevel">
                                                        <span> Item 2 </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="sidebarFourthLevel">
                                                        <ul class="side-nav-forth-level">
                                                            <li>
                                                                <a href="javascript: void(0);">Item 2.1</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript: void(0);">Item 2.2</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>


                    </ul>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>

    <!-- Logout button fixed at bottom -->
    <div class="logout-fixed">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 logout-button">
                <i class="ri-logout-box-line"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>


</div>
