<?php

namespace App\Http\Controllers;

use App\Models\DeparturePage;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DepartureController extends Controller
{
    public function wizard()
    {
        return view('departure.wizard');
    }

    public function storeStep(Request $request)
    {
        $step = $request->input('step');
        $data = $request->except('_token');
        $request->session()->put("wizard.step{$step}", $data);
        return response()->json(['next' => true]);
    }

    public function store(Request $request)
    {
        // 1. Validation de base (sans anonymous)
        $validated = $request->validate([
            'tone'          => 'required|string',
            'message'       => 'required|string',
            'gif'           => 'nullable|url',
            'sound'         => 'nullable|url',
            'author_name'   => 'nullable|string|max:255',
            'author_email'  => 'nullable|email|max:255',
            'release_at'    => 'nullable|date',
        ]);

        // 2. Boolean selon la checkbox
        $isAnonymous = $request->has('anonymous');

        // 3. Génération du slug limité
        $slugBase = Str::slug(Str::limit($validated['message'], 50, ''));
        $slug = $slugBase;
        $i = 1;
        while (DeparturePage::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$i}";
            $i++;
        }

        // 4. Création
        $page = DeparturePage::create([
            'slug'          => $slug,
            'tone'          => $validated['tone'],
            'message'       => $validated['message'],
            'gif'           => $validated['gif'] ?? null,
            'sound'         => $validated['sound'] ?? null,
            'anonymous'     => $isAnonymous,
            'author_name'   => $isAnonymous ? null : ($validated['author_name'] ?? null),
            'author_email'  => $isAnonymous ? null : ($validated['author_email'] ?? null),
            'release_at'    => $validated['release_at'] ?? null,
            'user_id'      => auth()->id(),
        ]);

        // 5. Redirection
        return redirect()->route('departure.show', ['slug' => $page->slug]);
    }



    public function show($slug)
    {
        $page = DeparturePage::where('slug', $slug)->firstOrFail();

        if ($page->release_at && Carbon::parse($page->release_at)->isFuture()) {
            return view('departure.coming', ['release' => $page->release_at]);
        }

        return view('departure.show', compact('page'));
    }

    public function commenter(Request $request, $slug)
    {
        $page = DeparturePage::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'author'  => 'nullable|string|max:50',
            'content' => 'required|string|max:500',
        ]);
        $page->comments()->create($data);
        return redirect()->route('departure.show', ['slug' => $slug])
            ->with('success', 'Commentaire ajouté !');
    }

    public function comment(Request $request, $slug)
    {
        $page = DeparturePage::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'author'  => 'nullable|string|max:50',
            'content' => 'required|string|max:500',
        ]);

        $commentData = [
            'user_id'  => auth()->id(),
            'author'   => auth()->check()
                ? auth()->user()->name
                : ($data['author'] ?? 'Anonyme'),
            'content'  => $data['content'],
        ];

        $page->comments()->create($commentData);

        return redirect()
            ->route('departure.show', ['slug' => $slug])
            ->with('success', 'Commentaire ajouté !');
    }


    public function vote(Request $request, $slug)
    {
        $page = DeparturePage::where('slug', $slug)->firstOrFail();
        Vote::firstOrCreate([
            'departure_page_id' => $page->id,
            'voter_ip'         => $request->ip(),
        ]);
        return back()->with('success', 'Votre vote est comptabilisé !');
    }

    public function hallOfFame()
    {
        $pages = DeparturePage::withCount('votes')
            ->orderByDesc('votes_count')
            ->take(10)
            ->get();
        return view('departure.hall_of_fame', compact('pages'));
    }
}
