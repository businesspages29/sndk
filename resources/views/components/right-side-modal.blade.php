<div class="modal fade" id="{{ $target }}" tabindex="-1" aria-labelledby="{{ $target }}Label"
    {{ $attributes->class(['id']) }} aria-hidden="true">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form enctype="multipart/form-data"
                {{ $attributes->merge(['id' => '#', 'action' => '#', 'method' => 'post']) }}>
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="{{ $target }}Label">
                        {{ $title }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $body }}
                </div>
                <div class="modal-footer">
                    {{ $footer }}
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
