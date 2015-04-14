@extends('_layouts.default')

@section('content')
    <h4>
        <table width="100%">
            <tr >
                <td width="60%">
                    <a href="/">⬅️返回首页</a>
                </td>
                <td width="40%" align="right">
                    <a href="{{ URL('pages/'.$page->id.'/edit') }}" class="btn btn-success">编辑</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <h1 style="text-align: center; margin-top: 50px;">{{ $page->title }}</h1>
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