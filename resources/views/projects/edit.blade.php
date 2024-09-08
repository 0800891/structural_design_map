<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Project編集') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700 mr-2">詳細に戻る</a>
            <form method="POST" action="{{ route('projects.update', $project) }}">
              @csrf
              @method('PUT')
              <div class="mb-4">
                <label for="project" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit Project</label>
                <input type="text" name="name" id="name" value={{$project->name}} class="shadow appearance-none border rounded w-full py-2 px-3  text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="address" id="address" value={{$project->address}} class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="number" name="completion" id="completion"  value={{$project->completion}} class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="design_story" id="design_story" value={{$project->design_story}}  class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p id="img_text">登録したい画像のファイルを３つ選択してください<br></p>
                <input type="file" id="img_01" name="picture_01_link" value={{$project->picture_01_link}} ><br>
                <input type="file" id="img_02" name="picture_02_link" value={{$project->picture_02_link}} ><br>
                <input type="file" id="img_03" name="picture_03_link" value={{$project->picture_03_link}} ><br>
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