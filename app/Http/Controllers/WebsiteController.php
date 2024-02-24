<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteRequest;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the websites.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::all();
        return response()->json($websites);
    }

    /**
     * Store a newly created website in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebsiteRequest $request)
    {
        $website = new Website;
        $website->name = $request->name;
        $website->url = $request->url;
        $website->save();
        
        return response()->json($website, 201);
    }

    /**
     * Display the specified website.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return response()->json($website);
    }

    /**
     * Update the specified website in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(WebsiteRequest $request, Website $website)
    {
        $website->name = $request->name;
        $website->url = $request->url;
        $website->save();
        
        return response()->json($website);
    }

    /**
     * Remove the specified website from storage.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        $website->delete();
        return response(null, 204);
    }
}