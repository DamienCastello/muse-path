<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Http\Requests\SearchResourcesRequest;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image as ResizeImage;

class ResouceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchResourcesRequest $request): View
    {
        $query = Resource::query();

        if($request->validated('title')){
            $query = $query->where('title', 'like', "%{$request->validated('title')}%");
        }

        return view('resource.index', [
            'resources' => $query->with(['users', 'tags', 'category'])->orderBy('created_at', 'desc')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $resource = new Resource();
        return view('resource.create', [
            'resource' => $resource,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
            'post' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormPostRequest $request)
    {
        $resource = Resource::create($this->extractData(new Resource(), $request));

        return redirect()->route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id])->with('success', 'La ressource a bien été sauvegardé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Resource $resource): RedirectResponse | View
    {
        if ($resource->slug != $slug){
            return to_route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id]);
        }
        return view('resource.show', [
            'resource' => $resource,
            'users' => User::select('id')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($resourceID)
    {
       $resource = Resource::query()->where('id', $resourceID)->first();
        return view('resource.edit', [
            'resource' => $resource,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
            'post' => false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormPostRequest $request, Resource $resource)
    {
        $resource->update($this->extractData($resource, $request));
        $resource->tags()->sync($request->validated('tags'));
        return redirect()->route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id])->with('success', 'La ressource a bien été modifié');
    }

        public function like($resourceID)
    {
        $resource = Resource::query()->with(['users'])->where('id', $resourceID)->first();

        $resource->users()->toggle(Auth::id());

        if($resource->users->contains(Auth::user())){
            return to_route('resource.index')->with('success', 'La ressource a bien été ajouté à vos likes');
        } else {
            return to_route('resource.index')->with('success', 'La ressource a bien été supprimé de vos likes');
        }
    }

    private function extractData(Resource $resource, FormPostRequest $request):array
    {
        $image = $request->validated('image');
        $data = $request->validated();
        $data['resource_author'] = Auth::user()->name;

        if($request->method() === "PATCH"){
            $resource->users()->toggle(Auth::id());
            unset($data['like']);
        }


        if($image === null) {
            return $data;
        } else {
            $path = public_path('storage\\resource\\');
            $name = time() . '.' . $request->image->extension();
            ResizeImage::make($request->file('image'))
                ->resize(300, 200)
                ->save($path . $name);

            $img = ResizeImage::make('storage\\resource\\'.$name);


            if($resource->image) {
                Storage::disk('public')->delete($resource->image);
            }

            $data['image'] = 'resource/'.$img->basename;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $resource = Resource::find($resource->id);
        $resource->delete();
        return to_route('resource.index')->with('success', 'La ressource a bien été supprimé');
    }
}
