<?php

namespace App\Http\Controllers;

use App\Events\ContactRequestEvent;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\UserContactMail;
use App\Models\Comment;
use App\Models\Resource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
        /**
     * Display the specified user.
     */
    public function contact(User $user): RedirectResponse|View
    {

        return view('user.contact', [
            'user' => $user,
            'resource' => request()->resource
        ]);
    }

    public function mail(ContactRequest $request, User $user): RedirectResponse|View
    {
        $resource = Resource::find(request()->resource);
        $dest = User::query()->where('name', "=", $resource->resource_author)->first();
        //ContactRequestEvent::dispatch($resource, ['message' => $request->validated('message'), 'dest' => $dest->email, 'sender' => Auth::user()]);
        event(new ContactRequestEvent($resource, ['message' => $request->validated('message'), 'dest' => $dest->email, 'sender' => Auth::user()]));
        //Mail::send(new UserContactMail($resource, ['message' => $request->validated('message'), 'dest' => $dest->email, 'sender' => Auth::user()]));

        // TODO: Improve this code (duplicated with ResourceController)
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

        return redirect()->route('resource.show', [
            'user' => $user,
            'slug' => $resource->slug,
            'resource' => $resource,
            'comments' => $comments,
            'comment_elapsed_time' => $diffIntervals
        ])->with('success', 'Le mail a bien été envoyé');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
