@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8">

            <h1>Community</h1>
            <ul class="Links">
                @if(count($links))
                    @foreach($links as $link)
                        <li class="Links__link">
                            <span class="label label-default" style="background-color: {{ $link->channel->color }}">
                                {{ $link->channel->title }}
                            </span>
                            <a href="{{ $link->link }}" target="_blank">
                                {{ $link->title }}
                            </a>

                            <small>
                                Contributed By:{{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                @else
                    <h4>No Contributions Yet</h4>
                @endif
            </ul>

        </div>

        @include('community.add-link')

    </div>

@endsection