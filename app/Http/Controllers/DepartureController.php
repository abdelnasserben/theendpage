<?php

namespace App\Http\Controllers;

use App\Models\DeparturePage;
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
        $session = $request->session()->all();
        $data = array_merge(
            $session['wizard']['step1'] ?? [],
            $session['wizard']['step2'] ?? [],
            $session['wizard']['step3'] ?? [],
            $session['wizard']['step4'] ?? []
        );
        $validated = validator($data, [
            'tone' => 'required|string',
            'message' => 'required|string',
            'gif' => 'nullable|url',
            'sound' => 'nullable|url',
            'anonymous' => 'boolean',
            'release_at' => 'nullable|date',
        ])->validate();

        $slugBase = Str::slug(Str::limit($validated['message'], 30, ''));
        $slug = $slugBase;
        $i = 1;
        while (DeparturePage::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$i}";
            $i++;
        }

        $page = DeparturePage::create(array_merge($validated, ['slug' => $slug]));
        $request->session()->forget('wizard');
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
}
