<?php

namespace App\Providers;

use App\Models\User;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    $user = JWT::decode($token, $secret, array("HS256"));
                } catch (ExpiredException $e) {
                    throw new ExpiredException('token_expired');
                } catch (Exception $e) {
                    throw new Exception('token_invalid');
                }
                return User::query()->where("id", $user->data->id)->first();
            }
            if ($request->path() !== 'api/login') {
                throw new BeforeValidException('token_absent');
            }
        });
    }
}
