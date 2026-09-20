<?php

namespace App\Http\Controllers;

use App\Enums\AppLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        $locale = AppLocale::from($locale);

        $request->session()->put('locale', $locale->value);
        $request->user()?->update(['locale' => $locale->value]);

        return redirect()->back(fallback: route('home'));
    }
}
