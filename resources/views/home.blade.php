@extends('_layouts.default')

@section('content')
    <div id="title" style="text-align: center;">
        <h1>Blog</h1>
        <div style="padding: 5px; font-size: 16px;">{{ Inspiring::quote() }}</div>
    </div>
    <hr>
    <div id="content">
        <ul>
            <a href="{{ URL('/pages/create') }}" class="btn btn-lg btn-primary">发帖</a><br>
            @foreach ($pages as $page)
                <li style="margin: 50px 0;">
                    <div class="title">
                        <table width = "100%">
                            <tr>
                                <td width="70%"><a href="{{ URL('pages/'.$page->id) }}">
                                        <h4>{{ $page->title }}</h4>
                                    </a></td>
                                <td width="30%" align="right">
                                    更新于：{{ substr($page->updated_at,0,16) }}
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="body">
                        <p>{{ $page->body }}</p>
                    </div>
                </li>
            @endforeach
            <?php echo $pages->render(); ?>
        </ul>
    </div>
@endsection