<div
    @if (!empty($class)) class="{{ $class }}"
    @else
    class="col-xs-12 col-sm-12 col-md-12" @endif>
    <div class="form-group">
        <strong>{{ $label }}:</strong>
        @if (!empty($type) && $type == 'textarea')
            <textarea class="form-control" name="{{ $name }}" cols="10" rows="10" placeholder="{{ $label }}"
                @if (!empty($value)) value="{{ $value }}" @endif>{{ !empty($value) ? $value : '' }}</textarea>
        @else
            <input @if (!empty($type)) type="{{ $type }}" @else type="text" @endif
                name="{{ $name }}" class="form-control" placeholder="{{ $label }}"
                @if (!empty($value)) value="{{ $value }}" @endif>
        @endif
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
