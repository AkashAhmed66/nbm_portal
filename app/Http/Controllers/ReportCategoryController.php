<?php

namespace App\Http\Controllers;

use App\Models\ReportCategory;
use App\Http\Requests\StoreReportCategoryRequest;
use App\Http\Requests\UpdateReportCategoryRequest;

class ReportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReportCategory::latest()->get();

        return view('reportCategory.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function allReportCategories(){
        $data = ReportCategory::with('reports')->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reportCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportCategoryRequest $request)
    {
        // dd($request->toArray());
        $req = new ReportCategory();
        $req->title = $request->title;
        $req->save();

        return redirect()->route('report-categories.index')
            ->with('success','Report category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ReportCategory $reportCategory)
    {   
        return view('reportCategory.show',compact('reportCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportCategory $reportCategory)
    {
        return view('reportCategory.edit',compact('reportCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportCategoryRequest  $request
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportCategoryRequest $request, ReportCategory $reportCategory)
    {
        $reportCategory->title = $request->title;
        $reportCategory->save();

        return redirect()->route('report-categories.index')
            ->with('success','Report category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportCategory $reportCategory)
    {
        $reportCategory->delete();

        return redirect()->route('report-categories.index')
            ->with('success','Report category deleted successfully');
    }
}
