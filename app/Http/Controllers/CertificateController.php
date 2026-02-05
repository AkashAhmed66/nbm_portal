<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Certificate::get();

        return view('certificate.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certificate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCertificateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCertificateRequest $request)
    {
        $before = Certificate::where('type', $request->certificatetype)
            ->where('number', $request->certificatenumber)
            ->first();
            
        if($before){
            return redirect()->route('certificate.create')
                ->with('fail', 'Already uploaded this certificate');
        }

        $name = $request->certificatetype . " " . $request->certificatenumber . ".pdf";
        $path = $request->file('certificate')->storeAs('certificates', $name, 'public');

        $certificate = new Certificate();
        $certificate->type = $request->certificatetype;
        $certificate->number = $request->certificatenumber;
        $certificate->folder = $path;
        $certificate->save();
        
        return redirect()->route('certificate.index')
            ->with('success', 'Certificate uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        $data = $certificate->folder;
        return view('certificate.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        return view('certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCertificateRequest  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCertificateRequest $request, Certificate $certificate)
    {
        // Check if updating to a certificate that already exists (excluding current)
        $existing = Certificate::where('type', $request->certificatetype)
            ->where('number', $request->certificatenumber)
            ->where('id', '!=', $certificate->id)
            ->first();
            
        if($existing){
            return redirect()->back()
                ->with('fail', 'A certificate with this type and number already exists');
        }

        $folder = $certificate->folder;

        // If new certificate file is uploaded
        if ($request->hasFile('certificate')) {
            // Delete old file
            if ($certificate->folder && Storage::disk('public')->exists($certificate->folder)) {
                Storage::disk('public')->delete($certificate->folder);
            }

            // Store new file
            $name = $request->certificatetype . " " . $request->certificatenumber . ".pdf";
            $folder = $request->file('certificate')->storeAs('certificates', $name, 'public');
        }

        $certificate->type = $request->certificatetype;
        $certificate->number = $request->certificatenumber;
        $certificate->folder = $folder;
        $certificate->save();

        return redirect()->route('certificate.index')
            ->with('success', 'Certificate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        // Delete the file from storage
        if ($certificate->folder && Storage::disk('public')->exists($certificate->folder)) {
            Storage::disk('public')->delete($certificate->folder);
        }

        $certificate->delete();

        return redirect()->route('certificate.index')
            ->with('success', 'Certificate deleted successfully');
    }
}
