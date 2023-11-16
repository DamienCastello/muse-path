<form action="" method="post" class="vstack gap-2">
    @csrf
    @method($product ? 'PATCH' : 'POST')

    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" placeholder="Titre du produit" class="form-control" value="{{old('title', $product->title)}}"/>
        @error('title')
        {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" class="form-control" placeholder="Slug du produit" value="{{old('slug', $product->slug)}}" />
        @error('slug')
        {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" placeholder="Description du produit">{{old('description', $product->description)}}</textarea>
        @error('description')
        {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" placeholder="0" class="form-control" value="{{old('price', $product->price)}}"/>
        @error('price')
        {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select id="category" name="category_id" class="form-control">
            <option value="">Sélectionner une catégorie</option>
            @foreach($categories as $category)
                <option @selected(old('category_id', $product->category_id) == $category->id) value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @error('category_id')
        {{ $message }}
        @enderror
    </div>
    @php
    $tagsIds = $product->tags()->pluck('id');
    @endphp
    <div class="form-group">
        <label for="tag">Tags</label>
        <select id="tag" name="tags[]" class="form-control" multiple>
            @foreach($tags as $tag)
                <option @selected($tagsIds->contains($tag->id)) value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        </select>
        @error('tags')
        {{ $message }}
        @enderror
    </div>
    <button type="submit">
        @if($product->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
