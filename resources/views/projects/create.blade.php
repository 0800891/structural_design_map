<!-- resources/views/tweets/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
        {{ __('Register New Project') }}
      </h2>
    </x-slot>
  @if(auth()->user()->company_id ==1)
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  You cannot register new project because you are not belong to any companies yet.<br>
  Please register your company from "Profile".
  </div>
  @else
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

            <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-4">
                <label for="project" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">New Project</label>
                <input type="text" name="name" id="name" placeholder="Project Name" class="shadow appearance-none border rounded w-full py-2 px-3  text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="name">
                <input type="text" name="address" id="address" placeholder="Address" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="address">

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <input type="number" name="completion" id="completion" placeholder="Completion Year" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="design_story" id="design_story" placeholder="Input Structural Design story" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                
                <p id="img_text">Upload 3 images related to this project<br></p>
                <input type="file" id="img_01" name="picture_01_link" accept="image/*" required><br>
                <input type="file" id="img_02" name="picture_02_link" accept="image/*" required><br>
                <input type="file" id="img_03" name="picture_03_link" accept="image/*" required><br>
                <input type="integer" id="company_id", name="company_id" value={{auth()->user()->company_id}} hidden>
                @error('project')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
              </div>
              <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-black border-full font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endif
  </x-app-layout>

  <script>
    let latLngFetched = false;  // flag to indicate whether the lat/lng has been fetched
    document.getElementById('address').addEventListener('change', async function() {
        const address = this.value;
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
                    latLngFetched = true;  // set flag when lat/lng is fetched
                } else {
                    alert('Geocoding was not successful: ' + data.status);
                }
            } catch (error) {
                console.error('Error fetching the coordinates: ', error);
                alert('Failed to retrieve coordinates');
            }
        }
    });

    document.querySelector('form').addEventListener('submit', function(event) {
    if (!latLngFetched) {
        event.preventDefault(); // prevent submission if lat/lng is not fetched
        alert("Please wait for the latitude and longitude to be fetched.");
    }
});

        // Hide the message after 5 seconds
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