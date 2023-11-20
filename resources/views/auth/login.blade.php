@extends("base")

@section("content")
    <h1>Se connecter</h1>
    <div class="bard">
        <div class="bard-body">
            <form action="{{ route('auth.login') }}" method="post" class="vstack gap-3">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="email" class="form-control" value="{{old('email')}}"/>
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="mot de passe" class="form-control" />
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <button class="btn btn-info" type="submit">Connexion</button>
            </form>
        </div>
    </div>

@endsection
