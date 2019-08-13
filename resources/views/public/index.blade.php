@extends("public.layouts")

@section("header_title")
<h1>Blog </h1> {{$postRecent['0']['title'] }}
@endsection

@section("content")
    <img src="{{ $postRecent[0]['image']}}">
    <h2 class="title">{{$postRecent[0]['title'] }}</h2>
    <time class="date-publisher">{{date("d/m/Y H:i", strtotime($postRecent[0]['created_at']))}}</time>
    <div class="content" style="color: #8c979e; line-height: 2.0">
       <p> {{ $postRecent[0]['content'] }}</p>
    </div>

    <div class="row col-8">

            <form action="{{ route('public.comment.create') }}" method="post">
                @csrf
                <input class='d-none' type="text" name="post_id" value="{{ $postRecent[0]['id'] }}">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Comment</label>
                    <textarea class="form-control" name="comment" rows="8" cols="50"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
    </div>
@endsection
