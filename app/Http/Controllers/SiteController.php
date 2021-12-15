<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $sites = Site::query()
            ->withCount([
                'users'
            ])
            ->paginate(20);
        return view('management.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('management.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['unique:sites'],
        ]);
        $site = new Site();
        $site->title = $request->title;
        $site->code = $request->code;
        $site->save();

        return redirect()->back()->with('result', 'محل خدمت با موفقیت ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $site = Site::query()
            ->with(['users'])
            ->findOrFail($id);

        return view('management.sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $site = Site::query()->findOrFail($id);
        return view('management.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $site = Site::query()->findOrFail($id);
        $site->code = $request->code;
        $site->title = $request->title;
        $site->save();

        return redirect()->back()->with('result', 'محل خدمت با موفقیت ویرایش شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
