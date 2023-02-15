@extends('layouts.app')

@section('title')
    Dynamic Pages
@endsection

@section('content')
    <script>
        $(document).ready(function() {
            $(".btn-delete").on("click", function(e) {
                var atr = this.getAttribute("atrId");
                var formSelector = "#frm-del-" + atr;
                strContent = "Do you really want to delete?";
                $.confirm({
                    title: 'Confirmation',
                    content: strContent,
                    theme: 'bootstrap',
                    animation: 'scale',
                    type: 'orange',
                    buttons: {
                        OK: function() {
                            $(formSelector).submit();
                        },
                        Abbrechen: function() {}
                    }
                });
            });
        });
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dynamic Pages') }}</div>

                    <div class="card-body">


                        <div class="col-12 text-end">
                            <a class="btn btn-success" href="{{ route('dynamicPages.create') }}"><i class="fa-solid fa-plus"></i>
                                Add new dynamic Page</a>
                        </div>
                    </div>
                    @if ($message = Session::get('error'))
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ $message }}!</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ $message }}!</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row pt-2">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order</th>
                                        <th scope="col">Menu Title</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dynamicPages->count() > 0)
                                        @foreach ($dynamicPages as $dynamicPage)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $offset }}</td>
                                                <td>{{ $dynamicPage->order }}</td>
                                                <td>{{ $dynamicPage->menu_title }}</td>
                                                <td>
                                                    <form action="{{ route('dynamicPages.destroy', $dynamicPage->id) }}"
                                                        method="POST" id="frm-del-{{ $dynamicPage->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a class="btn btn-secondary"
                                                        href="{{ route('dynamicPages.show', $dynamicPage->id) }}">Show</a>
                                                    <a class="btn btn-primary"
                                                        href="{{ route('dynamicPages.edit', $dynamicPage->id) }}">Edit</a>
                                                    <button class="btn btn-danger btn-delete"
                                                        atrId="{{ $dynamicPage->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">No data yet!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {!! $dynamicPages->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
