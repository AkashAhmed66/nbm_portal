<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = News::latest()->get();

        return view('news.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function allNews(){
        $data = News::get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news = News::all();
        return view('news.create', compact('news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        // dd($request->toArray());
        $file = $request->file("thumb");
        $ext = $file->extension();
        $thumbPath = $file->storeAs('/thumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);

        $news = new News();
        $news->title = $request->title;
        $news->link = $request->link;
        $news->thumb = $thumbPath;
        $news->save();

        return redirect()->route('news.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewsRequest  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $thumbPath = $news->thumb;

        if ($request->thumb) {
            //$thumbName = now()->timestamp . ".{$request->thumb->getClientOriginalName()}";
            //$thumbPath = "/storage/".$request->file('thumb')->storeAs('files', $thumbName, 'public');

            $file = $request->file("thumb");
            $ext = $file->extension();
            $thumbPath = $file->storeAs('/thumb', now()->timestamp .'.' . $ext,['disk' => 'public_uploads']);
            $news->thumb = $thumbPath;
        }

        $news->link = $request->link;
        $news->title = $request->title;
        $news->save();

        return redirect()->route('news.index')
            ->with('success', 'News successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News category deleted successfully');
    }
}
