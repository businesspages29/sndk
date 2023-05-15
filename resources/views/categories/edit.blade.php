@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'categories.create')
                        Add Category
                    @else
                        Edit Category
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('categories.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">

            <form id="ajaxForm"
                @if (request()->route()->getName() == 'categories.create') data-action="{{ route('categories.store') }}" 
                @else
                data-action="{{ route('categories.update', $category->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'categories.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <div id="errors-list"></div>
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($category->name) ? $category->name : old('name') }}" />
                    <x-forms.select-field label="Parent" name="parent_id" :options="$parentCategories"
                        value="{{ !empty($category->parent_id) ? $category->parent_id : old('parent_id') }}" />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('form[id="ajaxForm"]').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#ajaxForm').attr('data-action'),
                        data: $('#ajaxForm').serialize(),
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            var message = data.message;
                            $(".alert").remove();
                            $("#errors-list").append("<div class='alert alert-success'>" +
                                message + "</div>");
                            @if (request()->route()->getName() == 'categories.create')
                                $("#ajaxForm").trigger('reset');
                            @endif
                        },
                        error: function(jqXHR, exception) {
                            var errorresponse = JSON.parse(jqXHR.responseText);
                            $(".alert").remove();
                            $.each(errorresponse.data, function(key, val) {
                                $("#errors-list").append(
                                    "<div class='alert alert-danger'>" + val +
                                    "</div>");
                            });
                        },
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
