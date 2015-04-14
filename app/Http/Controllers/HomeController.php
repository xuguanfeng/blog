<?php namespace App\Http\Controllers;

use App\Http\Models\Admin\Page;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
//		return view('home');
        $pages = DB::table("pages")->orderBy('updated_at', 'desc')->paginate(10);
//        $pages = Page::all();
//        $pages = $pages->sortByDesc('updated_at');
        //return view('Home',["pages"=>Page::all()->sortByDesc('updated_at')->paginate(10)]);
        return view('Home',["pages"=>$pages]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.create');
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
            return redirect()->to("/");
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
        return view('pages.edit',['page'=>Page::find($id)]);
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
        return $page->save() ? redirect()->to("/pages") :redirect()->back() ;
    }
}
