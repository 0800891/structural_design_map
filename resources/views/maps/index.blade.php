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
                    {{-- {{ __("Structural Design Map") }} --}}
                   
                    
                <div>Sort By
                    <form action="{{ route('maps.index') }}" method="GET">
                        <div class="flex">
                        <select id="select_company" name="company_id" class="block py-2 w-full rounded-lg">
                            <!-- Explicitly include "ALL Company" as the first option -->
                            <option value="1" {{ $selectedCompanyId == 1 ? 'selected' : '' }}>ALL Companies</option>


                            <!-- List sorted companies -->
                            @foreach($companies as $company)
                            @if($company->id>1)
                            <option value="{{ $company->id }}" {{ $selectedCompanyId == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                            @else
                            @endif
                            @endforeach
                        </select>
                        {{-- <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-black border-full font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Select Company</button> --}}
                        <button id="btn_company" class="px-4 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-700" onclick="choose_company()" >Select</button>
                    </div>
                    </form>
                </div>
                    
                    <div id="map" style="height: 500px; width: 100%;"></div> 
                    <button onclick="getNow()" class="px-4 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Update Where You Are</button>  
                <div>
                    @if(session('projectId'))
                        <p id="dispatched_project_id" value="{{ session('projectId') }}">Selected Project ID: {{ session('projectId') }}</p>
                        <script>
                            // You can use this project ID in JavaScript if needed
                            let projectId = {{ session('projectId') }};
                            console.log("Dispatched Project ID:", projectId);
                        </script>
                    @else
                        <p hidden>No project selected.</p>
                    @endif
                </div>


                    <script>
                        let companyId = {{ $companies[0]->id }};
                        const select_company = document.getElementById("select_company");
                        if (document.getElementById("dispatched_project_id") != null) {
                            const dispatched_project_element = document.getElementById("dispatched_project_id");
                            const projectIdText = dispatched_project_element.innerText.split(": ")[1];
                            const projectId = Number(projectIdText);
                            console.log("dispatched_project_id", Number(projectIdText));
                        }
                        let url = "{{ route('companies.show', ':id') }}".replace(':id', companyId);
                        // console.log(url);
                        // let company_selection = document.getElementById("{{ route('companies.show',':id') }}".replace(':id',companyies[0]->name));
                        console.log("select_company value", select_company.value);
        

                        // function buttonClick(){
                        // console.log('選択されているのは ' + select_company.value + ' です');
                        // }
                        // let checkButton = document.getElementById('btn_company');
                        // checkButton.addEventListener('click', buttonClick);
                    
                        let phpArray_project = {!! $jsonData !!};
                        console.log(phpArray_project[0].company.id);

                        // Declare current_position_latitude and current_position_longitude in the global scope
                        
                            let current_position_latitude = 35.6895; // Default value (Tokyo latitude)
                            let current_position_longitude = 139.6917; // Default value (Tokyo longitude)
                            let isGeolocationReady = false; // Flag to indicate if geolocation is ready
                            console.log("CP01",current_position_latitude, current_position_longitude);
                        
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
                                    return [35.6895, 139.6917]; // Default value
                                }
                            } catch (error) {
                                console.error("Error fetching the coordinates: ", error);
                                return [35.6895, 139.6917]; // Default value
                            }
                        }
                    
                        window.onload = async () => {
                            // Only call initMap after coordinates are determined
                            await setCoordinates(); 
                            console.log("CP02",current_position_latitude, current_position_longitude);
                            initMap();
                        };
                        // window.onload = async () => {
                        async function setCoordinates() {
                            if(document.getElementById("dispatched_project_id")!=null){
                                // If the projectId is dispatched from the /projects/id, set the coordinates to the project’s coordinates
                                
                                const project = phpArray_project.find(proj => Number(proj.id) === projectId);
                                console.log('project_xxx', project)

                            if (project) {
                                 // Fetch the coordinates for the selected project
                                // let coordinates = await getCoordinates(project.address);
                                // current_position_latitude = coordinates[0];
                                current_position_latitude = project.latitude;
                                // current_position_longitude = coordinates[1];
                                current_position_longitude = project.longitude;
                                isGeolocationReady = true; // Set flag to true once coordinates are available
                                console.log("CP03",current_position_latitude, current_position_longitude);
                            }
                            }else {
                            // If no project is selected, use the user's geolocation

                            await new Promise((resolve, reject) => {
                                navigator.geolocation.getCurrentPosition(
                                    function (position) {
                                        current_position_latitude = Number(position.coords.latitude);
                                        current_position_longitude = Number(position.coords.longitude);
                                        isGeolocationReady = true; // Set flag to true once geolocation is available
                                        resolve();
                                        console.log("CP04",current_position_latitude, current_position_longitude);
                                    },
                                    function (error) {
                                        console.error("Geolocation error: ", error);
                                        alert("エラーです！");
                                        resolve();  // Still resolve to ensure map initializes with default coordinates
                                    }
                                );
                             });
                            }
                        }
                    
                        async function initMap() {
                            let markerData = []; // Define your markerData here
                            let marker =[];
                            let infoWindow =[];
                    
                            // Prepare the list of promises for fetching coordinates
                            // let promises = phpArray_project.map(project => getCoordinates(project.address));
                    
                            // Wait for all the getCoordinates() promises to resolve
                            // let coordinates = await Promise.all(promises);
                    
                            // Process the coordinates and prepare the markerData array
                            for (let i = 0; i < phpArray_project.length; i++) {
                                markerData[i] = {
                                    name: phpArray_project[i].company.name,
                                    Building_name: phpArray_project[i].name,
                                    address: phpArray_project[i].address,
                                    design_code: 'EURO_Code',
                                    dc_image: phpArray_project[i].picture_01_link,
                                    // lat: coordinates[i][0],
                                    lat: Number(phpArray_project[i].latitude),
                                    // lng: coordinates[i][1],
                                    lng: Number(phpArray_project[i].longitude),
                                    icon: phpArray_project[i].picture_02_link,
                                    project_url:"{{ route('projects.show', ':id') }}".replace(':id', phpArray_project[i].id),
                                    company_url:"{{ route('companies.show', ':id') }}".replace(':id', phpArray_project[i].company.id),
                                    company_id:phpArray_project[i].company.id
                                };
                            }

                                    markerData[phpArray_project.length]={
                                        name: 'CurrentLocation',
                                        Building_name: 'None',
                                        address: 'None',
                                        design_code: 'None',
                                        dc_image: 'None',
                                        lat: Number(current_position_latitude),
                                        lng: Number(current_position_longitude),
                                        icon: 'None',
                                        project_url:'None',
                                        company_url:'None',
                                        company_id:'None'
                                    }
                                // }
                                
                                // var mapLatLng = new google.maps.LatLng({lat: markerData.slice(-1)[0]['lat'], lng: markerData.slice(-1)[0]['lng']}); 
                                var mapLatLng = new google.maps.LatLng({lat: Number(current_position_latitude), lng: Number(current_position_longitude)});
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    center: mapLatLng, 
                                    zoom: 15 
                                });
                            
                        
                            // Add markers
                            for (var i = 0; i < markerData.length; i++) {

                                    if(i<phpArray_project.length){
                                        let k = select_company.value;
                                        // console.log('True_or_False',Number(select_company.value)===1)

                                    if(Number(select_company.value)===1){

                                        var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                        marker[i] = new google.maps.Marker({
                                            position: markerLatLng,
                                            map: map
                                        });
                                        var assetBaseUrl = "{{ asset('') }}";
                                        assetBaseUrl = assetBaseUrl.replace(/\/$/, "");
                                        var temp = markerData[i]['name'] + '<img src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:20%">';
                                        for (var j=0;j < i; j++){
                                        if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                                            temp = temp + '<br>' + markerData[j]['name']+'<div><img src="' + assetBaseUrl + markerData[j]['icon'] + '" style="width:20%"></div>'
                                            }
                                        }
                                        infoWindow[i] = new google.maps.InfoWindow({
                                            content: '<div>Project Name:<a href='+markerData[i]['project_url']+' class="text-blue-500 hover:text-blue-700 mr-2 text-sm">' + markerData[i]['Building_name'] + '</a></div>' +
                                                     '<div class="map">Structural Designer:<a href='+markerData[i]['company_url']+' class="text-blue-500 hover:text-blue-700 mr-2 text-sm">' + markerData[j]['name'] + '</a></div>'+
                                                    //  '<div>Structural Design Code:' + markerData[i]['design_code'] + 
                                                    '<img class="m-2 p-2" src="' + assetBaseUrl + markerData[i]['dc_image'] + '" style="width:50%"></div>'+
                                                    '<img class="m-2 p-2" src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:50%"</div>'
                                                    //  '<div class="map">構造設計者名:<br>' + temp + '</div>'
                                            });
                                        marker[i].setOptions({
                                        icon: {
                                            //  url: markerData[i]['icon'],
                                            url:assetBaseUrl + markerData[i]['dc_image'],
                                            scaledSize: new google.maps.Size(30, 30)
                                            },
                                        optimized: false 
                                        });
                                        markerEvent(i);
                                        }
                                        else{
                                        if(Number(markerData[i]['company_id'])===Number(select_company.value)){
                                                var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                        marker[i] = new google.maps.Marker({
                                            position: markerLatLng,
                                            map: map
                                        });
                                        var assetBaseUrl = "{{ asset('') }}";
                                        assetBaseUrl = assetBaseUrl.replace(/\/$/, "");
                                        var temp = markerData[i]['name'] + '<img src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:20%">';
                                        for (var j=0;j < i; j++){
                                        if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                                            temp = temp + '<br>' + markerData[j]['name']+'<div><img src="' + assetBaseUrl + markerData[j]['icon'] + '" style="width:20%"></div>'
                                            }
                                        }
                                        infoWindow[i] = new google.maps.InfoWindow({
                                            content: '<div>建物名称:<a href='+markerData[i]['project_url']+' class="text-blue-500 hover:text-blue-700 mr-2 text-sm">' + markerData[i]['Building_name'] + '</a></div>' +
                                                     '<div class="map">構造設計者名:<a href='+markerData[i]['company_url']+' class="text-blue-500 hover:text-blue-700 mr-2 text-sm">' + markerData[j]['name'] + '</a></div>'+
                                                    //  '<div>Structural Design Code:' + markerData[i]['design_code'] + 
                                                    '<img class="m-2 p-2" src="' + assetBaseUrl + markerData[i]['dc_image'] + '" style="width:50%"></div>'+
                                                    '<img class="m-2 p-2" src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:50%"></div>'
                                                    //  '<div class="map">構造設計者名:<br>' + temp + '</div>'
                                            });
                                        marker[i].setOptions({
                                        icon: {
                                            //  url: markerData[i]['icon'],
                                            url:assetBaseUrl + markerData[i]['dc_image'],
                                            scaledSize: new google.maps.Size(30, 30)
                                            },
                                        optimized: false 
                                        });
                                        markerEvent(i);}
                                        

                                        }
                                    }
                                else{
                                    console.log('current_position');
                                    var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                    if(document.getElementById("dispatched_project_id")!=null){

                                    }else{
                                    marker[i] = new google.maps.Marker({
                                        position: markerLatLng,
                                        map: map
                                    });
                                };
                                    const opts = {
                                        zoom:13,
                                        center: markerLatLng,
                                    };
                                    infoWindow[i] = new google.maps.InfoWindow({
                                        content: '現在地' 
                                        });
                                    // marker[i].setOptions({opts});
                                    // markerEvent(i);
                                    // map.setOptions({opts});
                                    }
                                }
                                console.log("CP05",current_position_latitude, current_position_longitude);

                                function markerEvent(i) {
                                    marker[i].addListener('click', function() { // マーカーをクリックしたとき
                                    infoWindow[i].open(map, marker[i]); // 吹き出しの表示
                                    });
                                }
                               
                            }
                        
                    
                        // Ensure initMap is called after everything is set up
                        // initMap();

                        // let get_position = 0;
                        const getNow = async () => {
                            window.location.reload();
                            navigator.geolocation.getCurrentPosition(
                                async function (position) {
                                // console.log(position.coords.latitude);
                                current_position_latitude = position.coords.latitude;
                                current_position_longitude = position.coords.longitude;
                                await setCoordinates();
                                initMap() ;
                                console.log("CP06",current_position_latitude, current_position_longitude);
                                },
                                function (error) {
                                alert("エラーです！");
                                }
                                );
                            };
                        
                        const choose_company = () => {
                            initMap(); 
                            console.log("CP07",current_position_latitude, current_position_longitude);
                        };
                    </script>
                    
{{-- 
                    <script src="{{ asset('/js/showmap.js') }}"></script>
                    <script type="module" src={{"/js/index.js"}}></script> --}}
                    {{-- <script>var google_map_api = Google_map('{{ config('services.google_map.gm_api_key') }}');</script> --}}
                    <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map.gm_api_key') }}&callback=initMap">
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>