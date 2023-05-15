<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>{{ $label }}:</strong>
        <select name="{{ $name }}" class="form-control">
            <option value="">{{ __('Select Option') }}</option>
            @if (is_array($options) && count($options) > 0)

                @foreach ($options as $key => $option)
                    <option value="{{ $key }}" @if (!empty($value) && $key == $value) selected @endif>
                        {{ $option }}</option>
                @endforeach
            @endif
        </select>
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
