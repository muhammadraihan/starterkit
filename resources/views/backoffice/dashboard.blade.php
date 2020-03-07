@extends('layouts.page')

@section('title','Dashboard')

@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Introduction
        <small>
            A brief introduction to this {{env('APP_NAME')}}
        </small>
    </h1>
</div>
<div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
    <h3 class="mb-g">
        Hi {{Auth::user()->name}},
    </h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Faucibus interdum posuere lorem ipsum dolor sit amet. Venenatis urna cursus eget nunc scelerisque
        viverra mauris. At in tellus integer feugiat scelerisque. Eu sem integer vitae justo eget magna. Volutpat
        blandit aliquam etiam erat velit scelerisque in. Amet luctus venenatis lectus magna fringilla. Non tellus orci
        ac auctor augue mauris. Egestas fringilla phasellus faucibus scelerisque eleifend donec. Elit duis tristique
        sollicitudin nibh sit amet.
    </p>
    <p>
        Sincerely,<br>
        {{env('APP_DEVELOPER')}} Team<br>
    </p>
</div>
@endsection