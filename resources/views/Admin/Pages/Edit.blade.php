@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑 Page</div>

                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>出错啦</strong> <br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ URL('admin/pages/'.$page->id) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="_method" type="hidden" value="PUT">
                            <input type="text" name="title" class="form-control"max="255" required="required" value="{{$page->title}}">
                            <br>
                            <textarea name="body" rows="10" class="form-control" required="required">{{$page->body}}</textarea>
                            <br>
                            <button class="btn btn-lg btn-info">编辑 Page</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection