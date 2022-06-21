<style>
    .form-group {
        width: 50% !important;
    }
</style>

<div class="form-group">
    <label>Status:</label>
    <input type="text" name="name" class="form-control" placeholder="Status:"
        value="{{ $status->name ?? old('name') }}">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
