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

class GuessController extends Controller
{

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
        if ($request->input("mode") == "0") {
            //初始化模式 mode=0
            $guess = new GuessNum();
            $game->answer = $guess->finalAnswer;//随机4个数字
            $game->user_id = Auth::user()->id;
            //存储到DB
            if ($game->save()) {
                return view('guess.singleplay', ["game" => $game]);
            } else {
                return redirect()->back();
            }

        }
        if ($request->input("mode") == "-1") {
            //认输 显示答案 mode=-1
            $game = Game::find($request->input("gid"));
            return $game->touch() ? view('guess.singleplay', ["game" => $game]) : redirect()->back();
        }
//        var_dump($pages);
        return view('guess.singleplay', ["game" => $game]);
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
        $result = $gn->matchAnswer($game->answer, $number);
        $gh = new GuessHistory();
        $gh->user_id = Auth::user()->id;
        $gh->game_id = $game->id;
        $gh->number = $number;
        $gh->result = $result;
        //取得最大count,
        $maxCount = DB::table('guess_histories')
            ->select(DB::raw('max(count) as maxCount'))
            ->where('user_id', Auth::user()->id)
            ->where('game_id', $game->id)
            ->pluck('maxCount');
//        var_dump($maxCount);
        $gh->count = $maxCount == null ? 1 : $maxCount + 1;
        $gh->save();
        $response = array(
            'status' => 'success',
            'result' => $result,
        );
        return response()->json($response);
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function autoPlay(Request $request)
    {
        $finalAnswer = $request->input("finalAnswer");
        $gn = new GuessNum();
        $gn->autoPlay($finalAnswer, $gn->allNumMap);
//        Log::warning("aa");
//        Log::warning($gn->autoPlayRecord);
//        var_dump($gn->autoPlayRecord);
        $response = array(
            'status' => 'success',
            'result' => $gn->autoPlayRecord,
        );
        return response()->json($response);

    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function initPc()
    {
        return view('guess.autoplay');
    }
}
