<x-app-layout>
    {{-- <x-slot name="header" style="background-color:rgb(236,230,198)"> --}}
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Structural Design Map') }}
        </h2>
    </x-slot>
<head>
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
</head>
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

                <script src="https://unpkg.com/@googlemaps/markerclusterer@latest/dist/index.min.js"></script>
               
                    <script>
                        let companyId = {{ $companies[0]->id }};
                        let markerData = []; // Define your markerData here
                        let marker_array =[];
                        const select_company = document.getElementById("select_company");
                        if (document.getElementById("dispatched_project_id") != null) {
                            const dispatched_project_element = document.getElementById("dispatched_project_id");
                            const projectIdText = dispatched_project_element.innerText.split(": ")[1];
                            const projectId = Number(projectIdText);
                            console.log("dispatched_project_id", Number(projectIdText));
                        }
                        let url = "{{ route('companies.show', ':id') }}".replace(':id', companyId);
                        
                        console.log("select_company value", select_company.value);
        
                    
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
                            const { Map, InfoWindow } = await google.maps.importLibrary("maps");
                            const { AdvancedMarkerElement, PinElement} = await google.maps.importLibrary("marker"); 
                            const {AdvancedMarkerClickEvent} = await google.maps.importLibrary("marker");
                            // let markerData = []; // Define your markerData here
                            // let marker =[];
                            let infoWindow =[];
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
                                var map = new Map(document.getElementById('map'), {
                                    center: mapLatLng, 
                                    zoom: 13, 
                                    mapId: "73684a44fd9dc703", // Map ID is required for advanced markers.
                                });
                            
                        
                            // Add markers
                            for (var i = 0; i < markerData.length; i++) {
                                console.log("i,phpArray_project.length=",i, phpArray_project.length);

                                    if(i<phpArray_project.length){
                                        let k = select_company.value;
                                        // console.log('True_or_False',Number(select_company.value)===1)

                                    if(Number(select_company.value)===1){

                                        var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                        // marker[i] = new google.maps.marker.AdvancedMarkerElement({
                                        const marker = new google.maps.marker.AdvancedMarkerElement({
                                            map,
                                            content: buildContent(markerData[i])|| null, // Add custom marker styling or content here if needed
                                            position: markerLatLng,
                                            title: String(i),
                                            // gmpClickable:true,
                                            // zIndex: null,
                                        });
                                        marker_array[i]=marker;
                                        console.log('marker.title',marker.title);

                                        // marker[i].addListener("click", ({ domEvent, latLng }) => {
                                            marker.addListener("click", ({ domEvent, latLng }) => {
                                            const { target } = domEvent;
                                            setTimeout(toggleHighlight(marker),10000);
                                            });


                                        var assetBaseUrl = "{{ asset('') }}";
                                        assetBaseUrl = assetBaseUrl.replace(/\/$/, "");
                                        var temp = markerData[i]['name'] + '<img src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:20%">';
                                        
                                        for (var j=0;j < i; j++){
                                        if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                                            temp = temp + '<br>' + markerData[j]['name']+'<div><img src="' + assetBaseUrl + markerData[j]['icon'] + '" style="width:20%"></div>'
                                            }
                                        }
                                        
                                        }
                                        else{
                                        if(Number(markerData[i]['company_id'])===Number(select_company.value)){
                                                var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                        // marker[i] = new google.maps.marker.AdvancedMarkerElement({
                                        const  marker = new google.maps.marker.AdvancedMarkerElement({
                                            map,
                                            content: buildContent(markerData[i])|| null, // Add custom marker styling or content here if needed
                                            position: markerLatLng,
                                            title: String(i),
                                            // gmpClickable:true,
                                            // zIndex: null,
                                        });
                                        marker_array[i]=marker;

                                        console.log('marker.title',marker.title);

                                        // marker[i].addListener("click", ({ domEvent, latLng }) => {
                                            marker.addListener("click", ({ domEvent, latLng }) => {
                                            const { target } = domEvent;
                                            toggleHighlight(marker);
                                            });
                                        var temp = markerData[i]['name'] + '<img src="' + assetBaseUrl + markerData[i]['icon'] + '" style="width:20%">';
                                        for (var j=0;j < i; j++){
                                        if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                                            temp = temp + '<br>' + markerData[j]['name']+'<div><img src="' + assetBaseUrl + markerData[j]['icon'] + '" style="width:20%"></div>'
                                            }
                                        }

                                        }
                                        }

                                        
                                    }
                                else{
                                    console.log('current_position');
                                    var markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                                    if(document.getElementById("dispatched_project_id")!=null){

                                    }else{
                                        const pin = new PinElement({
                                            scale: 1.0,
                                        });
                                    marker = new google.maps.marker.AdvancedMarkerElement({
                                        map,
                                        content:pin.element,
                                        position: markerLatLng,
                                        });
                                    // marker_array[i]=marker;
                                };
                                    // const opts = {
                                    //     zoom:13,
                                    //     center: markerLatLng,
                                    // };
                                    }
                                }
                                console.log("CP05",current_position_latitude, current_position_longitude);

                                
                                // クラスターを生成
                        let markerCluster = new markerClusterer.MarkerClusterer({
	                            map: map,
	                            markers: marker_array,
                                zIndex:0,
                            });
                            }
                        
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

                        function toggleHighlight(markerView) {

                            console.log(markerView);
                            console.log("toggle_0");
                            if (!markerView.content){
                                console.log("toggle_C");
                                return};

                                if (markerView.content.classList.contains("highlight") && markerView.zIndex == 1) {
                                        
                                        markerView.zIndex = 0;
                                        console.log("toggle_A");
                                }else if(markerView.content.classList.contains("highlight") && markerView.zIndex == 0){
                                    markerView.content.classList.remove("highlight");
                                    console.log("toggle_D");
                                }else {
                                        markerView.content.classList.add("highlight");
                                        markerView.zIndex = 1;
                                        console.log("toggle_B");
                                }
                            }
                            
                            function buildContent(property) {
                                let content = document.createElement("div");
                                let assetBaseUrl = "{{ asset('') }}";
                                assetBaseUrl = assetBaseUrl.replace(/\/$/, "");
  
                                content.classList.add("property");
                                // content.innerHTML = `
                                //                 <div class="icon">
                                //                         <img src="${assetBaseUrl + property.dc_image}" style="width:30px;height:30px;">
                                //                 </div>
                                //                 `;
                                content.innerHTML = `
                                                <div class="icon">
                                                        <img src="${assetBaseUrl + property.dc_image}" style="width:40px;height:40px;">
                                                </div>
                                                <div class="details">
                                                        <div>
                                                            Project Name:<a href=${property.project_url} class="text-blue-500 hover:text-blue-700 mr-2 text-sm">${property.Building_name}</a>
                                                        </div>
                                                        <div>
                                                                Structural Designer:<a href=${property.company_url} class="text-blue-500 hover:text-blue-700 mr-2 text-sm">${property.name}</a>
                                                        </div>
                                                        <div class="features">
                                                            <div>
                                                            <img class="m-2 p-2" src="${assetBaseUrl + property.dc_image}" style="width:100px">
                                                            </div>
                                                            <div>
                                                            <img class="m-2 p-2" src="${assetBaseUrl + property.icon}" style="width:100px">
                                                            </div>
                                                        </div>
                                                </div>
                                                `;
                                console.log(content);
                                return content;
                            }

                    </script>
                    {{-- <script>
                        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
                          key: "{{ config('services.google_map.gm_api_key') }}",
                          v: "beta",
                          // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
                          // Add other bootstrap parameters as needed, using camel case.
                        });
                      </script> --}}
                      <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
                                ({key: "{{ config('services.google_map.gm_api_key') }}", v: "beta"});</script>
{{-- 
                    <script src="{{ asset('/js/showmap.js') }}"></script>
                    <script type="module" src={{"/js/index.js"}}></script> --}}
                    {{-- <script>var google_map_api = Google_map('{{ config('services.google_map.gm_api_key') }}');</script> --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>