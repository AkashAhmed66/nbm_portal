<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReportCategory;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Report::with('reportCategory')->latest()->get();

        return view('report.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reportCategory = ReportCategory::all();
        return view('report.create', compact('reportCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {

        // dd($request->toArray());
        $file = $request->file("thumb");
        $ext = $file->extension();
        $thumbPath = $file->storeAs('/thumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);

        $report = new Report();
        $report->title = $request->title;
        $report->link = $request->link;
        $report->report_category_id = $request->report_category_id;
        $report->thumb = $thumbPath;
        $report->save();

        return redirect()->route('report.index')
            ->with('success', 'Report successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $reportCategory = ReportCategory::all();

        return view('report.edit', compact('report', 'reportCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {

        // dd($request->toArray());
        $thumbPath = $report->thumb;

        if ($request->thumb) {
            //$thumbName = now()->timestamp . ".{$request->thumb->getClientOriginalName()}";
            //$thumbPath = "/storage/".$request->file('thumb')->storeAs('files', $thumbName, 'public');

            $file = $request->file("thumb");
            $ext = $file->extension();
            $thumbPath = $file->storeAs('/thumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);
            $report->thumb = $thumbPath;
        }

        $report->report_category_id = $request->report_category_id;
        $report->title = $request->title;
        $report->link = $request->link;
        $report->save();

        return redirect()->route('report.index')
            ->with('success', 'Report successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('report.index')
            ->with('success', 'Report deleted successfully');
    }
}
