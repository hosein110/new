@if ($errors->has($name))
    <div class="alert alert-danger">
        {{ $errors->first($name) }}
    </div>
@endif
