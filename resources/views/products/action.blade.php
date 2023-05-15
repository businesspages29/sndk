<a href="{{ route('products.show', $id) }}" data-toggle="tooltip" data-original-title="View"
    class="edit btn btn-primary view">
    View
</a>
<a href="{{ route('products.edit', $id) }}" data-toggle="tooltip" data-original-title="Edit"
    class="edit btn btn-success edit">
    Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete"
    class="delete btn btn-danger">
    Delete
</a>
