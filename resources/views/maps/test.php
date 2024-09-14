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
                        console.log(phpArray_project[0].company.name);
                        console.log(phpArray_project[0].address);
                    
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
                    
                    </script>
                    
                    <script>
                        // Call the async function and handle the result
                        address_list = [];
                        for(let i=0;i<phpArray_project.length;i++){
                            address_list[i]=getCoordinates(phpArray_project[i].address);
                        
                        getCoordinates(phpArray_project[i].address).then(coordinates => {
                            console.log('address', coordinates);
                        });
                    }
                    </script>
                    <script>

                        let markerData = []; // Define your markerData here
                        // for(let i=0;i<phpArray_project.length;i++){
                        //     markerData[i]={
                        //         name:phpArray_project[i].company.name,
                        //         Building_name:phpArray_project[i].name,
                        //         address: phpArray_project[i].address,
                        //         design_code: 'EURO_Code',
                        //         dc_image: phpArray_project[i].picture_01_link,
                        //     }
                        // }

                        markerData[0] = {
                            name: 'test',
                            Building_name: 'test',
                            address: '東京都江東区東陽1-1-1',
                            design_code: 'EURO_Code',
                            dc_image: 'img/map/code/EU.jpeg',
                            lat: address_list[0][0],
                            lng: address_list[0][1],
                            icon: 'img/map/code/EU.jpeg'
                        };

    function initMap() {
    // Map initialization logic here
    console.log("initMap")
     // 地図の作成
     if(markerData.length===1){

      console.log("initMap_type1")
        var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); // 緯度経度のデータ作成
       map = new google.maps.Map(document.getElementById('map'), { // #mapに地図を埋め込む
         center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
       })} else {
        console.log("initMap_type2")
        var mapLatLng = new google.maps.LatLng({lat: markerData.slice(-1)[0]['lat'], lng: markerData.slice(-1)[0]['lng']}); // 緯度経度のデータ作成
       map = new google.maps.Map(document.getElementById('map'), { // #mapに地図を埋め込む
         center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
          });
       }
     
     // マーカー毎の処理
     for (var i = 1; i < markerData.length; i++) {
      console.log("markerData.length:",markerData.length)
            markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
            marker[i] = new google.maps.Marker({ // マーカーの追加
             position: markerLatLng, // マーカーを立てる位置を指定
            //  content: pinViewBackground,
                map: map // マーカーを立てる地図を指定
                
           });
           temp =  markerData[i]['name']+'<img src='+markerData[i]['icon']+' style="width:20%">';
           for (var j=0;j < i; j++){
              
                if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                    temp = temp + '<br>' + markerData[j]['name']+'<div><img src='+markerData[j]['icon']+' style="width:20%"></div>'
                  }
                // }}}
                
              
            }
            console.log(temp,"temp")
         infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加

            //  content: '<div class="map"> 構造設計者名:' + markerData[i]['name'] + '</div>'+'<div>建物名称:'+markerData[i]['text']+'</div>'+'<div>Structural Design Code:'+markerData[i]['design_code']+'</div>'+'<div><img src='+img_src[i]+' style="width:50%"></div>' // 吹き出しに表示する内容

            content: '<div>建物名称:'+markerData[i]['Building_name']+'</div>'+'<div>Structural Design Code:'+markerData[i]['design_code']+ '<img src=' + markerData[i]['dc_image'] +' style="width:50%"></div>'+' <div class="map"> 構造設計者名:<br>' + temp + '</div>' // 吹き出しに表示する内容
               
              });
            marker[i].setOptions({// TAM 東京のマーカーのオプション設定
            icon: {
            //  url: markerData[i]['icon'],
             url:img_src[i],
             scaledSize: new google.maps.Size(30, 30)
            },
              optimized: false 
          });
         markerEvent(i); // マーカーにクリックイベントを追加
     }
     
    //    marker[0].setOptions({// TAM 東京のマーカーのオプション設定
    //         icon: {
    //          url: markerData[0]['icon'],// マーカーの画像を変更
    //          scaledSize: new google.maps.Size(30, 30)
    // 	},
        // optimized: false 
      //  });
      function markerEvent(i) {
        marker[i].addListener('click', function() { // マーカーをクリックしたとき
          infoWindow[i].open(map, marker[i]); // 吹き出しの表示
      });
    }
                        }
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