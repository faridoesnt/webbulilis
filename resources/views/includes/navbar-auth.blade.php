<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down"
    >
    <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand">
        <h4>
            <strong>Seeowrens</strong>
        </h4>
    </a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">HOME</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('info-bidang-lain-teknik-arsitek') }}" class="nav-link">INFO BIDANG LAIN</a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('categories') }}" class="nav-link"><strong>KATEGORI</strong></a>
        </li> --}}
        </ul>
    </div>
    </div>
</nav>
