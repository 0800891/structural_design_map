<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
        {{ __('Edit Project') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
                          
            <!-- Flash Messages -->
                @if (session('success'))
                  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" id="successMessage">
                  <strong class="font-bold">Success!</strong>
                  <span class="block sm:inline">{{ session('success') }}</span>
                  </div>
                @endif
        
                @if (session('error'))
                  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="errorMessage">
                  <strong class="font-bold">Error!</strong>
                  <span class="block sm:inline">{{ session('error') }}</span>
                  </div>
                @endif
        
            <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700 mr-2">Back to detail</a>
            <form method="POST" action="{{ route('projects.update', $project)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="mb-4">
                <label for="project" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit Project</label>
                <input type="text" name="name" id="name" value="{{$project->name}}" class="shadow appearance-none border rounded w-full py-2 px-3  text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="address" id="address" value="{{$project->address}}" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" name="latitude" id="latitude" value="{{ $project->latitude }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ $project->longitude }}">


                <input type="number" name="completion" id="completion"  value="{{$project->completion}}" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="design_story" id="design_story" value="{{$project->design_story}}"  class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                <p id="img_text">Select three image files<br></p>
                <input type="file" id="img_01" name="picture_01_link" accept="image/*" value={{$project->picture_01_link}} >{{$project->picture_01_link}}<br>
                <input type="file" id="img_02" name="picture_02_link" accept="image/*" value={{$project->picture_02_link}} >{{$project->picture_02_link}}<br>
                <input type="file" id="img_03" name="picture_03_link" accept="image/*" value={{$project->picture_03_link}} >{{$project->picture_03_link}}<br>
                <input type="integer" id="company_id", name="company_id" value={{auth()->user()->company_id}} hidden>
                @error('project')
                  <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
              </div>
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </x-app-layout>


  <script>
    let latLngFetched = false;  // flag to indicate whether the lat/lng has been fetched

    // Function to fetch latitude and longitude based on the address
    async function fetchCoordinates(address) {
        if (address) {
            let apiKey = '{{ config('services.google_map.gm_api_key') }}';
            let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data.status === 'OK') {
                    const lat = data.results[0].geometry.location.lat;
                    const lng = data.results[0].geometry.location.lng;
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    console.log('Fetched Latitude:', lat); // Log the latitude
                    console.log('Fetched Longitude:', lng); // Log the longitude

                    latLngFetched = true;  // set flag when lat/lng is fetched
                } else {
                    alert('Geocoding was not successful: ' + data.status);
                }
            } catch (error) {
                console.error('Error fetching the coordinates: ', error);
                alert('Failed to retrieve coordinates');
            }
        }
    }

    // Fetch coordinates when the page loads (for existing address)
    window.onload = function() {
        const address = document.getElementById('address').value;
        fetchCoordinates(address); // Fetch coordinates based on the existing address
    };

    // Fetch coordinates when the address is updated
    document.getElementById('address').addEventListener('change', async function() {
        const address = this.value;
        fetchCoordinates(address);
    });

    // Prevent form submission if lat/lng is not fetched
    document.querySelector('form').addEventListener('submit', function(event) {
        if (!latLngFetched) {
            event.preventDefault(); // prevent submission if lat/lng is not fetched
            alert("Please wait for the latitude and longitude to be fetched.");
        }
    });

    // Hide the success or error messages after 5 seconds
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 5000);
</script>