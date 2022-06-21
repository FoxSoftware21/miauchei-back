<style>
    .form-group {
        width: 50% !important;
    }
</style>

<div class="form-group">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control" placeholder="Nome:" value="{{ $user->name ?? old('name') }}">
</div>

<div class="form-group">
    <label>Telefone:</label>
    <input type="text" name="phone" class="form-control" placeholder="Telefone:"
        value="{{ $user->phone ?? old('phone') }}">
</div>

<div class="form-group">
    <img width="60" height="60" style="background: #ddd; border-radius: 5px;" id="img_url">
    <input name="photo" type="file" class="form-control" id="img_file" onChange="img_pathUrl(this);"
        value="{{ $pet->photo ?? old('photo') }}">
</div>

<div class="form-group">
    <label>E-mail:</label>
    <input type="email" name="email" class="form-control" placeholder="Nome:"
        value="{{ $user->email ?? old('email') }}">
</div>

<div class="form-group">
    <label>Senha:</label>
    <input type="password" name="password" class="form-control" placeholder="Senha:">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>

<script>
    function img_pathUrl(input) {
        $('#img_url')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
    }
</script>
