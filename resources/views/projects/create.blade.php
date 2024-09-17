<!-- resources/views/tweets/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Project登録') }}
      </h2>
    </x-slot>
  @if(auth()->user()->company_id ==1)
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  会社が登録されていないとプロジェクトの登録はできません<br>
  Profileから会社名を登録してください
  </div>
  @else
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-4">
                <label for="project" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">New Project</label>
                <input type="text" name="name" id="name" placeholder="プロジェクト名を入力してください" class="shadow appearance-none border rounded w-full py-2 px-3  text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="name">
                <input type="text" name="address" id="address" placeholder="住所を入力してください" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="address">
                <input type="number" name="completion" id="completion" placeholder="完成年を入力してください" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="text" name="design_story" id="design_story" placeholder="構造デザインの説明を入力してください" class="shadow appearance-none border rounded w-full py-2 px-3 mt-2 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p id="img_text">登録したい画像のファイルを３つ選択してください<br></p>
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