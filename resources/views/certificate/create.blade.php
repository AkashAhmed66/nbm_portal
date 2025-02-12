<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                Add New Certificate
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('certificate.index') }}">< Back</a>
            </div>
        </div>

        <div class="flex flex-col mt-5">
            <div class="flex flex-col">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    @if ($message = Session::get('fail'))
                        <div class="p-3 rounded bg-red-500 text-green-100 mb-4 m-3">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="p-3 rounded bg-green-500 text-green-100 mb-4 m-3">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="p-3 rounded bg-red-500 text-white m-3">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">

                        <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div>
                                <label for="certificatetype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Type</label>
                                <select required id="certificatetype" name="certificatetype" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a type</option>
                                    <option value="ISO Certificate">ISO Certificate</option>
                                    <option value="Training Certificate">Training Certificate</option>
                                    <option value="C-TPAT Certificate">C-TPAT Certificate</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm text-black-700" for="certificatenumber">Certificate Number</label>
                                <input required type="text" name="certificatenumber" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="SN">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm text-black-700" for="title">Certificate</label>
                                <input required type="file" name="certificate" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Short Desc">
                            </div>

                            <div class="flex items-center justify-start mt-4 gap-x-2">
                                <button type="submit" class="px-6 py-2 text-sm font-semibold rounded-md shadow-md text-green-100 bg-green-500 hover:bg-green-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
