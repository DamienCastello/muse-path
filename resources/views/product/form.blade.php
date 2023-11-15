<form action="" method="post" class="vstack gap-2">
    @csrf
{{--    @method($product->id ? 'PATCH' : 'POST')--}}
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
    <button type="submit">
        @if($product->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
