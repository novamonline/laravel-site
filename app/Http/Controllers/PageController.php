<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\ViewModels\PageView;
use Illuminate\Http\Request;
use App\Http\Requests\Pages\PageRequest;

class PageController extends Controller
{

    public function __invoke(Request $request)
    {
        $url = $request->path();

        if($url == '/' || $url == 'index'){
            return view('welcome');
        }
        $Pages = Page::all();

        if($url == "pages") {
            $data = compact('Pages');
            return view('_pg.index', $data);
        }
        $Page = $Pages->where('url', $url)->first();

        if($request->edit == 'settings'){
            return redirect("pages/$Page->id/edit");
        }
        $data = compact('Page', 'Pages');

        if($request->edit == 'content'){
            return view("_pg.edit", $data);
        }

        return view("_pg.view", $data);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data['Pages'] = Page::all();

        if($request->ajax()) return $data;

        return view("_pg.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $viewModel = new PageView(
            $request->user()
        );
        if($request->ajax()) return $viewModel;
        $content = view('_pg.create', $viewModel);
        return view('_pg.show', compact('content'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $Page = new Page(['user_id' => $request->user()->id]);

        $data = $request->except('_token', '_time', 'method');

        foreach($data as $dbKey => $dbValue){
            $Page->$dbKey = $dbValue;
        }
        if($Page->save()){
            return redirect($Page->url)->with('success', 'Successfully created page');
        }
        return back()->withInput()->with('error', 'Error while creating page');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $viewModel = new PageView(
            $request->user(),
            Page::find($id)
        );

        if($request->ajax()) return $viewModel;

        $content = view('_pg.create', $viewModel);
        return view('_pg.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //

        $viewModel = new PageView(
            $request->user(),
            Page::find($id)
        );
        $content = view('_pg.create', $viewModel);
        return view('_pg.show', compact('content'));
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
        $Page = Page::find($id);
        $data = $request->except('_method');

        if($Page){
            foreach($data as $name => $value){
                $Page->$name = $value;
            }
            $Page->save();
        }
        return $Page;
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
