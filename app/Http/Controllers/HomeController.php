<?php namespace App\Http\Controllers;

use App\Http\Models\Admin\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogPostRequest;

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
        $pageArray=array();
        foreach ($pages as $page) {
//            var_dump((Page) $page);
            $pageArray[]=Page::find($page->id);
        }

//        var_dump($pages);
//        $pages = Page::all();
//        $pages = $pages->sortByDesc('updated_at');
        //return view('Home',["pages"=>Page::all()->sortByDesc('updated_at')->paginate(10)]);
        return view('Home',["pages"=>$pages,"pageArray"=>$pageArray]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.create',["user"=>Auth::user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //存储到DB
        $page = new Page;
        $page->title = $request->input('title');
        $page->body = $request->input('body');
        $page->user_id = $request->input('user_id');
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
//        $page=Page::find($id);
//        $user=$page->belongsToUser()->get();
//        var_dump(Page::find($id)->hasManyComments()->get());
        return view('pages.show',
            ['page'=>Page::find($id), 'comments'=>Page::find($id)->hasManyComments()->get()]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        //权限判定
//        if($page->user_id == Auth::user()->id){
//            return view('pages.edit',['page'=>$page]);
//        }
//        abort(403);
        return $page->user_id == Auth::user()->id ? view('pages.edit',['page'=>$page]) : abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(StoreBlogPostRequest $request, $id)
    {
        //验证title和body
//        $this->validate($request, [
////            'title' => 'required|unique:pages|max:255',
//            'title' => 'required|max:255',
//            'body' => 'required',
//        ]);
        //更新到DB
        $page = Page::find($id);
        //权限判定
        if($page->user_id !== Auth::user()->id){
            abort(403);
        }

        $page->title = $request->input('title');
        $page->body = $request->input('body');
        return $page->save() ? redirect()->to("/pages") :redirect()->back() ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postComment(Request $request)
    {
        //存储到DB
        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->user_id = $request->input('user_id');
        $comment->page_id = $request->input('page_id');
        if($comment->save()){
            return redirect()->to("/");
        }else{
            return redirect()->back();
        }
    }
}
