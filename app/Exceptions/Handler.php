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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {

        $rendered = parent::render($request, $exception);
        $errorcode = $rendered->getStatusCode();

        switch ($errorcode) {
            case 204:
                $message = 'No Content Found!';
                break;
            case 404:
                $message = 'This Record Not Found!';
                break;
            case 405:
                $message = 'This Method Not Allowed!';
                break;
            
            default:
                $message = $exception->getMessage();
        }

        return response()->json([
                'status' => $errorcode,
                'message' => $message
            ], $errorcode);

        //return parent::render($request, $exception);
    }
}
