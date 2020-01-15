@extends('dashboard.dashboard')

@section('content')

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Rugi Laba</h6>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase ">Pendapatan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">{{ $pendapatan }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">Beban</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Perlengkapan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_perlengkapan }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Gaji</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_gaji }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Sewa</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_sewa }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Listrik</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_listrik }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Telepon</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_telepon }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Air</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_air }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Beban Penyusutan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $beban_penyusutan }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">Laba</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">{{ $laba }}</div>
            </div>
            <!-- <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <!-- Laporan -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Aktiva</h6>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase ">Aktiva Lancar</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Kas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $laporan_kas }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Piutang</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $laporan_piutang }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Perlengkapan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $laporan_perlengkapan }}</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Sewa Bayar dimuka</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $laporan_sewa }}</div>
            </div>
            <!-- <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <!-- Laporan -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Pasiva</h6>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase ">Hutang</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Hutang dagang</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase ">Modal</div>
              <div class="text-xs font-weight-bold text-primary text-uppercase">&nbsp Modal</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1">&nbsp{{ $laporan_modal }}</div>
            </div>
            <!-- <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <div class="dropdown-header">Dropdown Header:</div>
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
          </div>
        </div>
      </div>
</div>

      <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

    <script src="/js/demo/chart-area-demo.js"></script>            
@endsection