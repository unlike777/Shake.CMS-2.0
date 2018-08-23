<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        ErrorMessage::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     * @return void
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ErrorMessage) {
            if ($request->ajax()) {
                return response()->json(['error' => ['text' => $e->getMessage(), 'code' => $e->getCode()]]);
            } else {
                if (request()->header('referer')) {
                    return redirect()->back()->withErrors(['errors' => $e->getMessage()])->withInput();
                }
            }
        }
        
        if ($e instanceof ValidationException) {
            if ($request->ajax()) {
                return response()->json(['error' => ['text' => $e->validator->getMessageBag()->first(), 'code' => $e->getCode()]]);
            }
        }

        if (!($e instanceof ValidationException)) {
            $exception = FlattenException::create($e);
            if ($e instanceof ModelNotFoundException) {
                $exception->setStatusCode(404);
            }
            $code = $exception->getStatusCode($exception);

            if (!config('app.debug')) {
                return response()->view('errors.default', ['exception' => $e, 'code' => $code], $code);
            }
        }
        
        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
