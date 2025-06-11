<?php

namespace App\Exceptions;

use Exception;
use Throwable; // Import Throwable as good practice

class RajaOngkirApiException extends Exception
{
    protected $statusCode;
    protected $rajaOngkirMessage;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, int $statusCode = 500, string $rajaOngkirMessage = '')
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->rajaOngkirMessage = $rajaOngkirMessage;
    }

    /**
     * Report the exception.
     * This method is automatically called by Laravel's exception handler.
     * You can log it, send to Sentry/Bugsnag, etc.
     */
    public function report()
    {
        // Log the exception to a specific channel or add more context
        \Log::error("Raja Ongkir API Error: " . $this->getMessage(), [
            'status_code' => $this->statusCode,
            'rajaongkir_message' => $this->rajaOngkirMessage,
            'trace' => $this->getTraceAsString(),
        ]);
    }

    /**
     * Render the exception into an HTTP response.
     * This method is automatically called by Laravel's exception handler.
     */
    public function render($request)
    {
        // If it's an API request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
                'rajaongkir_error' => $this->rajaOngkirMessage,
                'status' => $this->getCode(), // Custom error code if you define one
            ], $this->statusCode); // Use the custom status code
        }

        // For web requests, you might show a custom error view
        return response()->view('errors.rajaongkir-api-error', [
            'message' => $this->getMessage(),
            'rajaongkir_error' => $this->rajaOngkirMessage,
        ], $this->statusCode);
    }

    /**
     * Get the HTTP status code for the response.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get the original message from Raja Ongkir API, if available.
     *
     * @return string
     */
    public function getRajaOngkirMessage(): string
    {
        return $this->rajaOngkirMessage;
    }
}
