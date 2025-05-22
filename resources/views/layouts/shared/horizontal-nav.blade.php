<!-- ========== Horizontal Menu Start ========== -->
<div class="topnav">
    <div class="container-fluid active  ">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse active" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-home-4-line"></i>Dashboards <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboards">
                            <a href="{{ route('any', 'analytics') }}" class="dropdown-item">Analytics</a>
                            <a href="{{ route('any', 'index') }}" class="dropdown-item">Ecommerce</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-line"></i>Apps <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                            <a href="{{ route('second', ['apps', 'calendar']) }}" class="dropdown-item">Calendar</a>
                            <a href="{{ route('second', ['apps', 'chat']) }}" class="dropdown-item">Chat</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Email <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('second', ['email', 'inbox']) }}" class="dropdown-item">Inbox</a>
                                    <a href="{{ route('second', ['email', 'read']) }}" class="dropdown-item">Read Email</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-tasks" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tasks <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tasks">
                                    <a href="{{ route('second', ['task', 'list']) }}" class="dropdown-item">List</a>
                                    <a href="{{ route('second', ['task', 'details']) }}" class="dropdown-item">Details</a>
                                </div>
                            </div>
                            <a href="{{ route('second', ['apps', 'kanban']) }}" class="dropdown-item">Kanban</a>
                            <a href="{{ route('second', ['apps', 'file-manager']) }}" class="dropdown-item">File Manager</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-pages-line"></i>Pages <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Authenitication <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                    <a href="{{ route('second', ['auth', 'login']) }}" class="dropdown-item">Login</a>
                                    <a href="{{ route('second', ['auth', 'login-2']) }}" class="dropdown-item">Login 2</a>
                                    <a href="{{ route('second', ['auth', 'register']) }}" class="dropdown-item">Register</a>
                                    <a href="{{ route('second', ['auth', 'register-2']) }}" class="dropdown-item">Register 2</a>
                                    <a href="{{ route('second', ['auth', 'logout']) }}" class="dropdown-item">Logout</a>
                                    <a href="{{ route('second', ['auth', 'logout-2']) }}" class="dropdown-item">Logout 2</a>
                                    <a href="{{ route('second', ['auth', 'recoverpw']) }}" class="dropdown-item">Recover Password</a>
                                    <a href="{{ route('second', ['auth', 'recoverpw-2']) }}" class="dropdown-item">Recover Password 2</a>
                                    <a href="{{ route('second', ['auth', 'lock-screen']) }}" class="dropdown-item">Lock Screen</a>
                                    <a href="{{ route('second', ['auth', 'lock-screen-2']) }}" class="dropdown-item">Lock Screen 2</a>
                                    <a href="{{ route('second', ['auth', 'confirm-mail']) }}" class="dropdown-item">Confirm Mail</a>
                                    <a href="{{ route('second', ['auth', 'confirm-mail-2']) }}" class="dropdown-item">Confirm Mail 2</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-error" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Error <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-error">
                                    <a href="{{ route('second', ['error', '404']) }}" class="dropdown-item">Error 404</a>
                                    <a href="{{ route('second', ['error', '404-alt']) }}" class="dropdown-item">Error 404-alt</a>
                                    <a href="{{ route('second', ['error', '500']) }}" class="dropdown-item">Error 500</a>
                                </div>
                            </div>
                            <a href="{{ route('second', ['pages', 'profile']) }}" class="dropdown-item">Starter Page</a>
                            <a href="{{ route('second', ['pages', 'invoice']) }}" class="dropdown-item">With Preloader</a>
                            <a href="{{ route('second', ['pages', 'faq']) }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('second', ['pages', 'pricing']) }}" class="dropdown-item">Invoice</a>
                            <a href="{{ route('second', ['pages', 'maintenance']) }}" class="dropdown-item">FAQ</a>
                            <a href="{{ route('second', ['pages', 'starter']) }}" class="dropdown-item">Pricing</a>
                            <a href="{{ route('second', ['pages', 'preloader']) }}" class="dropdown-item">Maintenance</a>
                            <a href="{{ route('second', ['pages', 'timeline']) }}" class="dropdown-item">Timeline</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-stack-line"></i>Components <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">
                            <a href="{{ route('any', 'widgets') }}" class="dropdown-item">Widgets</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Base UI 1 <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-ui-kit">
                                    <a href="{{ route('second', ['ui', 'accordions']) }}" class="dropdown-item">Accordions</a>
                                    <a href="{{ route('second', ['ui', 'alerts']) }}" class="dropdown-item">Alerts</a>
                                    <a href="{{ route('second', ['ui', 'avatars']) }}" class="dropdown-item">Avatars</a>
                                    <a href="{{ route('second', ['ui', 'badges']) }}" class="dropdown-item">Badges</a>
                                    <a href="{{ route('second', ['ui', 'breadcrumb']) }}" class="dropdown-item">Breadcrumb</a>
                                    <a href="{{ route('second', ['ui', 'buttons']) }}" class="dropdown-item">Buttons</a>
                                    <a href="{{ route('second', ['ui', 'cards']) }}" class="dropdown-item">Cards</a>
                                    <a href="{{ route('second', ['ui', 'carousel']) }}" class="dropdown-item">Carousel</a>
                                    <a href="{{ route('second', ['ui', 'collapse']) }}" class="dropdown-item">Dropdowns</a>
                                    <a href="{{ route('second', ['ui', 'dropdowns']) }}" class="dropdown-item">Embed Video</a>
                                    <a href="{{ route('second', ['ui', 'embed-video']) }}" class="dropdown-item">Grid</a>
                                    <a href="{{ route('second', ['ui', 'grid']) }}" class="dropdown-item">List Group</a>
                                    <a href="{{ route('second', ['ui', 'links']) }}" class="dropdown-item">Links</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit2" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Base UI 2 <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-ui-kit2">
                                    <a href="{{ route('second', ['ui', 'list-group']) }}" class="dropdown-item">Modals</a>
                                    <a href="{{ route('second', ['ui', 'modals']) }}" class="dropdown-item">Notifications</a>
                                    <a href="{{ route('second', ['ui', 'notifications']) }}" class="dropdown-item">Offcanvas</a>
                                    <a href="{{ route('second', ['ui', 'offcanvas']) }}" class="dropdown-item">Placeholders</a>
                                    <a href="{{ route('second', ['ui', 'placeholders']) }}" class="dropdown-item">Pagination</a>
                                    <a href="{{ route('second', ['ui', 'pagination']) }}" class="dropdown-item">Popovers</a>
                                    <a href="{{ route('second', ['ui', 'popovers']) }}" class="dropdown-item">Progress</a>
                                    <a href="{{ route('second', ['ui', 'progress']) }}" class="dropdown-item">Ribbons</a>
                                    <a href="{{ route('second', ['ui', 'spinners']) }}" class="dropdown-item">Spinners</a>
                                    <a href="{{ route('second', ['ui', 'tabs']) }}" class="dropdown-item">Tabs</a>
                                    <a href="{{ route('second', ['ui', 'tooltips']) }}" class="dropdown-item">Tooltips</a>
                                    <a href="{{ route('second', ['ui', 'typography']) }}" class="dropdown-item">Typography</a>
                                    <a href="{{ route('second', ['ui', 'utilities']) }}" class="dropdown-item">Utilities</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-extended-ui" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Extended UI <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-extended-ui">
                                    <a href="{{ route('second', ['extended', 'dragula']) }}" class="dropdown-item">Dragula</a>
                                    <a href="{{ route('second', ['extended', 'range-slider']) }}" class="dropdown-item">Range Slider</a>
                                    <a href="{{ route('second', ['extended', 'ratings']) }}" class="dropdown-item">Ratings</a>
                                    <a href="{{ route('second', ['extended', 'scrollbar']) }}" class="dropdown-item">Scrollbar</a>
                                    <a href="{{ route('second', ['extended', 'scrollspy']) }}" class="dropdown-item">Scrollspy</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-forms" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Forms <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-forms">
                                    <a href="{{ route('second', ['forms', 'elements']) }}" class="dropdown-item">Basic Elements</a>
                                    <a href="{{ route('second', ['forms', 'advanced']) }}" class="dropdown-item">Form Advanced</a>
                                    <a href="{{ route('second', ['forms', 'validation']) }}" class="dropdown-item">Validation</a>
                                    <a href="{{ route('second', ['forms', 'wizard']) }}" class="dropdown-item">Wizard</a>
                                    <a href="{{ route('second', ['forms', 'fileuploads']) }}" class="dropdown-item">File Uploads</a>
                                    <a href="{{ route('second', ['forms', 'editors']) }}" class="dropdown-item">Editors</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Charts <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                    <a href="{{ route('second', ['charts', 'chartjs-area']) }}" class="dropdown-item">Chartjs</a>
                                    <a href="{{ route('second', ['charts', 'apex-line']) }}" class="dropdown-item">Apex Charts</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-tables" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tables <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tables">
                                    <a href="{{ route('second', ['tables', 'basic']) }}" class="dropdown-item">Basic Tables</a>
                                    <a href="{{ route('second', ['tables', 'datatable']) }}" class="dropdown-item">Data Tables</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Icons <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                    <a href="{{ route('second', ['icons', 'remixicons']) }}" class="dropdown-item">Remix Icons</a>
                                    <a href="{{ route('second', ['icons', 'bootstrapicons']) }}" class="dropdown-item">Bootstrap Icons</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-maps" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Maps <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-maps">
                                    <a href="{{ route('second', ['maps', 'google']) }}" class="dropdown-item">Google Maps</a>
                                    <a href="{{ route('second', ['maps', 'vector']) }}" class="dropdown-item">Vector Maps</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-layout-line"></i>Layouts <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                            <a href="{{ route('second', ['layouts-eg', 'horizontal']) }}" class="dropdown-item" target="_blank">Horizontal</a>
                            <a href="{{ route('second', ['layouts-eg', 'detached']) }}" class="dropdown-item" target="_blank">Detached</a>
                            <a href="{{ route('second', ['layouts-eg', 'full-view']) }}" class="dropdown-item" target="_blank">Full</a>
                            <a href="{{ route('second', ['layouts-eg', 'fullscreen-view']) }}" class="dropdown-item" target="_blank">Fullscreen</a>
                            <a href="{{ route('second', ['layouts-eg', 'hover-menu']) }}" class="dropdown-item" target="_blank">Hover Menu</a>
                            <a href="{{ route('second', ['layouts-eg', 'compact']) }}" class="dropdown-item" target="_blank">Compact Menu</a>
                            <a href="{{ route('second', ['layouts-eg', 'icon-view']) }}" class="dropdown-item" target="_blank">Icon View</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ========== Horizontal Menu End ========== -->
