<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Http\Requests\FormResourceRequest;
use App\Http\Requests\SearchResourcesRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Notifications\CommentNotification;
use App\Notifications\LikeResourceNotification;
use App\Notifications\LikeTrackNotification;
use Carbon\Carbon;
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
        if ($request->validated('title')) {
            $query = $query->where('title', 'like', "%{$request->validated('title')}%");
        }
        return view('resource.index', [
            'resources' => $query->with(['user', 'tags', 'category'])->recent()->paginate(3)
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
    public function store(FormResourceRequest $request)
    {
        $resource = Resource::create($this->extractData(new Resource(), $request));
        return redirect()->route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id])->with('success', 'La ressource a bien été sauvegardé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Resource $resource): RedirectResponse|View
    {
        // TODO: Improve this code (duplicated with ProfileController)
        $comments = Comment::query()->where('resource_id', '=', $resource->id)->with('user')->get();

        $diffIntervals = [];
        $now = Carbon::now();

        foreach($comments as $comment){
            $date = Carbon::parse($comment->updated_at);

            if($date->diffInSeconds($now)) $diff = "Il y a ".$date->diffInSeconds($now)." seconde";
            if($date->diffInMinutes($now)) $diff = "Il y a ".$date->diffInMinutes($now)." minute";
            if($date->diffInHours($now)) $diff = "Il y a ".$date->diffInHours($now)." heure";
            if($date->diffInDays($now)) $diff = "Il y a ".$date->diffInDays($now)." jour";
            if($date->diffInMonths($now)) $diff = "Il y a ".$date->diffInMonths($now)." mois";
            if($date->diffInYears($now)) $diff = "Il y a ".$date->diffInYears($now)." année";

            if($diff > 1 && !str_contains($diff, "mois")){
                $diff = $diff."s";
            }

            $diffIntervals[] = $diff;
        }

        if ($resource->slug != $slug) {
            return to_route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id]);
        }
        return view('resource.show', [
            'resource' => $resource,
            'users' => User::select('id')->get(),
            'comments' => $comments,
            'comment_elapsed_time' => $diffIntervals
        ]);
    }

    /**
     * Store a newly created comment attached to resource.
     */
    public function comment(CommentFormRequest $request, string $slug, string $resourceID)
    {
        $comment = Comment::create(array_merge($request->validated(), [
            'user_id' => Auth::user()->id,
            'resource_id' => $resourceID
        ]));
        $comment->loadMissing([
            "user",
            "resource.user",
        ]);
        $commentNotification = new CommentNotification($comment);
        $comment->resource->user->notify($commentNotification);
        return redirect()->route('resource.show', ['slug' => $slug,  'resource' => $resourceID])->with('success', 'La ressource a bien été commentée');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($resourceID)
    {
        $resource = Resource::query()->with(['users'])->where('id', $resourceID)->first();
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
    public function update(FormResourceRequest $request, Resource $resource)
    {
        $resource->update($this->extractData($resource, $request));
        $resource->tags()->sync($request->validated('tags'));
        return redirect()->route('resource.show', ['slug' => $resource->slug, 'resource' => $resource->id])->with('success', 'La ressource a bien été modifié');
    }

    /**
     * Update linked data of specified resource in storage.
     */
    public function like($resourceID)
    {
        $resource = Resource::query()->with(['users'])->where('id', $resourceID)->first();
        $resource->users()->toggle(Auth::id());

        $resource->user->notify(new LikeResourceNotification($resource, Auth::user()->toArray(), $resource->users->contains(Auth::user())));

        if ($resource->users->contains(Auth::user())) {
            return to_route('resource.index')->with('success', 'La ressource a bien été supprimé de vos likes');
        } else {
            return to_route('resource.index')->with('success', 'La ressource a bien été ajouté à vos likes');
        }
    }

    private function extractData(Resource $resource, FormResourceRequest $request): array
    {
        $image = $request->validated('image');
        $data = $request->validated();
        //$data = $request->safe();
        $data['user_id'] = Auth::user()->id;
        if ($request->method() === "PATCH" && $request->input('like') == 1) {
            $resource->users()->attach(Auth::user()->id);
            unset($data['like']);
        } else {
            $resource->users()->detach(Auth::user()->id);
            unset($data['like']);
        }

        if ($image === null) {
            return $data;
        } else {
            $path = public_path('storage\\resource\\');
            $name = time() . '.' . $request->image->extension();
            ResizeImage::make($request->file('image'))
                ->resize(300, 200)
                ->save($path . $name);
            $img = ResizeImage::make('storage\\resource\\' . $name);

            if ($resource->image) {
                Storage::disk('public')->delete($resource->image);
            }
            $data['image'] = 'resource/' . $img->basename;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $resource = Resource::find($resource->id);
        if ($resource->image) {
            Storage::disk('public')->delete($resource->image);
        }
        $resource->delete();
        return to_route('resource.index')->with('success', 'La ressource a bien été supprimé');
    }
}
