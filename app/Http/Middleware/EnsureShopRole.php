<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsureShopRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $shop = $request->attributes->get('currentShop');

        if (!$shop) {
            abort(403, 'Shop context is missing.');
        }

        $membership = $request->user()
            ->shops()
            ->where('shops.id', $shop->id)
            ->first();

        if (!$membership || !in_array($membership->pivot->role, $roles, true)) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}