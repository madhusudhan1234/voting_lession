@if(Auth::check())
<div class="col-md-4">
    <h3>Contribute a Link</h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <form action="{{ url('community') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group {{ $errors->has('channel_id') ? 'has-error' : '' }}">
                    <label for="channel_id">Channel</label>
                    <select name="channel_id" id="" class="form-control">
                        <option  selected disabled>Pick a Channel</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }} "  {{ old('channel_id') == $channel->id ? 'selected' : 0 }} >
                                {{ $channel->title }}
                            </option>
                        @endforeach
                    </select>

                    {!! $errors->first('channel_id','<span class="help-block">:message </sapn>') !!}
                </div>

                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title">Title</label>
                    <input type="text"
                           id="title"
                           name="title"
                           class="form-control"
                           placeholder="What is the title of your article ?"
                           value="{{ old('title') }}"
                    >
                    {!! $errors->first('title','<span class="help-block">:message </sapn>') !!}
                </div>

                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="link">Link</label>
                    <input
                            type="text"
                            id="link"
                            name="link"
                            class="form-control"
                            placeholder="What is the URL ?"
                            value="{{ old('link') }}"
                    >
                    {!! $errors->first('link','<span class="help-block">:message </sapn>') !!}
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">
                        Contribute Link
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
    @else
    <p>Please Login</p>
@endif