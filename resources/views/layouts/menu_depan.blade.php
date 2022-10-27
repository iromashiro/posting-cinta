<nav class="primary-menu with-arrows">

    <ul class="menu-container">
        <li class="menu-item current"><a class="menu-link" href="{{ route('index') }}">
                <div>Home</div>
            </a></li>

        <li class="menu-item mega-menu">
            <div class="menu-link">
                <div>Profil</div>
            </div>
            <div class="mega-menu-content mega-menu-style-2 px-0">
                <div class="container">
                    <div class="row">
                        @foreach ($profil as $p)
                        <a href="{{route('profil', $p->slug)}}"
                            class="mega-menu-column sub-menu-container col-lg-3 border-bottom h-bg-light py-4">
                            <div class="feature-box">
                                <div class="fbox-content">
                                    <h3 class="nott ls0">{{$p->nama_menu}}</h3>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </li>
        <li class="menu-item mega-menu">
            <div class="menu-link">
                <div>Data dan Informasi</div>
            </div>
            <div class="mega-menu-content mega-menu-style-2 px-0">
                <div class="container">
                    <div class="row">
                        <a href="{{ route('index_pmbg.guest') }}"
                            class="mega-menu-column sub-menu-container col-lg-3 border-bottom h-bg-light py-4">
                            <div class="feature-box">
                                <div class="fbox-content">
                                    <h3 class="nott ls0">Pembangunan Manusia Berbasis
                                        Gender</h3>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('index_pai.guest') }}"
                            class="mega-menu-column sub-menu-container col-lg-3 border-bottom h-bg-light py-4">
                            <div class="feature-box">
                                <div class="fbox-content">
                                    <h3 class="nott ls0">Profile Anak Indonesia</h3>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('index_ppi.guest') }}"
                            class="mega-menu-column sub-menu-container col-lg-3 border-bottom h-bg-light py-4">
                            <div class="feature-box">
                                <div class="fbox-content">
                                    <h3 class="nott ls0">Profile Perempuan Indonesia</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </li>

        <li class="menu-item"><a class="menu-link" href="{{ route('index_berita.guest') }}">
                <div>Berita</div>
            </a></li>
        <li class="menu-item"><a class="menu-link" href="{{ route('index_berita.guest') }}">
                <div>Galeri</div>
            </a></li>
    </ul>

</nav><!-- #primary-menu end -->
