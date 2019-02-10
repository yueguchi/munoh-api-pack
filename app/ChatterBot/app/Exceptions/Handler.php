<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    
    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $message = $e->getMessage();
        if ($status === 405) {
            $message = 'Method Not Allowed.';
        }
        if ($status === 500) {
            \Log::error("{$status}: {$e->getMessage()}");
            $message = 'Internal Server Error.';
        }
        return response()->json([
          'status' => $status,
          'message' => $message
        ], $status);
    }
}
