<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackFormRequest;
use App\Http\Requests\FormTrackRequest;
use App\Http\Requests\SearchTracksRequest;
use App\Models\Feedback;
use App\Models\Genre;
use App\Notifications\FeedbackNotification;
use App\Notifications\LikeTrackNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ResizeImage;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Track::class, 'track');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchTracksRequest $request)
    {
        $query = Track::query();
        if ($request->validated('title')) {
            $query = $query->where('title', 'like', "%{$request->validated('title')}%");
        }
        return view('track.index', [
            'tracks' => $query->with(['genres', 'users'])->get()
            //'tracks' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::select('id', 'name')->get();
        return view('track.create', [
            'genres' => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormTrackRequest $request)
    {
        $track = Track::create($this->extractData(new Track(), $request));
        return to_route('track.show', ['track' => $track->id])->with('success', 'La track a bien été upload');
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $feedbacks = Feedback::query()->where('track_id', '=', $track->id)->with('track')->get();

        $diffIntervals = [];
        $now = Carbon::now();

        foreach ($feedbacks as $feedback) {
            $date = Carbon::parse($feedback->updated_at);

            if ($date->diffInSeconds($now)) $diff = "Il y a " . $date->diffInSeconds($now) . " seconde";
            if ($date->diffInMinutes($now)) $diff = "Il y a " . $date->diffInMinutes($now) . " minute";
            if ($date->diffInHours($now)) $diff = "Il y a " . $date->diffInHours($now) . " heure";
            if ($date->diffInDays($now)) $diff = "Il y a " . $date->diffInDays($now) . " jour";
            if ($date->diffInMonths($now)) $diff = "Il y a " . $date->diffInMonths($now) . " mois";
            if ($date->diffInYears($now)) $diff = "Il y a " . $date->diffInYears($now) . " année";

            if ($diff > 1 && !str_contains($diff, "mois")) {
                $diff = $diff . "s";
            }

            $diffIntervals[] = $diff;
        }
        return view('track.show', ['track' => $track, 'feedbacks' => $feedbacks, 'feedback_elapsed_time' => $diffIntervals]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Track $track)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Track $track)
    {
        //
    }

    public function like($trackID)
    {
        $track = Track::query()->with(['users'])->where('id', $trackID)->first();
        $track->users()->toggle(Auth::id());

        $track->user->notify(new LikeTrackNotification($track, Auth::user()->toArray(), $track->users->contains(Auth::user())));

        if ($track->users->contains(Auth::user())) {
            return to_route('track.index')->with('success', 'La track a bien été supprimé de vos likes');
        } else {
            return to_route('track.index')->with('success', 'La track a bien été ajouté à vos likes');
        }
    }

    /**
     * Store a newly created feedback attached to track.
     */
    public function feedback(FeedbackFormRequest $request, string $trackID)
    {
        $feedback = Feedback::create(array_merge($request->validated(), [
            'user_id' => Auth::user()->id,
            'track_id' => $trackID
        ]));
        $feedback->loadMissing([
            "user",
            "track.user",
        ]);
        $feedbackNotification = new FeedbackNotification($feedback);
        $feedback->track->user->notify($feedbackNotification);


        return redirect()->route('track.show', ['track' => $trackID])->with('success', 'Feedback envoyé à l\'artiste');
    }

    private function extractData(Track $track, FormTrackRequest $request): array
    {
        $data = $request->validated();

        $image = $request->validated('image');

        if ($image !== null) {
            $image = $request->validated('image');
            $resizedImage = ResizeImage::make($request->file('image'))->resize(300, 200);
            $imageName = time() . '.' . $request->image->extension();
            $data['image'] = Auth::user()->id . '/image/' . $imageName;
            $resizedImage->save($imageName);
            Storage::disk('users-data')->putFileAs(Auth::user()->id . "/image", $resizedImage->basePath(), $imageName);
        }


        $track = $request->validated('music');
        $musicName = time() . '.' . $request->music->extension();
        $data['music'] = Auth::user()->id . '/music/' . $musicName;
        //Storage::disk('public')->putFileAs("music", $track, $musicName);
        Storage::disk('users-data')->putFileAs(Auth::user()->id . "/music", $track, $musicName);

        $data['user_id'] = Auth::user()->id;

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track)
    {
        $track = Track::find($track->id);
        if ($track->image) {
            Storage::disk('users-data')->delete($track->image);
        }
        Storage::disk('users-data')->delete($track->music);
        $track->delete();
        return to_route('resource.index')->with('success', 'La track a bien été supprimée');
    }
}
