<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $before = Certificate::Where('type', $request->certificatetype)->where('number', $request->certificatenumber)->first();
        if($before){
            return redirect()->route('certificate.create')
                ->with('fail', 'Already uploaded this certificate');
        }else{

            
            $name = "".$request->certificatetype." ".$request->certificatenumber.".pdf";
            $path = $request->file('certificate')->storeAs('certificates', $name, 'public');
            $fileName = $path;

            $certificate = new Certificate();
            
            $certificate->type = $request->certificatetype;
            $certificate->number = $request->certificatenumber;
            $certificate->folder = $fileName;

            $certificate->save();
            
            return redirect()->route('certificate.create')
            ->with('success', 'Certificate Uploaded');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        $data = $certificate->folder;
        return view('certificate.show', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {

        $filePath = storage_path("app\public");
        $filePath = $filePath."/".$certificate->folder;
        // dd($filePath);
        File::delete($filePath);
        $res = $certificate->delete();


        return redirect()->route('certificate.index')
            ->with('success', 'Certificate deleted successfully');
    }
}
