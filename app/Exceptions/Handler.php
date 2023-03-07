<?php

namespace App\Exceptions;

use App\Helpers\Api\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

       $this->renderable(function (NotFoundHttpException $e, $request) {
           if ($request->is('api/*')) {
               if ($e->getPrevious() instanceof ModelNotFoundException) {
                   return (new Response())->error('Data not found', 404);
               }

               return (new Response())->error('Target not found', 404);
           }
       });

       $this->renderable(function (Exception $e, $request) {
           if ($request->is('api/*')) {
               if ($e->getPrevious() instanceof ModelNotFoundException) {
                   return (new Response())->error('Data not found', 404);
               }

               $msg = (!empty($e->getMessage())?$e->getMessage():'Oops something went wrong');
               return (new Response())->error($msg, 500);
           }
       });
    }
}
