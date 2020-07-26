@include('yonetim.kullanicilar.modal')

@include('sweetalert::alert')

<footer class="main-footer fixed-bottom">
    <strong>Copyright &copy; 2020 <a href="http://kptn.xyz" target="_blank"><b>Sosyal Yardım Takip Sistemi</b></a>.</strong>
    Tüm hakları Saklıdır.
    <div class="float-right d-none d-sm-inline-block">
      <b>Sürüm: </b> {{ config('app.version') }}
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
