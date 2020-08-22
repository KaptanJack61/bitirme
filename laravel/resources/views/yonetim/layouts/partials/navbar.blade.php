<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('yonetim.anasayfa') }}" class="nav-link">Anasayfa</a>
      </li>
      @if (Auth::guard('yonetim')->user()->admin)
            <!--
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('trying.index') }}" class="nav-link">Deneme Alanı</a>
            </li>
            -->
      @endif
    </ul>

    <!-- SEARCH FORM -->
        <form class="form-inline ml-5" method="get" action="{{ route('search.search') }}">
            {{ csrf_field() }}
            <div class="input-group input-group-sm ml-2">
                <select name="type" id="navbar-select" class="form-control form-control-navbar">
                    <option value="0" selected>Referans seçiniz?</option>
                    <option value="7">Ad Soyad</option>
                    <option value="1">Telefon Numarası</option>
                    <option value="2">Talep Numarası</option>
                    <option value="3">Yapılan Yardım Numarası</option>
                    <option value="4">T.C. Kimlik No</option>
                    <option value="5">Mahalle</option>
                    <option value="6">Cadde & Sokak</option>
                </select>
            </div>
            <div id="navbar-neighborhoods" class="input-group input-group-sm ml-2" style="display: none;width: 250px">
                <select name="neighborhood" id="navbar-select" class="form-control form-control-navbar">
                    <option value="0" selected>Mahalle Seçiniz</option>
                    @foreach($neighborhoods as $n)
                        <option value="{{ $n->id }}">{{ $n->name }} Mah.</option>
                    @endforeach
                </select>
            </div>
           <div class="input-group input-group-sm ml-1" id="navbar-search-div" style="width: 250px">
              <input id="navbar-search" class="form-control form-control-navbar" type="search" placeholder="Ara..." aria-label="Ara" name="search" disabled>
           </div>
            <div class="input-group input-group-sm ml-1">
                <div class="input-group-append">
                    <button class="btn btn-navbar ml-1" type="submit" id="navbar-submit" disabled>
                        <i class="fa fa-search"> </i> Ara
                    </button>
                </div>
            </div>

        </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <div class="image" style="margin-top: -8px">
            <img src="{{ Auth::guard('yonetim')->user()->photo }}" width="40px" height="40px" class="img-circle elevation-2" alt="User Image">
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-xg dropdown-menu-right">

          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#change-password">
            <!-- Message Start -->
            <div class="media">
              <i class="fa fa-user"></i>
              <div class="media-body">
                <h3 class="dropdown-item-title" style="margin-left:5px; margin-top: -2px;">
                    Şifre Değiştir
                    </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('yonetim.oturumukapat') }}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <i class="fa fa-sign-out-alt"></i>
              <div class="media-body">
                <h3 class="dropdown-item-title" style="margin-left:5px; margin-top: -2px;">
                   Çıkış Yap
                </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->