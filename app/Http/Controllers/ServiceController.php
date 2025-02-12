<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Service::with('serviceCategory')->latest()->get();

        return view('service.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceType = ServiceType::all();
        $serviceCategory = ServiceCategory::all();
        return view('service.create', compact('serviceCategory', 'serviceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $thumbName = now()->timestamp . ".{$request->thumb->getClientOriginalName()}";
        $thumbPath = $request->file('thumb')->storeAs('files', $thumbName, 'public');

        $singleThumbName = now()->timestamp . ".{$request->singleThumb->getClientOriginalName()}";
        $singleThumbNamePath = $request->file('singleThumb')->storeAs('files', $singleThumbName, 'public');

        Service::create([
            'service_category_id' => $request->service_category_id,
            'title' => $request->title,
            'shortDesc' => $request->shortDesc,
            'description' => $request->description,
            'thumb' => "/storage/{$thumbPath}",
            'singleThumb' => "/storage/{$singleThumbNamePath}",
            'sln' => $request->sln,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $serviceType = ServiceType::all();
        $serviceCategory = ServiceCategory::all();

        return view('service.edit', compact('service', 'serviceType', 'serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateServiceRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $thumbPath = $service->thumb;
        $singleThumbNamePath = $service->singleThumb;

        if ($request->thumb) {
            //$thumbName = now()->timestamp . ".{$request->thumb->getClientOriginalName()}";
            //$thumbPath = "/storage/".$request->file('thumb')->storeAs('files', $thumbName, 'public');

            $file = $request->file("thumb");
            $ext = $file->extension();
            $thumbPath = $file->storeAs('/thumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);

        }
        if ($request->singleThumb) {
            //$singleThumbName = now()->timestamp . ".{$request->singleThumb->getClientOriginalName()}";
            //$singleThumbNamePath = "/storage/".$request->file('singleThumb')->storeAs('files', $singleThumbName, 'public');

            $file = $request->file("singleThumb");
            $ext = $file->extension();
            $singleThumbNamePath = $file->storeAs('/singleThumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);

        }


        $updateArray['service_category_id'] = $request->service_category_id;
        $updateArray['title'] = $request->title;
        $updateArray['shortDesc'] = $request->shortDesc;
        $updateArray['description'] = $request->description;
        $updateArray['thumb'] = $thumbPath;
        $updateArray['singleThumb'] = $singleThumbNamePath;
        $updateArray['sln'] = $request->sln;

        $service->update($updateArray);


        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service category deleted successfully');
    }


    public function serviceList()
    {
        $serviceList = ServiceType::with('serviceCategory', 'serviceCategory.services')
            ->orderBy('service_types.sln')
            ->get();

        return response()->json([
            "success" => true,
            "message" => "service List",
            "data" => $serviceList
        ]);
    }

    public function serviceDetails($id)
    {
        $service = Service::where('id', $id)->first();

        return response()->json([
            "success" => true,
            "message" => "service Details",
            "data" => $service
        ]);
    }

    public function categoryWiseService($id)
    {
        $service = Service::where('service_category_id', $id)->get();

        return response()->json([
            "success" => true,
            "message" => "services",
            "data" => $service
        ]);
    }
}
