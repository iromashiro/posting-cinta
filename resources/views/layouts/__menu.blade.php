<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
                <img src="{{URL::asset('adm_dinsos/img/brand/blue.png')}}" class="navbar-brand-img" alt="...">
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil.index') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Home</span>
                        </a>
                    </li>

                    <!-- PROFIL -->
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-dashboards" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-badge text-primary"></i>
                            <span class="nav-link-text">Menu</span>
                        </a>
                        <div class="collapse" id="navbar-dashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('profil.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> P </span>
                                        <span class="sidenav-normal"> Profil </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <span class="sidenav-mini-icon"> D </span>
                                        <span class="sidenav-normal"> Data dan Informasi </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- PROFIL -->

                    <!-- BERITA -->
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-dashboard" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-map-big text-primary"></i>
                            <span class="nav-link-text">Informasi</span>
                        </a>
                        <div class="collapse" id="navbar-dashboard">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('berita.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> B </span>
                                        <span class="sidenav-normal"> Berita </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengumuman.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> P </span>
                                        <span class="sidenav-normal"> Pengumuman </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('galeri.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> G </span>
                                        <span class="sidenav-normal"> Galeri</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- BERITA -->

                    <li class="nav-item">
                        <a class="nav-link" href="#datainformasi" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-map-big text-primary"></i>
                            <span class="nav-link-text">Data dan Informasi</span>
                        </a>
                        <div class="collapse" id="datainformasi">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('pmbg.index') }}" class="nav-link">
                                        <span class="sidenav-normal">Pemb. Berbasis Gender </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pai.index') }}" class="nav-link">
                                        <span class="sidenav-normal"> Profil Anak Indonesia</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ppi.index') }}" class="nav-link">
                                        <span class="sidenav-normal"> Profile Perempuan Indonesia</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- LOGOUT -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/logout" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="ni ni-button-power text-red"></i>
                            <span class="nav-link-text">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
