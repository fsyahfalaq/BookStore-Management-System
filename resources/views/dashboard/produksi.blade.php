@extends('dashboard.dashboard')

@section('content')

<h2 my-2>Produksi</h2>

@if(\Session::has('alert'))
<br>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <div>{{Session::get('alert')}}</div>
</div>
@endif
@if(\Session::has('alert-success'))
<br>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <div>{{Session::get('alert-success')}}</div>
</div>
@endif

<div class="container">
    <form method="post" id="data-form">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">

            <div class="col">
                <div class="form-group">
                    <label>Kode Buku : </label>
                    <input name="kodeBuku" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Nama Buku   : </label>
                    <input name="namaBuku" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Jumlah Buku   : </label>
                    <input name="jumlahBuku" type="text" class="form-control"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Berat Buku   : </label>
                    <input name="beratBuku" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Harga Beli   : </label>
                    <input type="text" class="form-control" id="dengan-rupiah"/>
                    <input name="hargaBeli" type="hidden" class="form-control" id="tanparupiah"/>
                </div>
                <div class="form-group">
                    <label>Harga Jual  : </label>
                    <input type="text" class="form-control" id="dengan-rupiah"/>
                    <input name="hargaJual" type="hidden" class="form-control" id="tanparupiah"/>
                </div>
                <div class="form-group">
                    <label>Tanggal Keluar   : </label>
                    <input type="date" class="form-control" id="dengan-rupiah"/>
                </div>
            </div>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Submit" id="submit">    
            </div>
    </form>
    

    <div class="container">
        <table class="table table-striped table-bordered datatable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>no_transaksi</th>
                    <th>tanggal</th>
                    <th>ref</th>
                    <th>uraian</th>
                    <th>debit</th>
                    <th>kredit</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
  $(document).ready(function() {

    // DataTable
    $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('datauser') }}',
        columns: [
            {data: 'id', name: 'id', visible: false},
            {data: 'no_transaksi', name: 'no_transaksi'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'referensi', name: 'referensi'},
            {data: 'uraian', name: 'uraian'},
            {data: 'debit', name: 'debit'},
            {data: 'kredit', name: 'kredit'},
        ],
    });
});
</script>

<!-- ajax add -->
<script>
    
    $(function() {
      $('#data-form').on('submit', function(e) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        var data = new FormData(document.getElementById("data-form"));
        $.ajax({
                url: 'dashboard/jurnal',
                method: "POST",
                data: new FormData(document.getElementById("data-form")),
                contentType: false,
                processData: false,
                success: function(response) {
                  console.log(response);
                  $('.datatable').DataTable().ajax.reload(null, false);
                //   $('#data-modal').modal('hide');
                //   $("#product-table").DataTable().ajax.reload();
                },
                error: function (request, status, error) {
                    console.log(request.responseJSON);
                    $.each(request.responseJSON.errors, function( index, value ) {
                            alert( value );
                    });
                }
            }
            });
        });
    });

</script>


<!-- Input Rupiah -->
<script>
/* Dengan Rupiah */
    const dengan_rupiah = document.getElementById('dengan-rupiah');
    const tanparupiah = document.getElementById('tanparupiah');
    
    dengan_rupiah.addEventListener('keyup', function(e)
    {   
        tanparupiah.value = dengan_rupiah.value.split('.').join("");
        // dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        dengan_rupiah.value = formatRupiah(this.value);
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split  = number_string.split(','),
            sisa   = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
<!-- Input rupiah end -->
@endsection