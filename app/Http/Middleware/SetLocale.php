<?php

namespace App\Http\Middleware;

use App\Enums\AppLocale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Apply the interface language: this session's choice, then the user's saved preference,
 * then the application default.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = AppLocale::tryFrom((string) $request->session()->get('locale'))
            ?? AppLocale::tryFrom((string) $request->user()?->locale);

        if ($locale) {
            app()->setLocale($locale->value);
        }

        return $next($request);
    }
}
