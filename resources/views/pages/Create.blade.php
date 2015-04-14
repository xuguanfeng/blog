@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">发帖</div>

                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>出错啦</strong><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ URL('/pages') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="text" name="title" class="form-control" required="required">
                            <br>
                            <textarea name="body" rows="10" class="form-control" required="required"></textarea>
                            <br>
                            <button class="btn btn-lg btn-info">发帖</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection