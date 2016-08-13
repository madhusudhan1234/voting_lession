<ul class="list-group">
    @if(count($links))
        @foreach($links as $link)
            <li class="list-group-item">

                @if(Auth::check() && Auth::user()->votedFor($link))
                    +1
                @endif
                    
                <a href="/community/{{ $link->channel->slug }}" class="label label-default" style="background-color: {{ $link->channel->color }}">
                    {{ $link->channel->title }}
                </a>
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

{{ $links->links() }}
