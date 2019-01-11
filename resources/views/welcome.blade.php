<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" />
        <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('node_modules/jsts-master/lib/javascript.util.js') }}"></script>
        <script src="{{ asset('node_modules/jsts-master/lib/jsts.js') }}"></script>
        <script src="{{ asset('node_modules/jsts-master/lib/attache.array.min.js') }}"></script>
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
                        <div class="formn-group d-flex justify-content-between" style="margin-top: 20px;">
                            <button type="button" class="btn btn-primary" onclick="act('intersect')">INTERSECT</button>
                            <button type="button" class="btn btn-success" onclick="act('union')">UNION</button>
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
                            <label>Jumlah Penduduk Miskin</label>
                            <input type="text" class="form-control wajib jumlah_penduduk_miskin hanya_angka" name="jumlah_penduduk_miskin">
                        </div>
                        <div class="form-group">
                            <label>Index Korupsi</label>
                            <input type="text" class="form-control wajib index_korupsi hanya_angka" name="index_korupsi">
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
                            <label>Marker 3</label>
                            <div class="input-group">
                                <input type="text" class="form-control marker3_latitude" placeholder="latitude" name="marker3_latitude">
                                <button type="button" class="btn btn-info" onclick="tambah('marker3')">Tambah</button>
                                <input type="text" class="form-control marker3_longitude" placeholder="longitude" name="marker3_longitude">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Wilayah 1</label>
                            <div class="input-group">
                                <button style="width: 100%" type="button" class="btn btn-info wilayah" onclick="tambah('wilayah')">Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Wilayah 2</label>
                            <div class="input-group">
                                <button style="width: 100%" type="button" class="btn btn-info wilayah" onclick="tambah('wilayah2')">Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Luas Area1</label>
                            <input type="text" readonly="" class="form-control wajib luas_area hanya_angka" name="luas_area">
                        </div>
                        <div class="form-group">
                            <label>Luas Area2</label>
                            <input type="text" readonly="" value="" class="form-control wajib luas_area1 hanya_angka" name="luas_area1">
                        </div>
                        <div class="formn-group d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="simpan()">SIMPAN</button>
                            <button type="button" class="btn btn-success load">LOAD</button>
                            <button type="button" class="btn btn-success load_all">LOAD ALL</button>
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
        var marker3;
        var drawingManager;
        var drawingManager1;
        var wilayah = [];
        var wilayah1 = [];
        var wilayah_array = [];
        var wilayah_array1 = [];
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
                
            }else if (mode == 'marker3'){

                if (marker3 != undefined) {
                    marker3.setMap(null);
                    $('.marker3_latitude').val('');
                   $('.marker3_longitude').val('');
                }
                if (drawingManager != undefined) {
                    drawingManager.setMap(null);
                }
                google.maps.event.addListenerOnce(map, 'click', function(event) {
                  marker3 = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    draggable: true

                  });

                  $('.marker3_latitude').val(marker3.position.lat);
                  $('.marker3_longitude').val(marker3.position.lng);
                });
                
                alert('Marker Pusat UKM Berhasil Diinisialisasi');
                
            }else if(mode == 'wilayah2'){
                var newShape1;
                if (drawingReady == '0') {
                    drawingReady = '1';

                    if (wilayah1[0] != null) {
                        for (var i = 0; i < wilayah1.length; i++) {
                            wilayah1[i].setMap(null);
                        }
                        wilayah1 = [];
                        wilayah_array1 = [];
                    }

                    var drawingManager1 = new google.maps.drawing.DrawingManager({
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
                            editable: true,
                            draggable: true,
                            clickable: true,
                            zIndex: 1
                        },
                        polygonOptions: {
                            fillColor: '#ffff00',
                            fillOpacity: 0.6,
                            strokeWeight: 5,
                            editable: false,
                            draggable: true,
                            clickable: true,
                            zIndex: 1
                        }
                    });
                    drawingManager1.setMap(map);
                    drawingManager1.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

                    google.maps.event.addListener(drawingManager1, "overlaycomplete", function (event) {
                        newShape1 = event.overlay;
                        newShape1.type = event.type;
                        wilayah1.push(newShape1);

                        if (drawingManager1.getDrawingMode()) {
                            drawingManager1.setDrawingMode(null);
                        }

                        drawingManager1.setMap(null);
                        drawingReady = '0';
                        var path = wilayah1[0].getPath();
                        var measurement = google.maps.geometry.spherical.computeArea(path);
                        $('.luas_area1').val(Math.round(measurement) +' M2');
                        for (var i = 0; i < path.length; i++) {
                          wilayah_array1.push({
                            lat: path.getAt(i).lat(),
                            lng: path.getAt(i).lng()
                          });
                        }

                        newShape1.addListener('dragend', function (event) {
                            wilayah_array1 = [];
                            wilayah1.push(newShape1);
                            if (drawingManager1.getDrawingMode()) {
                                drawingManager1.setDrawingMode(null);
                            }

                            drawingManager1.setMap(null);
                            drawingReady = '0';
                            var path = wilayah1[0].getPath();
                            $('.luas_area').val(Math.round(measurement) +' M2');
                            for (var i = 0; i < path.length; i++) {
                              wilayah_array1.push({
                                lat: path.getAt(i).lat(),
                                lng: path.getAt(i).lng()
                              });
                            }
                            console.log(wilayah_array1);
                        });
                    });

                    $('.luas_area1').val('');
                    alert('Wilayah Telah Diinisialisasi');
                }else{
                    alert('Wilayah Sudah Diinisialisasi');
                }
            }else{
                var newShape;
                if (drawingReady == '0') {
                    drawingReady = '1';

                    if (wilayah[0] != null) {
                        for (var i = 0; i < wilayah.length; i++) {
                            wilayah[i].setMap(null);
                        }
                        wilayah = [];
                        wilayah_array = [];
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
                            editable: true,
                            draggable: true,
                            clickable: true,
                            zIndex: 1
                        },
                        polygonOptions: {
                            fillColor: '#ffff00',
                            fillOpacity: 0.6,
                            strokeWeight: 5,
                            editable: false,
                            draggable: true,
                            clickable: true,
                            zIndex: 1
                        }
                    });
                    drawingManager.setMap(map);
                    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

                    google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
                        newShape = event.overlay;
                        newShape.type = event.type;
                        wilayah.push(newShape);

                        if (drawingManager.getDrawingMode()) {
                            drawingManager.setDrawingMode(null);
                        }

                        drawingManager.setMap(null);
                        drawingReady = '0';
                        var path = wilayah[0].getPath();
                        var measurement = google.maps.geometry.spherical.computeArea(path);
                        $('.luas_area').val(Math.round(measurement) +' M2');
                        for (var i = 0; i < path.length; i++) {
                          wilayah_array.push({
                            lat: path.getAt(i).lat(),
                            lng: path.getAt(i).lng()
                          });
                        }

                        newShape.addListener('dragend', function (event) {
                            wilayah_array = [];
                            wilayah.push(newShape);
                            if (drawingManager.getDrawingMode()) {
                                drawingManager.setDrawingMode(null);
                            }

                            drawingManager.setMap(null);
                            drawingReady = '0';
                            var path = wilayah[0].getPath();
                            $('.luas_area').val(Math.round(measurement) +' M2');
                            for (var i = 0; i < path.length; i++) {
                              wilayah_array.push({
                                lat: path.getAt(i).lat(),
                                lng: path.getAt(i).lng()
                              });
                            }
                            console.log(wilayah_array);
                        });
                    });

                    $('.luas_area').val('');
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

        var googleMaps2JSTS = function(boundaries) {
          var coordinates = [];
          for (var i = 0; i < boundaries.getLength(); i++) {
            coordinates.push(new jsts.geom.Coordinate(
              boundaries.getAt(i).lat(), boundaries.getAt(i).lng()));
          }
          return coordinates;
        };

        var jsts2googleMaps = function(geometry) {
          var coordArray = geometry.getCoordinates();
          console.log(coordArray);
          GMcoords = [];
          for (var i = 0; i < coordArray.length; i++) {
            GMcoords.push(new google.maps.LatLng(coordArray[i].x, coordArray[i].y));
          }
          return GMcoords;
        }

        function act(param) {
            if (param == 'union') {
                // var reader = new jsts.io.WKTReader()
                // var poly = 'POLYGON((';
                // var path = wilayah[0].getPath();
                // for (var i = 0; i < path.length; i++) {
                //     if (i != path.length -1) {
                //         poly += path.getAt(i).lat()+' '+path.getAt(i).lng()+',';
                //     }else{
                //         poly += path.getAt(i).lat()+' '+path.getAt(i).lng()+'))';
                //     }
                // }

                // var poly1 = 'POLYGON((';
                // var path = wilayah1[0].getPath();
                // for (var i = 0; i < path.length; i++) {
                //     if (i != path.length -1) {
                //         poly1 += path.getAt(i).lat()+' '+path.getAt(i).lng()+',';
                //     }else{
                //         poly1 += path.getAt(i).lat()+' '+path.getAt(i).lng()+'))';
                //     }
                // }


                // var a = reader.read(poly)
                // var b = reader.read(poly1)

                // var JSTSpolyUnion = a.union(b);
                // console.log(JSTSpolyUnion);
                // var outputPath = jsts2googleMaps(JSTSpolyUnion);

                var map = new google.maps.Map(
                document.getElementById("map"), {
                    center: {lat: -7.327971, lng: 112.791869},
                    zoom: 10,
                });
                var bounds = new google.maps.LatLngBounds();
                var poly1 = wilayah[0];
                var polyPath1 = wilayah_array;
                for (var i = 0; i < polyPath1.length; i++) {
                    bounds.extend(new google.maps.LatLng(polyPath1[i].lat, polyPath1[i].lng));
                }
                var poly2 = wilayah1[0];
                var polyPath2 = wilayah_array1;
                for (var i = 0; i < polyPath2.length; i++) {
                    bounds.extend(new google.maps.LatLng(polyPath2[i].lat, polyPath2[i].lng));
                }
                map.fitBounds(bounds);
                var geometryFactory = new jsts.geom.GeometryFactory();
                var JSTSpoly1 = geometryFactory.createPolygon(geometryFactory.createLinearRing(googleMaps2JSTS(poly1.getPath())));
                JSTSpoly1.normalize();
                var JSTSpoly2 = geometryFactory.createPolygon(geometryFactory.createLinearRing(googleMaps2JSTS(poly2.getPath())));
                JSTSpoly2.normalize();

                var JSTSpolyUnion = JSTSpoly1.union(JSTSpoly2);
                var outputPath = jsts2googleMaps(JSTSpolyUnion);

                var unionPoly = new google.maps.Polygon({
                    map: map,
                    paths: outputPath,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.3,
                    strokeWeight: 2,
                    fillOpacity: 0.5,
                    fillColor: '#ffff00',
                });
                console.log(unionPoly);
            }else{
                var map = new google.maps.Map(
                document.getElementById("map"), {
                    center: {lat: -7.327971, lng: 112.791869},
                    zoom: 10,
                });
                var bounds = new google.maps.LatLngBounds();
                var poly1 = wilayah[0];
                var polyPath1 = wilayah_array;
                for (var i = 0; i < polyPath1.length; i++) {
                    bounds.extend(new google.maps.LatLng(polyPath1[i].lat, polyPath1[i].lng));
                }
                var poly2 = wilayah1[0];
                var polyPath2 = wilayah_array1;
                for (var i = 0; i < polyPath2.length; i++) {
                    bounds.extend(new google.maps.LatLng(polyPath2[i].lat, polyPath2[i].lng));
                }
                map.fitBounds(bounds);
                var geometryFactory = new jsts.geom.GeometryFactory();
                var JSTSpoly1 = geometryFactory.createPolygon(geometryFactory.createLinearRing(googleMaps2JSTS(poly1.getPath())));
                JSTSpoly1.normalize();
                var JSTSpoly2 = geometryFactory.createPolygon(geometryFactory.createLinearRing(googleMaps2JSTS(poly2.getPath())));
                JSTSpoly2.normalize();

                var JSTSpolyUnion = JSTSpoly1.intersection(JSTSpoly2);
                var outputPath = jsts2googleMaps(JSTSpolyUnion);

                var unionPoly = new google.maps.Polygon({
                    map: map,
                    paths: outputPath,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.3,
                    strokeWeight: 2,
                    fillOpacity: 0.5,
                    fillColor: '#ffff00',
                });
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
            console.log(wilayah_array);
            console.log(wilayah_array1);
            $.ajax({
                type: "get",  
                url: '{{ url('save_wilayah') }}?'+$('.data :input').serialize(),
                data:{wilayah:wilayah_array,wilayah1:wilayah_array1},
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

        $('.load_all').click(function(){
            location.href = '{{ url('/load_all') }}';
        });
    </script>

</html>