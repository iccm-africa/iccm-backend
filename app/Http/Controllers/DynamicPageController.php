<?php

namespace App\Http\Controllers;

use App\DynamicPage;
use App\Http\Requests\StoreDynamicPageRequest;
use App\Http\Requests\UpdateDynamicPageRequest;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pageSize = 10;
        $dynamicPages = DynamicPage::orderBy('order', 'asc')->paginate($pageSize);
        $offset = ($dynamicPages->currentPage() - 1) * $pageSize;
        $view_data['dynamicPages'] = $dynamicPages;
        $view_data['offset'] = $offset;
        return view('dynamicPages.index')->with($view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dynamicPages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDynamicPageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDynamicPageRequest $request)
    {
        //
        DynamicPage::create([
            'html_content' => $request['html_content'],
            'order' => $request['order'],
            'menu_title' => $request['menu_title'],
        ]);
        $name = $request['menu_title'];
        return redirect()->route('dynamicPages.index')->with('success', 'Page ' . $name . ' was created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DynamicPage  $dynamicPage
     * @return \Illuminate\Http\Response
     */
    public function show(DynamicPage $dynamicPage)
    {
        //
        return view('dynamicPages.show')->with('dynamicPage', $dynamicPage);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DynamicPage  $dynamicPage
     * @return \Illuminate\Http\Response
     */
    public function edit(DynamicPage $dynamicPage)
    {
        //
        return view('dynamicPages.edit')->with('dynamicPage', $dynamicPage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDynamicPageRequest  $request
     * @param  \App\DynamicPage  $dynamicPage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDynamicPageRequest $request, DynamicPage $dynamicPage)
    {
        //
        $dynamicPage->update($request->all());
        $name = $dynamicPage->menu_title;
        return redirect()->route('dynamicPages.index')->with('success', 'Dynamic page ' . $name . ' was successful updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DynamicPage  $dynamicPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DynamicPage $dynamicPage)
    {
        //
        $name = $dynamicPage->menu_title;
        // Heir muss noch Prüfung geschehen, ob Eiinheit schon verwendet ist für Fahrzeuge
        $dynamicPage->delete();

        return redirect()->route('dynamicPages.index')->with('success', 'The page ' . $name . ' is successful deleted');
    }
    public function showPage($id){
        // dd($id);
        $page=DynamicPage::find($id);
        // return $page->html_content; 
        return view('dynamicPages.showPage')->with('page', $page);
    }
}
