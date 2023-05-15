@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Product</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div>
                <b>Name: </b> {{ $product->name }}
            </div>
            <div>
                <b>Slug: </b> {{ $product->slug }}
            </div>
            <div>
                <b>Description: </b> {{ $product->description }}
            </div>
            <div>
                <b>Price: </b> {{ $product->price }}
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div class="row">
                <div id="errors-list"></div>
                <form class="d-flex align-items-center" id="ajaxForm" action="javascript:void(0)" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-6">
                        <x-forms.text-field type="file" label="Image" name="image" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    </div>
                </form>
            </div>
            <div class="row product-image">
                @foreach ($product->images as $image)
                    <div class="col-12 col-md-3 col-lg-3">
                        <img class="img-thumbnail" src="{{ $image->image_url }}" alt="">
                        <button class="delete" data-id="{{ $image->id }}">
                            Delete</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#ajaxForm').validate({
                rules: {
                    image: {
                        required: true,
                    },
                },
                submitHandler: function(form) {
                    var newForm = $('#ajaxForm');
                    var formData = new FormData(newForm[0]);
                    formData.append('image', $('input[type=file]')[0].files[0]);
                    $.ajax({
                        url: "{{ route('products.uploadimage', $product->id) }}",
                        data: formData,
                        type: "POST",
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            var html =
                                '<div class="col-12 col-md-3 col-lg-3 delete" id="' + data
                                .data.id + '"><img class="img-thumbnail" src="' +
                                data.data.image + '" alt=""></div>';
                            $('body').find('.product-image').append(html);
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
                }
            });

            $('body').on('click', '.delete', function() {
                if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('products.image') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#datatable-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
