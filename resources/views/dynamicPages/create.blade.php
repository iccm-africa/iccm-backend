@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10">
                <h3>Create new dynamic Page</h3>
            </div>
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ route('dynamicPages.index') }}">Back to list (without saving)</a>
            </div>
        </div>
        @if ($errors->any())
            <div class="row pt-2">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error Occured!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="row mt-2">
            <div class="col-12">
                <form method="POST" action="{{ route('dynamicPages.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="menuTitle" class="form-label">Menu title of dynamic page</label>
                        <input type="text" class="form-control" id="menuTitle" name="menu_title"
                            placeholder="Enter menu title">
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order number</label>
                        <input type="text" class="form-control" id="sort" name="order"
                            placeholder="Enter order number">
                    </div>
                    <div class="mb-3">
                        <label for="htmlContent" class="form-label">HTML content</label>
                        <textarea class="form-control" id="htmlContent" name="html_content" rows="20" cols="100"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
