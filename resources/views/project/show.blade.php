<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">

        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                {{ $project->title }}
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('projects.index') }}">< Back</a>
            </div>
        </div>

        <div class="flex flex-col mt-5">
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">

                    <div class="max-w-lg rounded overflow-hidden shadow-lg mb-6">
                        <img class="w-full" src="{{ asset($project->image) }}" alt="{{ $project->title }}">
                    </div>

                    <div class="mb-3"><span class="font-bold text-gray-700">Type:</span> {{ $project->serviceCategory->serviceType->title }}</div>
                    <div class="mb-3"><span class="font-bold text-gray-700">Category:</span> {{ $project->serviceCategory->title }}</div>
                    <div class="mb-3"><span class="font-bold text-gray-700">Client Name:</span> {{ $project->clientName }}</div>
                    <div class="mb-3"><span class="font-bold text-gray-700">Location:</span> {{ $project->location }}</div>
                    <div class="mb-3"><span class="font-bold text-gray-700">Duration:</span> {{ $project->duration }}</div>

                    <div class="mt-4">
                        <span class="font-bold text-gray-700">Description:</span>
                        <div class="mt-2 text-gray-600">{!! $project->description !!}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
