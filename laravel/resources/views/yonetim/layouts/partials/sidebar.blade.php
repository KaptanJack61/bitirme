<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('yonetim.anasayfa') }}" class="brand-link text-center">

        <span class="brand-text font-weight-light">Sosyal Yardım<br />Takip Sistemi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::guard('yonetim')->user()->photo }}" class="img-circle elevation-2" alt="User Image" style="width: 36px; height: 36px">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::guard('yonetim')->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link">

              <i class="fa fa-fighter-jet nav-icon"></i>
              <p>
                Hızlı İşlemler
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                      <a href="{{route('yardimtalebi.storeIndex')}}" class="nav-link">
                  <i class="fa fa-plus nav-icon" style="color: #00c0ef;"></i>
                  <p>Yardım Talebi Ekle</p>
                </a>
              </li>

                @if (Auth::guard('yonetim')->user()->admin)
                    <li class="nav-item">
                        <a href="{{route('raporlar.gunluk')}}" class="nav-link">
                            <i class="fa fa-flag-checkered nav-icon" style="color: #00c0ef;"></i>
                            <p>Günlük Rapor Al</p>
                        </a>
                @endif
                </li>
            </ul>
          </li>
            @if (Auth::guard('yonetim')->user()->admin)
                @if(Session::get('menu_acilma')=='kullanicilar')
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                @else
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            @endif
              <i class="nav-icon fa fa-user"></i>
              <p>
                Kullanıcı Yönetimi
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  @if(Session::get('menu_aktif')=='kullanicilar')
                      <a href="{{route('yonetim.kullanicilar')}}" class="nav-link active">
                          @else
                              <a href="{{route('yonetim.kullanicilar')}}" class="nav-link">
                                  @endif

                  <i class="fa fa-users nav-icon"></i>
                  <p>Kullanıcılar</p>
                </a>
              </li>
            </ul>
          </li>
         @endif

                    @if(Session::get('menu_acilma')=='yardim-masasi')
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link active">
                    @else
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                @endif
                                <i class="nav-icon fa fa-hands-helping"></i>
                                <p>
                                    Yardım Masası
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='yapilan-yardimlar')
                                        <a href="{{route('yapilanyardimlar.index')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('yapilanyardimlar.index')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-info nav-icon"></i>
                                                    <p>Yapılan Yardımlar</p>
                                                </a>
                                </li>

                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='tamamlanmayan-yardimlar')
                                        <a href="{{route('yapilanyardimlar.notCompletedHelps')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('yapilanyardimlar.notCompletedHelps')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-info nav-icon"></i>
                                                    <p>Tamamlanmayan Yardımlar</p>
                                                </a>
                                </li>

                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='yardim-talepleri')
                                        <a href="{{route('yardimtalepleri.demands')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('yardimtalepleri.demands')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-hand-paper nav-icon"></i>
                                                    <p>
                                                        Gelen Talepler
                                                    </p>
                                                </a>
                                </li>

                                @if (Auth::guard('yonetim')->user()->admin)

                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='yardim-turleri')
                                        <a href="{{route('yardimturleri.index')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('yardimturleri.index')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-gift nav-icon"></i>
                                                    <p>Yardım Türleri</p>
                                                </a>
                                </li>
                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='durumlar')
                                        <a href="{{route('statuses.index')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('statuses.index')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-signal nav-icon"></i>
                                                    <p>Durum Bilgileri</p>
                                                </a>
                                </li>
                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='raporlar')
                                        <a href="{{route('raporlar.index')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('raporlar.index')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-flag-checkered nav-icon"></i>
                                                    <p>Raporlar</p>
                                                </a>
                                </li>

                                    <li class="nav-item">
                                        @if(Session::get('menu_aktif')=='istatistik')
                                            <a href="{{route('statistic.index')}}" class="nav-link active">
                                                @else
                                                    <a href="{{route('statistic.index')}}" class="nav-link">
                                                        @endif

                                                        <i class="fa fa-chart-pie nav-icon"></i>
                                                        <p>İstatistikler</p>
                                                    </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    @if(Session::get('menu_aktif')=='eskiyardimtalepleri')
                                        <a href="{{route('eskiyardimtalepleri.index')}}" class="nav-link active">
                                            @else
                                                <a href="{{route('eskiyardimtalepleri.index')}}" class="nav-link">
                                                    @endif

                                                    <i class="fa fa-object-ungroup nav-icon"></i>
                                                    <p>Eski Yardım Talebi Girişi</p>
                                                </a>
                                </li>
                            </ul>
                        </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
