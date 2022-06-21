<style>
    .form-group {
        width: 50% !important;
    }
</style>

<div class="form-group">
    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" placeholder="Nome:" value="{{ $pet->nome ?? old('nome') }}">
</div>

<div class="form-group">
    <img width="60" height="60" style="background: #ddd; border-radius: 5px;" id="img_url">
    <input name="foto" type="file" class="form-control" id="img_file" onChange="img_pathUrl(this);"
        value="{{ $pet->foto ?? old('foto') }}">
</div>

<div class="form-group">
    <div class="form-check">
        <input class="form-check-input" type="radio" name="sexo" id="flexRadioDefault1" value="Macho" checked>
        <label class="form-check-label" for="flexRadioDefault1">
            Macho
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="sexo" id="flexRadioDefault2" value="Fêmea">
        <label class="form-check-label" for="flexRadioDefault2">
            Fêmea
        </label>
    </div>
</div>

<div class="form-group">
    <label for="species" class="form-label">Espécie:</label>
    <input class="form-control" list="list-species" name="especie" id="species"
        placeholder="Escreva para pesquisar..." value="{{ $pet->especie ?? old('especie') }}">
    <datalist id="list-species">
        <option value="Cachorro">
        <option value="Gato">
        <option value="Hamster">
        <option value="Coelho">
        <option value="Tartarugas">
    </datalist>
</div>

<div class="form-group">
    <label for="breed" class="form-label">Raça:</label>
    <input class="form-control" list="list-breed" name="raca" id="breed"
        value="{{ $pet->raca ?? old('raca') }}" placeholder="Escreva para pesquisar...">
    <datalist id="list-breed">
        <option value="Vira Lata">
        <option value="Akita">
        <option value="Basset hound">
        <option value="Beagle">
        <option value="Bichon frisé">
        <option value="Boiadeiro australiano">
        <option value="Border collie">
        <option value="Boston terrier">
        <option value="Boxer">
        <option value="Buldogue francês">
        <option value="Buldogue inglês">
        <option value="Bull terrier">
        <option value="Cane corso">
        <option value="Cavalier king charles spaniel">
        <option value="Chihuahua">
        <option value="Chow chow">
        <option value="Cocker spaniel inglês">
        <option value="Dachshund">
        <option value="Dálmata">
        <option value="Doberman">
        <option value="Dogo argentino">
        <option value="Dogue alemão">
        <option value="Fila brasileiro">
        <option value="Golden retriever">
        <option value="Husky siberiano">
        <option value="Jack russell terrier">
        <option value="Labrador retriever">
        <option value="Lhasa apso">
        <option value="Lulu da pomerânia">
        <option value="Maltês">
        <option value="Mastiff inglês">
        <option value="Mastim tibetano">
        <option value="Pastor alemão">
        <option value="Pastor australiano">
        <option value="Pastor de Shetland">
        <option value="Pequinês">
        <option value="Pinscher">
        <option value="Pit bull">
        <option value="Poodle">
        <option value="Pug">
        <option value="Rottweiler">
        <option value="Schnauzer">
        <option value="Shar-pei">
        <option value="Shiba">
        <option value="Shih tzu">
        <option value="Staffordshire bull terrier">
        <option value="Weimaraner">
        <option value="Yorkshire">
    </datalist>
</div>

<div class="form-group">
    <label for="size" class="form-label">Tamanho:</label>
    <input class="form-control" list="list-size" name="tamanho" id="size"
        value="{{ $pet->tamanho ?? old('tamanho') }}" placeholder="Escreva para pesquisar...">
    <datalist id="list-size">
        <option value="Pequeno">
        <option value="Médio">
        <option value="Grande">
    </datalist>
</div>

<div class="form-group">
    <label for="predominant" class="form-label">Cor Predominante:</label>
    <input class="form-control" list="list-predominant" name="cor_predominante" id="predominant"
        value="{{ $pet->cor_predominante ?? old('cor_predominante') }}" placeholder="Escreva para pesquisar...">
    <datalist id="list-predominant">
        <option value="Preto">
        <option value="Branco">
        <option value="Marrom">
        <option value="Amarelo">
    </datalist>
</div>

<div class="form-group">
    <label for="secondary" class="form-label">Detalhes Físico:</label>
    <textarea class="form-control" name="detalhes_fisicos" placeholder="Detalhes Físico"
        value="{{ $pet->detalhes_fisicos ?? old('detalhes_fisicos') }}" style="height: 100px">{{ $pet->detalhes_fisicos ?? old('detalhes_fisicos') }}</textarea>
</div>

<div class="form-group">
    <label>Data de Desaparecimento:</label>
    <input type="date" name="data_desaparecimento" class="form-control"
        value="{{ $pet->data_desaparecimento ?? old('data_desaparecimento') }}">
</div>

<div class="form-group">
    <label>Última vez visto:</label>
    <input type="text" name="ultima_vez_visto" class="form-control" placeholder="Rua:"
        value="{{ $pet->ultima_vez_visto ?? old('ultima_vez_visto') }}">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>


<script>
    function img_pathUrl(input) {
        $('#img_url')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
    }
</script>
