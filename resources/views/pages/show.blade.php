@extends('app')

@section('content')
    {{--{{ var_dump($page) }}--}}
    <h4>
        <table width="100%">
            <tr >
                {{--<td width="60%">--}}
                    {{--<a href="/">⬅️返回首页</a>--}}
                {{--</td>--}}
                <td width="40%" style="text-align:left; margin-left: 10px;">
                    @if (Auth::user()->id == $page->user_id)
                        <a href="{{ URL('pages/'.$page->id.'/edit') }}" class="btn btn-success">编辑</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <h1 style="text-align: center; margin-top: 10px;">{{ $page->title }}</h1>
                </td>
            </tr>
        </table>
    </h4>

    <hr>
    <div id="date" style="text-align: right;">
        {{ $page->updated_at }}
    </div>
    <div id="content" style="padding: 10px;">
        <p>
            {{ $page->body }}
        </p>
    </div>
    @foreach ($comments as $comment)
        <hr>
            <div class="body">
                <table width = "100%">
                    <tr>
                        <td width="100%">
                            昵称：{{$comment->belongsToUser()->get()[0]->name}}&nbsp;&nbsp;
                            @if ($comment->updated_at == $comment->created_at)
                                回复于：{{ substr($comment->created_at,0,16) }}
                            @else
                                修改于：{{ substr($comment->updated_at,0,16) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="left">
                            <a href="{{ URL('comments/'.$comment->id) }}">
                                {{ $comment->body }}
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
    @endforeach
    <hr>
    <form action="{{ URL('/pages/postComment') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="page_id" value="{{ $page->id }}">
        <textarea name="body" rows="10" class="form-control" required="required"></textarea>
        <br>
        <button class="btn btn-lg btn-info">回复</button>
    </form>
@endsection