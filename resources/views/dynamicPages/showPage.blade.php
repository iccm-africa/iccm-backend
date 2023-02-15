@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10" style="background-color: white; border: 1px solid black;padding: 5px; border-radius: 5px;">
                {!! $page->html_content !!}
            </div>
        </div>
    </div>
@endsection
