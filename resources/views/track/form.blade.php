<form action="" method="post" class="vstack gap-2" enctype="multipart/form-data">
    @csrf
    @method('POST')
    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
    <x-input label="Titre" name="title" placeholder="Titre de la track"/>
    <div class="row">
        <div class="col">
            <x-input label="Image d'illustration" name="image" type="file"/>
            <x-input label="Track à upload" name="music" type="file" accept="audio/*"/>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @include('shared.input',['label' => 'Description', 'name' => 'description', 'placeholder' => '', 'area' => true])
            @include('shared.select',['entities' => $genres, 'multiple' => true, 'label' => 'Genres', 'id' => 'genre', 'name' => 'genres[]'])
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-2">
            Upload
    </button>
</form>
