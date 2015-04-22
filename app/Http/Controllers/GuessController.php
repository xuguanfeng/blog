<?php namespace App\Http\Controllers;

//use App\Http\Models\Admin\Page;
//use App\Http\Models\Admin\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\BusinessClasses\Guess\GuessNum;
use App\Http\Models\Guess\Game;
use App\Http\Models\Guess\GuessHistory;
//use App\Http\Requests\StoreBlogPostRequest;

class GuessController extends Controller {

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
    public function init(Request $request)
    {
        $game = new Game;
        if($request->input("mode")=="0") {
            //初始化模式 mode=0
            $guess = new GuessNum();
            $game->answer = $guess->finalAnswer;//随机4个数字
            $game->user_id = Auth::user()->id;
            //存储到DB
            if ($game->save()) {
                return view('guess.singleplay',["game"=>$game]);
            } else {
                return redirect()->back();
            }
        }

        if($request->input("mode")=="-1") {
            //认输 显示答案 mode=-1
            $game = Game::find($request->input("gid"));
            return $game->touch() ? view('guess.singleplay',["game"=>$game]) : redirect()->back();
        }
//        var_dump($pages);
        return view('guess.singleplay',["game"=>$game]);
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function guess(Request $request)
    {
        $game = Game::find($request->input("game_id"));
        $number = $request->input("guessNum");
        $gn = new GuessNum();
        $result=$gn->matchAnswer($game->answer,$number);
        $gh = new GuessHistory();
        $gh->user_id = Auth::user()->id;
        $gh->game_id = $game->id;
        $gh->number=$number;
        $gh->result=$result;
        //todo 取得最大count,
        $gh->count=1;
        $gh->save();
        $response = array(
            'status' => 'success',
            'result' => $result,
        );

        return response()->json( $response );
    }
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
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
            ['page'=>Page::find($id), 'comments'=>Page::find($id)->hasManyComments()->orderBy('created_at','desc')->get()]);
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
            return redirect()->to("/pages/".$comment->page_id);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function deleteComment(Request $request)
    {
        //存储到DB
        $comment = Comment::find($request->route('commentId'));
//        var_dump($comment);
        if($comment->user_id == Auth::user()->id){
            return $comment->delete() ? redirect()->to("/pages/".$comment->page_id): redirect()->back();
        }
        abort(403) ;
//        if($comment->save()){
//            return redirect()->to("/pages/".$comment->page_id);
//        }else{
//            return redirect()->back();
//        }
    }
}
