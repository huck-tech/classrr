@extends('user_layout')

@section('tab_content')


<div class="row">
    <div class="col-md-12">
        <div class="class-list">
            @forelse($classrooms as $item)
                <div class="strip_all_tour_list">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">

                            <div class="img_list"><a href="{{ route('classroom_show', ['id' => $item['id']]) }}"><img src="{{ $item->getThumb() }}" alt="Image">
                                    <div class="short_info"></div>
                                </a>
                            </div>
                        </div>
                        <div class="clearfix visible-xs-block"></div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="tour_list_desc">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ str_limit($item['description'], 130) }}</p>
                                <div class="row">
                                    <div class="col-xs-6"><i class="icon-calendar-empty"></i>
                                        <strong>Start:</strong> {{ $item['enrollment_date'] }}</div>
                                    <div class="col-xs-6"><i class="icon-signal-4"></i>
                                        <strong>Level:</strong> {{ $item['level']['title'] }}</div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-xs-6"><i class="icon-back-in-time"></i>
                                        <strong>Duration:</strong> {{ $item['duration']['title'] }}</div>
                                    <div class="col-xs-6"><i class="icon-users"></i>
                                        <strong>Students:</strong> {{ $item['number_student'] }}</div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="price_list"><div><sup>$</sup>{{ $item['base_price'] }} <small >Base price</small>
                                    <p>
                                        <a href="{{ route('classroom_show', ['id' => $item['id']]) }}" class="ctrl btn btn-xs btn-info">Details</a>
                                        <a href="{{ route('classroom_edit', ['id' => $item['id']]) }}" class="ctrl btn btn-xs btn-info">Edit</a>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div><!--End strip -->
            @empty
                <h3 class="text-center">{!! trans('messages.empty_classrooms', ['link' => route('classroom_create')]) !!}</h3>
            @endforelse

            <div class="row">
                <div class="col-md-12">
                    <hr>

                    <div class="text-center">
                        {{ $classrooms->links() }}
                    </div><!-- end pagination-->
                </div>
            </div>

        </div><!-- end class-list -->

    </div>

</div>




@endsection