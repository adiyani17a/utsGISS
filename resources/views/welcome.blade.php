<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}" />
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <style type="text/css">
        #map{
            width: 100%;
            height: 100%;
            display: block !important;
        }
        #floating-panel {
            position: absolute;
            top: 20px;
            left: 30%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }
        .error{
            border: 1px solid red;
        }
    </style>
    <body onload="initMap()"  style="background-color: grey !important">
        <div class="container"  style="background-color: white !important">
            <div class="row">
                <div class="col-md-12 row" style="margin-top: 20px;margin-bottom: 20px;">
                    <div id="floating-panel">
                        <input onclick="deleteMarkers();" type=button value="Delete Markers">
                    </div>
                    <div class="col-md-6" style="height: 800px;">
                        <div id="map"  >
                            
                        </div>
                    </div>

                    <form class="col-md-6 data">
                        <div class="form-group">
                            <label>Nama Kabupaten</label> 
                            <input type="text" class="form-control wajib nama_kabupaten" name="nama_kabupaten">
                            <input type="hidden" class="form-control" name="id">
                        </div>
                        <div class="form-group">
                            <label>Nama Bupati</label>
                            <input type="text" class="form-control wajib nama_bupati" name="nama_bupati">
                        </div>
                        <div class="form-group">
                            <label>Jumlah Penduduk</label>
                            <input type="text" class="form-control wajib jumlah_penduduk hanya_angka" name="jumlah_penduduk">
                        </div>
                        <div class="form-group">
                            <label>Jumlah UKM</label>
                            <input type="text" class="form-control wajib jumlah_ukm hanya_angka" name="jumlah_ukm">
                        </div>
                        <div class="form-group">
                            <label>Pusat Kota</label>
                            <div class="input-group">
                                <input type="text" class="form-control pusat_kota_latitude" placeholder="latitude" name="pusat_kota_latitude">
                                <button type="button" class="btn btn-info" onclick="tambah('pusat_kota')">Tambah</button>
                                <input type="text" class="form-control pusat_kota_longitude" placeholder="longitude" name="pusat_kota_longitude">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pusat UKM</label>
                            <div class="input-group">
                                <input type="text" class="form-control pusat_ukm_latitude" placeholder="latitude" name="pusat_ukm_latitude">
                                <button type="button" class="btn btn-info" onclick="tambah('pusat_ukm')">Tambah</button>
                                <input type="text" class="form-control pusat_ukm_longitude" placeholder="longitude" name="pusat_ukm_longitude">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Wilayah</label>
                            <div class="input-group">
                                <button style="width: 100%" type="button" class="btn btn-info wilayah" onclick="tambah('wilayah')">Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Luas Area</label>
                            <input type="text" readonly="" class="form-control wajib luas_area hanya_angka" name="luas_area">
                        </div>
                        <div class="form-group">
                            <label>Keliling</label>
                            <input type="text" readonly="" class="form-control wajib keliling hanya_angka" name="keliling">
                        </div>
                        <div class="formn-group d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="simpan()">SIMPAN</button>
                            <button type="button" class="btn btn-success load">LOAD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- MODAL --}}
        <div class="modal modal_load fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kabupaten</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body append">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </body>


    


    <script type="text/javascript" src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN-wAEXTDSapaZNWVefhDtUUA7ieogmMk&callback=initMap&libraries=drawing"
    async defer></script>
    <script type="text/javascript">
        var map;
        var pusat_kota;
        var pusat_ukm;
        var drawingManager;
        var wilayah = [];
        var wilayah_array = [];
        var drawingReady = '0';

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: -7.327971, lng: 112.791869},
              zoom: 10
            });
        }

        function deleteMarkers() {
            pusat_kota.setMap(null);
            pusat_ukm.setMap(null);
        } 

        function tambah(mode) {
            if (mode == 'pusat_kota') {
                if (pusat_kota != undefined) {
                    pusat_kota.setMap(null);
                    $('.pusat_kota_latitude').val('');
                    $('.pusat_kota_longitude').val('');
                }
                if (drawingManager != undefined) {
                    drawingManager.setMap(null);
                }
                google.maps.event.addListenerOnce(map, 'click', function(event) {
                  
                  pusat_kota = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                  });

                  $('.pusat_kota_latitude').val(pusat_kota.position.lat);
                  $('.pusat_kota_longitude').val(pusat_kota.position.lng);
                });
                
                alert('Marker Pusat Kota Berhasil Diinisialisasi');
                
            }else if (mode == 'pusat_ukm'){

                if (pusat_ukm != undefined) {
                    pusat_ukm.setMap(null);
                    $('.pusat_ukm_latitude').val('');
                   $('.pusat_ukm_longitude').val('');
                }
                if (drawingManager != undefined) {
                    drawingManager.setMap(null);
                }
                google.maps.event.addListenerOnce(map, 'click', function(event) {
                  pusat_ukm = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    draggable: true

                  });

                  $('.pusat_ukm_latitude').val(pusat_ukm.position.lat);
                  $('.pusat_ukm_longitude').val(pusat_ukm.position.lng);
                });
                
                alert('Marker Pusat UKM Berhasil Diinisialisasi');
                
            }else{
                if (drawingReady == '0') {
                    drawingReady = '1';

                    if (wilayah[0] != null) {
                        for (var i = 0; i < wilayah.length; i++) {
                            wilayah[i].setMap(null);
                        }
                        wilayah = [];
                    }

                    var drawingManager = new google.maps.drawing.DrawingManager({
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: ['polygon']
                        },
                        markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
                        circleOptions: {
                            fillColor: '#ffff00',
                            fillOpacity: 1,
                            strokeWeight: 5,
                            clickable: false,
                            editable: true,
                            zIndex: 1
                        }
                    });
                    drawingManager.setMap(map);
                    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

                    google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
                        var newShape = event.overlay;
                        newShape.type = event.type;
                        wilayah.push(newShape);
                        if (drawingManager.getDrawingMode()) {
                            drawingManager.setDrawingMode(null);
                        }
                        drawingManager.setMap(null);
                        drawingReady = '0';
                        var path = wilayah[0].getPath();
                        var measurement = google.maps.geometry.spherical.computeArea(path);
                        var keliling = google.maps.geometry.spherical.computeLength(path);
                        $('.luas_area').val(Math.round(measurement) +' M2');
                        $('.keliling').val(Math.round(length) +' M');
                        for (var i = 0; i < path.length; i++) {
                          wilayah_array.push({
                            lat: path.getAt(i).lat(),
                            lng: path.getAt(i).lng()
                          });
                        }

                    });
                    $('.luas_area').val('');
                    $('.keliling').val('');
                    alert('Wilayah Telah Diinisialisasi');
                }else{
                    alert('Wilayah Sudah Diinisialisasi');
                }
            }
        }

        $(document).on('keypress','.hanya_angka',function (e) {
         //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                //display error message
                return false;
            }
        });

        function clearSelection() {
            if (selectedShape) {
              selectedShape.setEditable(false);
              selectedShape = null;
            }
        }

        function setSelection(shape) {
            clearSelection();
            selectedShape = shape;
            shape.setEditable(true);
            selectColor(shape.get('fillColor') || shape.get('strokeColor'));
        }

        function deleteSelectedShape() {
            if (selectedShape) {
              selectedShape.setMap(null);
            }   
        }


        $('.wajib').focus(function(){
            $(this).removeClass('error');
        })
        
        function simpan() {
            var validator        = [];
            $('.wajib').each(function(){
                if ($(this).val() == '') {
                  $(this).addClass('error');
                  validator.push(0);
                }
            })

            var index = validator.indexOf(0);
            if (index != -1) {
                alert('Data Input Harus Diisi')
                return false;
            }

            $.ajax({
                type: "get",  
                url: '{{ url('save_wilayah') }}?'+$('.data :input').serialize(),
                data:{wilayah:wilayah_array},
                dataType:'json',
                success: function(data){
                    
                    alert('Berhasil Menyimpan Data');
                    location.reload();
                },
                error: function(){
                    alert('Terjadi Kesalahan');
                   
                },
            });
        }

        function hapus(id) {
            $.ajax({
                type: "get",  
                url: '{{ url('hapus_wilayah') }}',
                data:{id},
                dataType:'json',
                success: function(data){
                    
                    alert('Berhasil Menghapus Data');
                    location.href = '{{ url('/') }}'
                },
                error: function(){
                    alert('Terjadi Kesalahan');
                   
                },
            });
        }

        $('.load').click(function(){
            $.ajax({
                type: "get",  
                url: '{{ url('show_wilayah') }}',
                data:{wilayah:wilayah_array},
                success: function(data){
                    $('.modal_load').modal('show');
                    $('.append').html(data);
                }
            });
        });

        function loadData(id) {
            location.href = '{{ url('load_wilayah') }}?id='+id;
        }
    </script>

</html>