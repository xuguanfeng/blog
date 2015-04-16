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
    <div id="content" style="padding: 50px;">
        <p>
            {{ $page->body }}
        </p>
    </div>
@endsection