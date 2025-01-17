<form action="" method="post" class="vstack gap-2" enctype="multipart/form-data">
    @csrf
    @method($post ? 'POST' : 'PATCH')
    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
    <x-input label="Titre" name="title" placeholder="Titre de la ressource" :oldValue="old('title', $resource->title)"/>
    <div class="row">
        <div class="col">
            @include('shared.input',['label' => 'Slug', 'name' => 'slug', 'placeholder' => 'Slug de la ressource', 'oldValue' => old('slug', $resource->slug)])
            @include('shared.input',['type' => 'file', 'label' => 'Image d\'illustration', 'name' => 'image'])
        </div>
    </div>
    <div class="row">
        <div class="col">
            @include('shared.input',['label' => 'Description', 'name' => 'description', 'placeholder' => 'Description de la ressource', 'oldValue' => old('description', $resource->description), 'area' => true])
            @include('shared.input',['label' => 'Lien vers le site source', 'name' => 'link', 'placeholder' => 'https://xferrecords.com/', 'oldValue' => old('link', $resource->link)])
        </div>
    </div>
    <div class="row">
        <div class="col">
            @include('shared.input',['type' => 'number', 'label' => 'Prix', 'name' => 'price', 'placeholder' => '0', 'oldValue' => old('price', $resource->price)])
        </div>
    </div>
    <div class="row">
        <div class="col">
            @include('shared.select',['entities' => $categories, 'label' => 'Catégorie', 'id' => 'category', 'name' => 'category_id', 'oldValue' => old('category', $resource->category_id)])

            @php
                $tagsIds = $resource->tags()->pluck('id');
            @endphp

            @include('shared.select',['entities' => $tags, 'multiple' => true, 'pluckedIds' => $tagsIds, 'label' => 'Tags', 'id' => 'tag', 'name' => 'tags[]', 'oldValue' => old('tags', $resource->tags)])
        </div>
    </div>

    @if(!$post)
        <div class="d-flex justify-content-start mb-5">
            @php
                $usersIds = $resource->users()->pluck('id');
                $value = $usersIds->contains(function (int $value) {
                    return $value === Auth::user()->id ? true : false;
                });
            @endphp

            @include('shared.checkbox', ['label' => 'Like', 'name' => 'like', 'value' => $value])
        </div>
    @endif


    <button type="submit" class="btn btn-primary mb-2">
        @if($resource->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
