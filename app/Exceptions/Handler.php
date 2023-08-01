<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    private $apiEndpoint = "api/*";
    private $validationError = 'Input Validation Failed!!';

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
    }

    public function render($request, Throwable $exception)
    {
        if ($response = $this->renderMissingInputException($request, $exception)) {
            return $response;
        }
        return parent::render($request, $exception);
    }

    /**
     * renderMissingInputException
     *
     * @param  mixed $request
     * @param  mixed $exception
     * @return void
     */
    public function renderMissingInputException($request, Throwable $exception)
    {
        if ($exception instanceof MissingInputException && $request->is($this->apiEndpoint)) {
            return response()->json([
                'error' => $this->validationError,
                'message' => $exception->getMessage(),
                'fields' => $exception->getFields()
            ], $exception->status);
        }

        if ($exception instanceof ValidationException && $request->expctsJson()) {
            return response()->json([
                'error' => $this->validationError,
                'messages' => $exception->errors()
            ], $exception->status);
        }
        return null;
    }
}
