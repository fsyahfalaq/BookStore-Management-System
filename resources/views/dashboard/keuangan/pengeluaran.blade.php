@extends('dashboard.dashboard')

@section('content')

<style>
    .hide {
        display: none !important;
    }
</style>

<h2 my-2>Pengeluaran</h2>

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
                    <label>Tanggal   : </label>
                    <input name="tanggal" type="date" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Jenis Pengeluaran : </label>
                    <select onchange="jenisPengeluaran()" name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control" id="jenis_pengeluaran">
                        <option value='piutang'>Piutang</option>
                        <option value='pembayaran_gaji'>Pembayaran Gaji</option>
                        <option value='pembelian_peralatan'>Pembelian peralatan</option>
                        <option value='pembelian_perlengkapan'>Pembelian perlengkapan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Uraian   : </label>
                    <input name="uraian" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran   : </label>
                    <select onchange="showAdditonalTransaction()" name="metode_pembayaran"class="custom-select mr-sm-2" id="metode_pembayaran">
                        <option value="0"></option>
                        <option value="1">Tunai</option>
                        <option value="2">Hutang</option>
                        <option value="3">Piutang</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>No. Transaksi   : </label>
                    <input name="no_transaksi" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Sejumlah   : </label>
                    <input type="text" class="form-control" id="dengan-rupiah"/>
                    <input name="sejumlah" type="hidden" class="form-control" id="tanparupiah"/>
                </div>
                <div class="form-group hide" id="DP">
                    <label>DP   : </label>
                    <!-- bug -->
                    <input name="DP" type="text" class="form-control" id="dengan-rupiah"/>
                    <!-- <input name="DP" type="hidden" class="form-control" id="tanparupiah"/> -->
                </div>
                <div class="form-group hide" id="terbayar">
                    <label>Terbayar   : </label>
                    <!-- bug -->
                    <input name="terbayar" type="text" class="form-control" id="dengan-rupiah"/>
                    <!-- <input name="terbayar" type="hidden" class="form-control" id="tanparupiah"/> -->
                </div>
            </div>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Submit" id="submit">    
            </div>
            <!-- <div class="col-md-4">
                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
            </div>
            <div class="col-md-4">
                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
            </div> -->
            <!-- <div class="form-group">
                <label>Minimum Date:</label>
                <input name="min" id="min" type="text" class="form-control" style="width:40%">

                <label>Maximum Date:</label>
                <input name="max" id="max" type="text" class="form-control" style="width:40%">
            </div> -->
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
    // $('.input-daterange').datepicker({
    //     todayBtn:'linked',
    //     format:'yyyy-mm-dd',
    //     autoclose:true
    // });
    
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
            {data: 'debit', name: 'debit', render: $.fn.dataTable.render.number( ',', '.', 2 )},
            {data: 'kredit', name: 'kredit', render: $.fn.dataTable.render.number( ',', '.', 2 )},
        ],
        order: [[ 2, "desc" ]],
    });
    // $('#min').keyup( function() { table.draw(); } );
    // $('#max').keyup( function() { table.draw(); } );
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
                url: 'jurnal',
                type: 'POST',       
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

$('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#order_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 </script>

<!-- Merubah bentuk input sejumlah dalam kedalam bentuk rupiah -->
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

<script>


// <input type="text" class="form-control" id="dengan-rupiah"/>
//                     <input name="sejumlah" type="hidden" class="form-control" id="tanparupiah"/>

function jenisPengeluaran() {
    const jenis_pengeluaran = document.getElementById('jenis_pengeluaran');
    const sejumlah = document.getElementById('dengan-rupiah');
    const sejumlahHide = document.getElementById("tanparupiah")

    if(jenis_pengeluaran.value === 'pembayaran_gaji'){
        sejumlah.value = "{{ $gaji }}"
        sejumlahHide.value = "{{ $gaji }}"
    }
}

function showAdditonalTransaction() {
    const metode_pembayaran = document.getElementById('metode_pembayaran');
    const DP = document.getElementById('DP');
    const terbayar = document.getElementById('terbayar');

    
    switch (metode_pembayaran.value) {
        case '2':
            terbayar.classList.add('hide')
            DP.classList.remove('hide')    
            break;
        case '3':
            DP.classList.add('hide')
            terbayar.classList.remove('hide')
        default:
            // terbayar.classList.add('hide')
            break;
    }
    // if (metode_pembayaran.value == 2) {
    //     DP.classList.remove('hide')
    // } else idelse {
    //     DP.classList.add('hide')
    // }
}
    

</script>
<!-- Input rupiah end -->

@endsection