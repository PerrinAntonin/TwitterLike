@extends('layout')
@section('content')

    <p class="big-name " id="big_nameProfil">Profil</p>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                    <img src="/uploads/banners/{{ $user->banner }}" class="banner-style">
                    <img src="/uploads/avatars/{{ $user->avatar }}" class="avatar_style ">
                    <h2 class="profil-name">{{ $user->name }}</h2>
                <div class="editfollow-style">
                    @if(Auth::user()==$user)
                        <div class="edit d-inline-block mr-4">
                            <a href="{{route("profile.edit",$user->id)}}" class="btn-hover1 text-banner-style">Editer</a>
                        </div>
                    @endif
                    <a href="{{ route('user.follow', $user->id )}}" class="mr-2 btn-hover1 text-banner-style">Follow User</a>
                    <a href="{{ route('user.unfollow', $user->id )}}"  class="btn-hover1 text-banner-style">Unollow User</a>
                </div>

            </div>



            <div class="blog-post mx-auto mt-4 col-8">
                <div class=" card-style1 card p-4 py-4  " >
                    <p class="info-css">city</p>
                    <p style="text-align: center">{{ $user->city }}</p>
                    <p class="info-css">link</p>
                    <p style="text-align: center">{{ $user->link }}</p>
                    <p class="info-css"> user description</p>
                    <p style="text-align: center">{{ $user->description }}</p>
                </div>
                @foreach ($user->posts as $post)
                <div class=" card-style1 card p-4 py-4  mt-4 ">
                    <div class="post mx-3 post-css" data-postid="{{$post->id}}">
                        <div>
                            <a href="{{route("profile.show",$post->user->id)}}">
                                <img src="/uploads/avatars/{{ $post->user->avatar }}" width="50px" height="50px" class="rounded-circle photo-style1 ">
                            </a>
                            <a href="{{route("profile.show",$post->user->id)}}" class=" col-3 profilename "> {{$post->user->name}}</a>
                        </div>
                        <h6 class="offset-1 date-style">{{$post->created_at}}</h6>

                        <p>{{$post->body}}</p>
                        <a href="{{ route('retweet', ['user_id' => Auth::user()->id,'post_id' => $post->id]) }}" class="color_rouge">Retweet</a>
                        <div class="interaction my-3 color_rouge ">
                            @if (Auth::check())
                                <a href="#" class="like fas fa-thumbs-up color_rouge ml-1">{{Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like==1 ? '':'':''}}</a>
                                <a href="#" class="like fas fa-thumbs-down color_rouge ml-3">{{Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like==0 ? ' ':'':''}}</a>
                            @else
                                <p>faut se connecter pour liker</p>
                            @endif
                                @if(Auth::user()==$post->user)
                                    <a href="#" class="edit color_rouge ml-4">Edit</a>
                                    <a href="{{ route('post.delete', ['post_id' => $post->id]) }}" class="color_rouge">Delete</a>
                                @endif
                        </div>

                    </div>
                </div>
                @endforeach
                <div>
                    <h1>Retweets:</h1>
                    @foreach ($user->retweets as $retweets)
                        <div class="post mx-3 post-css" data-postid="{{$retweets->post->id}}">
                            <div>
                                <a href="{{route("profile.show",$retweets->post->user->id)}}">
                                    <img src="/uploads/avatars/{{ $retweets->post->user->avatar }}" width="50px" height="50px" class="rounded-circle photo-style1 ">
                                </a>
                                <a href="{{route("profile.show",$retweets->post->user->id)}}" class=" col-3 profilename "> {{$retweets->post->user->name}}</a>
                            </div>
                            <h6 class="offset-1 date-style">{{$retweets->post->created_at}}</h6>

                            <p>{{$retweets->post->body}}</p>
                            <div class="interaction my-3 color_rouge ">
                                @if (Auth::check())
                                    <p class="d-inline">{{count($retweets->post->likes)}}</p>
                                    <a href="#" class="like fas fa-thumbs-up color_rouge ml-1">{{Auth::user()->likes()->where('post_id',$retweets->post->id)->first() ? Auth::user()->likes()->where('post_id',$retweets->post->id)->first()->like==1 ? '':'':''}}</a>
                                    <a href="#" class="like fas fa-thumbs-down color_rouge ml-3">{{Auth::user()->likes()->where('post_id',$retweets->post->id)->first() ? Auth::user()->likes()->where('post_id',$retweets->id)->first()->like==0 ? ' ':'':''}}</a>
                                @else
                                    <p>faut se connecter pour liker</p>
                                @endif
                                @if(Auth::user()==$retweets->post->user)
                                    <a href="#" class="edit color_rouge ml-4">Edit</a>
                                    <a href="{{ route('post.delete', ['post_id' => $retweets->post->id]) }}" class="color_rouge">Delete</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Post</h4>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="post-body">Edit the Post</label>
                                    <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script src="{{asset('/js/like.js')}}" type="text/javascript"></script>
            <script type="text/javascript">
                var token ='{{Session::token()}}';
                var urlLike = '{{route('like')}}';
                var urlEdit = '{{ route('edit') }}';
            </script>
        </div>
    </div>

    @endsection