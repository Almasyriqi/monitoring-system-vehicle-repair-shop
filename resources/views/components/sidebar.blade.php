<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="
        {{-- {{ route('home') }} --}}
        ">
            <img alt="Logo" src="{{ asset('assets/images/logo-text.webp') }}" class="h-50px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/images/logo-repair.webp') }}"
                class="h-30px app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                {{-- Dashboard --}}
                <div class="menu-item">
                    <a href="{{route('home')}}" class="menu-link {{ Route::is('home') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.49935 1.66699H8.33268C8.83268 1.66699 9.16602 2.00033 9.16602 2.50033V8.33366C9.16602 8.83366 8.83268 9.16699 8.33268 9.16699H2.49935C1.99935 9.16699 1.66602 8.83366 1.66602 8.33366V2.50033C1.66602 2.00033 1.99935 1.66699 2.49935 1.66699Z"
                                        fill="#A1A5B7" />
                                    <path
                                        d="M11.6673 1.66699H17.5007C18.0007 1.66699 18.334 2.00033 18.334 2.50033V8.33366C18.334 8.83366 18.0007 9.16699 17.5007 9.16699H11.6673C11.1673 9.16699 10.834 8.83366 10.834 8.33366V2.50033C10.834 2.00033 11.1673 1.66699 11.6673 1.66699Z"
                                        fill="#E3E4EA" />
                                    <path
                                        d="M2.49935 10.833H8.33268C8.83268 10.833 9.16602 11.1663 9.16602 11.6663V17.4997C9.16602 17.9997 8.83268 18.333 8.33268 18.333H2.49935C1.99935 18.333 1.66602 17.9997 1.66602 17.4997V11.6663C1.66602 11.1663 1.99935 10.833 2.49935 10.833Z"
                                        fill="#E3E4EA" />
                                    <path
                                        d="M11.6673 10.833H17.5007C18.0007 10.833 18.334 11.1663 18.334 11.6663V17.4997C18.334 17.9997 18.0007 18.333 17.5007 18.333H11.6673C11.1673 18.333 10.834 17.9997 10.834 17.4997V11.6663C10.834 11.1663 11.1673 10.833 11.6673 10.833Z"
                                        fill="#E3E4EA" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <hr>

                {{-- Data Management --}}
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('customer.*') ? 'active' : '' }}" href="
                                    {{ route('customer.index') }}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.23851 12.5717C6.12035 10.9845 7.79346 10 9.60927 10H10.3919C12.2078 10 13.8809 10.9845 14.7627 12.5717L16.125 15.0239C16.7422 16.1348 15.9389 17.5 14.6681 17.5H5.33313C4.06232 17.5 3.25904 16.1348 3.8762 15.0239L5.23851 12.5717Z"
                                        fill="#A1A5B7" />
                                    <path
                                        d="M13.3346 5.83333C13.3346 3.99238 11.8423 2.5 10.0013 2.5C8.16035 2.5 6.66797 3.99238 6.66797 5.83333C6.66797 7.67428 8.16035 9.16667 10.0013 9.16667C11.8423 9.16667 13.3346 7.67428 13.3346 5.83333Z"
                                        fill="#E3E4EA" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Customer Data</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('mechanic.*') ? 'active' : '' }}" href="
                                    {{ route('mechanic.index') }}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-person-gear" viewBox="0 0 16 16">
                                    <path
                                        d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Mechanic Data</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('part.*') ? 'active' : '' }}" href="
                                    {{-- {{ route('jurusan.index') }} --}}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                                    <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
                                  </svg>
                            </span>
                        </span>
                        <span class="menu-title">Spare Parts Data</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('repair.*') ? 'active' : '' }}" href="
                                    {{-- {{ route('jurusan.index') }} --}}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                                    <path d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61"/>
                                    <path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9m-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376M3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                                  </svg>
                            </span>
                        </span>
                        <span class="menu-title">Repair Data</span>
                    </a>
                </div>
                <hr>
            </div>
        </div>
    </div>
    {{-- <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <form action="
        {{ route('logout') }}
        " method="POST" id="logout-form">
            @csrf
            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-flex flex-center btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
                <span class="btn-label">Logout</span> &nbsp;
                <span class="svg-icon btn-icon svg-icon-2 m-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 12h-9.5m7.5 3l3-3l-3-3m-5-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2v-1" />
                    </svg>
                </span>
            </a>
        </form>
    </div> --}}
</div>