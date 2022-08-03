@props(['errors'])

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>
            {{ __('Whoops! Something went wrong.') }}
        </strong>

        <ul class="">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
