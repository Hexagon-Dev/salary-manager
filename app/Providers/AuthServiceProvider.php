<?php

namespace App\Providers;

use App\Models\User;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     * @throws Exception
     */
    public function boot()
    {
        Auth::viaRequest('custom-jwt', function (Request $request) {
            $token = $request->bearerToken();
            $secret = env('JWT_SECRET');

            if ($token) {
                try {
                    $user = JWT::decode($token, $secret, ["HS256"]);
                } catch (Throwable $e) {
                    throw new BeforeValidException($e->getMessage());
                }
                return User::query()->where("id", $user->data->id)->first();
            }

            return null;
        });
    }
}
