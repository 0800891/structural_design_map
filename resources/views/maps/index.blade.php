<x-app-layout>
    {{-- <x-slot name="header" style="background-color:rgb(236,230,198)"> --}}
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Structural Design Map') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Structural Design Map") }}
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{-- Loop through projects --}}
                        {{-- @foreach($projects as $index) --}}
                        {{-- @foreach($json as $j) --}}
                        <tr>
                            {{-- <td><p>{{ $json }}</p></td> --}}
                        </tr>
                        {{-- @endforeach --}}
                    </div>

                    {{-- Use $json to pass data to the JS script --}}

    {{-- <input type="text" id="address" placeholder="Enter address here"> --}}
    {{-- <button onclick="getCoordinates()">Get Coordinates</button> --}}
                    {{-- <p id="coordinates"></p> --}}
                    <div id="map" style="height: 500px; width: 100%;"></div>
                    
                    <script>
                        let phpArray_project = {!! $jsonData !!};
                        console.log(phpArray_project[0]);
                        console.log(phpArray_project[0].company.name);
                        console.log(phpArray_project[0].picture_01_link);
                    
                        // Convert the getCoordinates function to an async function
                        async function getCoordinates(address) {
                            var apiKey = '{{ config('services.google_map.gm_api_key') }}';
                            var url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;
                    
                            try {
                                const response = await fetch(url);
                                const data = await response.json();
                    
                                if (data.status === 'OK') {
                                    var lat = data.results[0].geometry.location.lat;
                                    var lng = data.results[0].geometry.location.lng;
                                    return [lat, lng];
                                } else {
                                    console.log("Geocoding was not successful.");
                                    return [0, 0];  // Default value
                                }
                            } catch (error) {
                                console.error("Error fetching the coordinates: ", error);
                                return [0, 0];  // Default value
                            }
                        }
                    
                        async function initMap() {
                            let markerData = []; // Define your markerData here
                    
                            // Prepare the list of promises for fetching coordinates
                            let promises = phpArray_project.map(project => getCoordinates(project.address));
                    
                            // Wait for all the getCoordinates() promises to resolve
                            let coordinates = await Promise.all(promises);
                    
                            // Process the coordinates and prepare the markerData array
                            for (let i = 0; i < phpArray_project.length; i++) {
                                markerData[i] = {
                                    name: phpArray_project[i].company.name,
                                    Building_name: phpArray_project[i].name,
                                    address: phpArray_project[i].address,
                                    design_code: 'EURO_Code',
                                    dc_image: phpArray_project[i].picture_01_link,
                                    lat: coordinates[i][0],
                                    lng: coordinates[i][1],
                                    icon: phpArray_project[i].picture_01_link
                                };
                            }
                    
                            // Map initialization logic
                            if (markerData.length === 1) {
                                console.log("initMap_type1");
                                var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); 
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    center: mapLatLng, 
                                    zoom: 15 
                                });
                            } else {
                                console.log("initMap_type2");
                                var mapLatLng = new google.maps.LatLng({lat: markerData.slice(-1)[0]['lat'], lng: markerData.slice(-1)[0]['lng']}); 
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    center: mapLatLng, 
                                    zoom: 15 
                                });
                            }
                    
                            // Add markers
                            for (var i = 0; i < markerData.length; i++) {
                                var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                var marker = new google.maps.Marker({
                                    position: markerLatLng,
                                    map: map
                                });
                                var assetBaseUrl = "{{ asset('') }}";
                                var temp = markerData[i]['name'] + '<img src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:20%">';
                                console.log(assetBaseUrl + markerData[i]['icon']);
                                var infoWindow = new google.maps.InfoWindow({
                                    content: '<div>建物名称:' + markerData[i]['Building_name'] + '</div>' +
                                             '<div>Structural Design Code:' + markerData[i]['design_code'] + 
                                             '<img src="' + assetBaseUrl + markerData[i]['dc_image'] + '" style="width:50%"></div>' + 
                                             '<div class="map">構造設計者名:<br>' + temp + '</div>'
                                });
                    
                                marker.addListener('click', function() {
                                    infoWindow.open(map, marker);
                                });
                            }
                        }
                    
                        // Ensure initMap is called after everything is set up
                        initMap();
                    </script>
                    

                    {{-- <script src="{{ asset('/js/showmap.js') }}"></script> --}}
                    <script type="module" src={{"/js/index.js"}}></script>
                    {{-- <script>var google_map_api = Google_map('{{ config('services.google_map.gm_api_key') }}');</script> --}}
                    <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map.gm_api_key') }}&callback=initMap">
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>