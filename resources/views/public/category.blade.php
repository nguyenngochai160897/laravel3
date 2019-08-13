@extends("public.layouts")

@section("header_title")
<h1>Category</h1> {{$category_name}}
@endsection

@section("content")
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-6 mb-5">
                <img src="{{ $post['image'] }}">
                <h2 class="title">{{$post['title'] }}</h2>
                <time class="date-publisher">{{date("d/m/Y H:i", strtotime($postRecent[0]['updated_at']))}}</time>
                <div class="snapshort" style="color: #8c979e; line-height: 1.8">
                <p> {{ $postRecent[0]['snapshort'] }}</p>
                </div>
                <p style="background: #745cf9; width:45%; color:#fff; padding: 10px 20px">
                    <a class="read-more" style="color:wheat; font-weight: 600;" href="{{ route('public.post', ['id' => $post['id']]) }}">Read more
                        <span class="meta-nav">→</span>
                    </a>
                </p>
            </div>
        @endforeach
    </div>
@endsection
