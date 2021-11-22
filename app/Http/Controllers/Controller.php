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

    protected string $serviceInterface = '';

    protected ?AbstractService $service;

    /** @var Authenticatable|Model|null  */
    protected $user;

    /**
     * @param Authenticatable|null $user
     * @throws Throwable
     */
    public function __construct(?Authenticatable $user = null)
    {
        $this->user = $user;
        if ($this->serviceInterface) {
            $this->service = app()->make($this->serviceInterface);
        }
    }

    /**
     * @SWG\Swagger(
     *   schemes={"http"},
     *   host="localhost:8000",
     *   basePath="/",
     *   @SWG\Info(
     *     title="Salary Manager",
     *     version="1.0.0"
     *   )
     * )
     * @OA\Info(
     *      version="0.1.0",
     *      title="Salary Manager",
     *      description="CRUD&Permisson+Role system.",
     *      @OA\Contact(
     *          email="Hexagon14@mail.ru"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Main API Server"
     * )

     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of Projects"
     * )
     */
}
