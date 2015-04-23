@extends('guess.common')

@section('content')
    <h1 style="text-align: center; padding: 10px;">

        <input type="text" name="finalAnswer" id="finalAnswer" class="form-control-static" maxlength="4" size="4"
               required="required" value="">
        &nbsp;&nbsp;
        {{--<div class=""id="illegalNum"></div>--}}
        <label class="" id="illegalNum"></label>

        <div class="btn btn-lg btn-info" id="pcplay">电脑开猜</div>
{{--        <a href="{{ URL('/guess/autoguess?finalAnswer=1234')}}">1234guess</a>--}}

    </h1>

    <hr>
    <div id="content" style="padding: 10px; padding: 10px; width: 40%">
        @for ($i = 0; $i < 20; $i++)
            <p>
            <form action="" method="POST" id={{"form"}}>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" name="pcguessNum" class="form-control-static" maxlength="4" size="12"
                       required="required" value="">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="badge" id={{"pclabel"}}>?A?B</div>
            </form>
            </p>
        @endfor
    </div>
@endsection