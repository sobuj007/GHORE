<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="#" target="_blank" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('backend') }}/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('backend') }}/assets/images/logo-dark.png" alt="" height="22">
                        </span>
                    </a>

                    <a href="#" target="_blank" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('backend') }}/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('backend') }}/assets/images/logo-light.png" alt=""
                                height="22">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-light rounded-circle user-name-text mode-layout"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-sun align-middle fs-3xl"></i>
                    </button>
                    <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                        <a href="#!" class="dropdown-item" data-mode="light"><i
                                class="bi bi-sun align-middle me-2"></i> Default (light mode)</a>
                        <a href="#!" class="dropdown-item" data-mode="dark"><i
                                class="bi bi-moon align-middle me-2"></i> Dark</a>
                        <a href="#!" class="dropdown-item" data-mode="auto"><i
                                class="bi bi-moon-stars align-middle me-2"></i> Auto (system default)</a>
                    </div>
                </div>



                <div class="dropdown ms-sm-3 topbar-head-dropdown dropdown-hover-end header-item topbar-user">
                    <button type="button" class="btn shadow-none btn-icon" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('backend') }}/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Alexandra!</h6>

                        <a class="dropdown-item fs-sm" href="pages-profile-settings.html"><i
                                class="bi bi-gear text-muted align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>

                        <a href="javascript:void(0)" type="submit" class="dropdown-item fs-sm"><i
                                class="bi bi-box-arrow-right text-muted align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout"
                                onclick="logout({{ auth()->user()->id }})">Logout</span></a>

                        <form id="logout-form-{{ auth()->user()->id }}" action="{{ route('logout') }}" method="POST"
                            style="display: none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    function logout(id) {
        Swal.fire({
            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Oops...!</h4><p class="text-muted mx-4 mb-0">Are you want to logout?</p></div></div>',
            showCancelButton: !0,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mb-1',
                cancelButton: 'btn btn-danger w-xs mb-1'
            },
            confirmButtonText: "Yes, Logout!",
            buttonsStyling: !1,
            showCloseButton: false,
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('logout-form-' + id).submit();
            }
        })
    }
</script>
