<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Constants\UserTypeConstant;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Gate;

final class FirstLoginMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = auth()->user();

        if ((int) $user->type === UserTypeConstant::NEEDED_CHANGE_PASSWORD) {
            return redirect()->route('auth.password.change');
        }
        return $next($request);
    }
}
