<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Admin\Page;

use Illuminate\Http\Request;

class PagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.pages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        //验证title和body
        $this->validate($request, [
//            'title' => 'required|unique:pages|max:255',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        //存储到DB
		$page = new Page;
        $page->title = $request->input('title');
        $page->body = $request->input('body');
        $page->user_id = 1;
        if($page->save()){
            return redirect()->to("/admin");
        }else{
            return redirect()->back();
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return view('pages.show',['page'=>Page::find($id)]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return view('admin.pages.edit',['page'=>Page::find($id)]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        //验证title和body
        $this->validate($request, [
//            'title' => 'required|unique:pages|max:255',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        //更新到DB
		$page = Page::find($id);
        $page->title = $request->input('title');
        $page->body = $request->input('body');
        return $page->save() ? redirect()->to("/admin") :redirect()->back() ;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        //删除
        $page = Page::find($id);
        //return Page::destroy($id) ? redirect()->to("/admin") :redirect()->back() ;
        return $page->delete() ? redirect()->to("/admin") :redirect()->back() ;
	}

}
