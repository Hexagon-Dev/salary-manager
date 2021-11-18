<?php

namespace App\Http\Controllers;

use App\Services\AbstractService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $serviceInterface;

    protected AbstractService $service;

    /** @var Authenticatable|Model|null  */
    protected $user;

    /**
     * @param Authenticatable|null $user
     * @throws Throwable
     */
    public function __construct(?Authenticatable $user = null)
    {
        $this->user = $user;
        $this->service = app()->make($this->serviceInterface);
    }
}
