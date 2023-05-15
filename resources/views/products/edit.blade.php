@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>
                    @if (request()->route()->getName() == 'products.create')
                        Add Product
                    @else
                        Edit Product
                    @endif
                </h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="card p-3 mt-2">
            <form id="role-form"
                @if (request()->route()->getName() == 'products.create') action="{{ route('products.store') }}" 
                @else
                action="{{ route('products.update', $product->id) }}" @endif
                method="POST" enctype="multipart/form-data">
                @if (request()->route()->getName() != 'products.create')
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <x-forms.text-field label="Name" name="name"
                        value="{{ !empty($product->name) ? $product->name : old('name') }}" />
                    <x-forms.text-field label="Description" name="description"
                        value="{{ !empty($product->description) ? $product->description : old('description') }}" />
                    <x-forms.text-field type="number" label="Price" name="price"
                        value="{{ !empty($product->price) ? $product->price : old('price') }}" />
                    <x-forms.select-field label="Category" name="category_id" :options="$parentCategories"
                        value="{{ !empty($product->category_id) ? $product->category_id : old('category_id') }}" />
                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                        <div class="options-list">
                            @php
                                $options = !empty($product) ? $product->options : [];
                            @endphp
                            @if (count($options) > 0)
                                @foreach ($options['size'] as $key => $size)
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <input type="number" name="options[size][]" class="form-control"
                                                placeholder="Size" value="{{ $size }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="options[price][]" class="form-control"
                                                placeholder="Price" value="{{ $options['price'][$key] }}">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <input type="number" name="options[size][]" class="form-control"
                                            placeholder="Size">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="options[price][]" class="form-control"
                                            placeholder="Price">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a id="addMore" class="text-secondary" href="javascript:void();">{{ __('+ Add More') }}</a>
                    </div>
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
        if ($("#role-form").length > 0) {
            $("#role-form").validate({
                rules: {
                    'name': {
                        required: true,
                        maxlength: 255
                    },
                    'description': {
                        required: true,
                        maxlength: 255
                    },
                    'category_id': {
                        required: true,
                    },
                },
            })
        }

        $("#addMore").click(function(e) {
            e.preventDefault();
            var html = '<div class="row mt-2">' +
                '<div class="col-6">' +
                '<input type="number" name="options[size][]" class="form-control" placeholder="Size">' +
                '</div>' +
                '<div class="col-6">' +
                '<input type="number" name="options[price][]" class="form-control" placeholder="Price">' +
                '</div>' +
                '</div>' +
                '</div>';
            $('body').find('.options-list').append(html);
        });
    </script>
@endpush
