@if(isset($ratings) && $ratings->count() > 0)
    @foreach($ratings as $rating)
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="profile-img">
                    <img class="img-fluid"
                         src="{{asset($rating->profile_pic ? $rating->profile_pic : 'assets/images/default-pp.png')}}"
                         alt="">
                </div>

                <div>
                    <span class="d-block ru-name mt-3">{{$rating->user->name}}</span>
                    <span class="d-block">{{\Carbon\Carbon::createFromTimeStamp(strtotime($rating->created_at))->diffForHumans()}}</span>
                </div>
            </div>

            <div class="col-md-9">
                <blockquote>
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $rating->rate)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </blockquote>

                <blockquote>
                    {{$rating->review}}
                </blockquote>
            </div>
        </div>
    @endforeach

    <div class="load-more-button-div">
        @if($ratings->hasMorePages())
            <button class="load-more-button">Load More <i class="fa fa-spin fa-spinner load-more-spinner"></i></button>
        @endif
    </div>
@endif