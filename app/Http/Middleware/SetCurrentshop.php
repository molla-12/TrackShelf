<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentshop
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $shopId = $request->session()->get('current_shop_id');

        $shop = $user->shops()
            ->where('shops.is_active', true)
            ->when(
                $shopId,
                fn ($query) => $query->where('shops.id', $shopId),
                fn ($query) => $query->orderBy('shops.id')
            )
            ->first();

        if (!$shop) {
            abort(403, 'You do not have access to an active shop.');
        }

        $request->attributes->set('currentShop', $shop);

        return $next($request);
    }
}
