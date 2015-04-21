@extends('guess.common')

@section('content')
    {{--<h4>--}}
        {{--<table width="100%">--}}
            {{--<tr >--}}
                {{--<td width="40%" style="text-align:left; margin-left: 10px; padding: 10px;">--}}
                    {{--@if (Auth::user()->id == $page->user_id)--}}
                        {{--<a href="{{ URL('pages/'.$page->id.'/edit') }}" class="btn btn-success">编辑</a>--}}
                    {{--@endif--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td colspan="2" align="center">--}}
                    {{--<h1 style="text-align: center; padding: 10px;">{{ $page->title }}</h1>--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    {{--</h4>--}}
{{--    {{ var_dump($game->updated_at)}}--}}
    <h1 style="text-align: center; padding: 10px;">
        @if ($game->answer == null)
            请初始游戏
        @elseif($game->created_at == $game->updated_at)
            ★★★★
        @else
            再接再厉，答案是<br/>{{$game->answer}}
        @endif

    </h1>
    <div id="date" style="text-align: right; padding: 10px;">
        @if ($game->answer == null)
            &nbsp;&nbsp;<a href="{{ URL('guess/singleplay/?mode=0') }}" class="">初始游戏</a>
        @elseif($game->created_at == $game->updated_at)
            &nbsp;&nbsp;<a href="{{ URL('guess/singleplay/?mode=-1&gid='.$game->id) }}" class="">认输，看答案</a>
        @else
            &nbsp;&nbsp;<a href="{{ URL('guess/singleplay/?mode=0') }}" class="">初始游戏</a>
        @endif
    </div>

    <hr>
    <div id="content" style="padding: 10px; padding: 10px;">
        <p>
            {{--{{ $page->body }}--}}
        </p>
    </div>
    {{--@foreach ($comments as $comment)--}}
        {{--<hr>--}}
            {{--<div class="body">--}}
                {{--<table width = "100%">--}}
                    {{--<tr>--}}
                        {{--<td width="100%" style="padding: 10px;">--}}
                            {{--昵称：{{$comment->belongsToUser()->get()[0]->name}}&nbsp;&nbsp;--}}
                            {{--@if ($comment->updated_at == $comment->created_at)--}}
                                {{--回复于：{{ substr($comment->created_at,0,16) }}--}}
                            {{--@else--}}
                                {{--修改于：{{ substr($comment->updated_at,0,16) }}--}}
                            {{--@endif--}}
                            {{--@if ($comment->user_id == Auth::user()->id)--}}
                                {{--&nbsp;&nbsp;<a href="{{ URL('pages/deleteComment/'.$comment->id) }}" class="">删除评论</a>--}}
                            {{--@endif--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td width="100%" align="left" style="padding: 10px;">--}}
                            {{--<a href="{{ URL('comments/'.$comment->id) }}">--}}
                                {{--{{ $comment->body }}--}}
                            {{--</a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--</table>--}}
            {{--</div>--}}
    {{--@endforeach--}}
    {{--<hr>--}}
    {{--<div id="content" style="padding: 10px;">--}}
        {{--<form action="{{ URL('/pages/postComment') }}" method="POST">--}}
            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
            {{--<input type="hidden" name="page_id" value="{{ $page->id }}">--}}
            {{--<textarea name="body" rows="10" class="form-control" required="required" style="padding: 10px;"></textarea>--}}
            {{--<br>--}}
            {{--<button class="btn btn-lg btn-info">回复</button>--}}
        {{--</form>--}}
    {{--</div>--}}
@endsection