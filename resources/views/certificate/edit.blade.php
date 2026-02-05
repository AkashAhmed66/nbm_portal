<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">

        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                Edit
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('services.index') }}">< Back</a>
            </div>
        </div>

        <div class="flex flex-col mt-5">
            <div class="flex flex-col">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    @if ($errors->any())
                        <div class="p-5 rounded bg-red-500 text-white m-3">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">

                        <form action="{{ route('services.update',$service->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="servicetype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Type</label>
                                <select id="servicetype" name="service_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a type</option>

                                    @foreach($serviceType as $type)
                                        <option value="{{$type->id}}" {{ $service->serviceCategory->service_type_id == $type->id ? "selected" : "" }}>{{$type->title}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mt-4">
                                <label for="serviceCategories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category</label>
                                <select id="serviceCategories" name="service_category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a Category</option>

                                    @foreach($serviceCategory as $category)
                                        <option value="{{$category->id}}" {{ old('service_category_id', $service->service_category_id) == $category->id ? "selected" : "" }}>{{$category->title}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Title</label>
                                <input type="text" name="title" value="{{old('title', $service->title)}}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Title">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Short Desc</label>
                                <input type="text" name="shortDesc" value="{{old('shortDesc', $service->shortDesc)}}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Short Desc">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Desc</label>
                                <textarea name="description" rows="4" cols="" class="tinymce-editor block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Desc">{{old('description', $service->description)}}</textarea>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Thumb</label>
                                <input type="file" name="thumb" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Short Desc">

                                <div class="max-w-sm rounded overflow-hidden shadow-lg mt-4">
                                    <img class="w-full" src="{{ asset($service->thumb) }}" alt="Sunset in the mountains">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Single Thumb</label>
                                <input type="file" name="singleThumb" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Short Desc">

                                <div class="max-w-sm rounded overflow-hidden shadow-lg mt-4">
                                    <img class="w-full" src="{{ asset($service->singleThumb) }}" alt="Sunset in the mountains">
                                </div>

                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">SN</label>
                                <input type="text" name="sln" value="{{old('sln', $service->sln)}}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="SN">
                            </div>

                            <div class="flex items-center justify-start mt-4 gap-x-2">
                                <button type="submit" class="px-6 py-2 text-sm font-semibold rounded-md shadow-md text-green-100 bg-green-500 hover:bg-green-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
