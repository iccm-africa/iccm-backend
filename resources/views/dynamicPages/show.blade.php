@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10">
                <h3>Show dynamic Page</h3>
            </div>
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ route('dynamicPages.index') }}">Return to list</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                    <div class="mb-3">
                        <label for="menuTitle" class="form-label">Menu title of dynamic page</label>
                        <input type="text" class="form-control" id="menuTitle" name="menu_title"
                        value="{{ $dynamicPage->menu_title }}"
                            placeholder="Enter menu title" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order number</label>
                        <input type="text" class="form-control" id="sort" name="order"
                        value="{{ $dynamicPage->order }}"
                            placeholder="Enter order number" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="htmlContent" class="form-label">HTML content</label>
                        <div style="background-color: white; border: 1px solid black;padding: 5px; border-radius: 5px;">
                            {!! $dynamicPage->html_content !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
