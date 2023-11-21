<form action="" method="post" class="vstack gap-2" enctype="multipart/form-data">
    @csrf
    @method($post ? 'POST' : 'PATCH')

    @include('shared.input',['label' => 'Titre', 'name' => 'title', 'placeholder' => 'Titre du produit', 'oldValue' => old('title', $product->title)])
        <div class="row">
            <div class="col">
                    @include('shared.input',['label' => 'Slug', 'name' => 'slug', 'placeholder' => 'Slug du produit', 'oldValue' => old('slug', $product->slug)])
                    @include('shared.input',['type' => 'file', 'label' => 'Image d\'illustration', 'name' => 'image'])
            </div>
        </div>
        <div class="row">
            <div class="col">
                    @include('shared.input',['label' => 'Description', 'name' => 'description', 'placeholder' => 'Description du produit', 'oldValue' => old('description', $product->description), 'area' => true])
            </div>
        </div>
        <div class="row">
            <div class="col">
                    @include('shared.input',['type' => 'number', 'label' => 'Prix', 'name' => 'price', 'placeholder' => '0', 'oldValue' => old('price', $product->price)])
                    <!-- TODO: Implement like table in db & checkbox like in this blade -->
            </div>
        </div>
        <div class="row">
            <div class="col">
                    @include('shared.select',['entities' => $categories, 'label' => 'Catégorie', 'optionPlaceholder' => 'une catégorie', 'id' => 'category', 'name' => 'category_id', 'oldValue' => old('category', $product->category_id)])

                    @php
                    $tagsIds = $product->tags()->pluck('id');
                    @endphp

                    @include('shared.select',['entities' => $tags, 'multiple' => true, 'pluckedIds' => $tagsIds, 'label' => 'Tags', 'optionPlaceholder' => 'un ou plusieurs tags', 'id' => 'tag', 'name' => 'tags[]', 'oldValue' => old('tags', $product->tags)])
            </div>
        </div>

    <button type="submit" class="btn btn-primary mb-2">
        @if($product->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
