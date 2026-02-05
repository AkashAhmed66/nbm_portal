<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">

        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                Edit Certificate
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('certificate.index') }}">< Back</a>
            </div>
        </div>

        <div class="flex flex-col mt-5">
            <div class="flex flex-col">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    @if ($message = Session::get('fail'))
                        <div class="p-5 rounded bg-red-500 text-white m-3">
                            <span>{{ $message }}</span>
                        </div>
                    @endif

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

                        <form action="{{ route('certificate.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="certificatetype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Type</label>
                                <select required id="certificatetype" name="certificatetype" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled>Choose a type</option>
                                    <option value="ISO Certificate" {{ old('certificatetype', $certificate->type) == 'ISO Certificate' ? 'selected' : '' }}>ISO Certificate</option>
                                    <option value="Training Certificate" {{ old('certificatetype', $certificate->type) == 'Training Certificate' ? 'selected' : '' }}>Training Certificate</option>
                                    <option value="C-TPAT Certificate" {{ old('certificatetype', $certificate->type) == 'C-TPAT Certificate' ? 'selected' : '' }}>C-TPAT Certificate</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="certificatenumber">Certificate Number</label>
                                <input required type="text" name="certificatenumber" value="{{ old('certificatenumber', $certificate->number) }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="SN">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="certificate">Certificate (PDF only)</label>
                                <input type="file" name="certificate" accept=".pdf" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current certificate. Maximum file size: 10MB</p>
                                
                                @if($certificate->folder)
                                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Current Certificate:</p>
                                        <embed src="{{ asset('storage/' . $certificate->folder) }}" type="application/pdf" width="100%" height="600px" class="border border-gray-300 rounded" />
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-start mt-4 gap-x-2">
                                <button type="submit" class="px-6 py-2 text-sm font-semibold rounded-md shadow-md text-green-100 bg-green-500 hover:bg-green-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
