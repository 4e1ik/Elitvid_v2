<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class WebResponse
{
    /**
     * Успешный ответ — возвращает переданный результат (redirect, view, json).
     */
    public static function success($response)
    {
        return $response;
    }

    /**
     * Ошибка — логирует исключение и отдаёт 404.
     * Для админки ($admin = true) — страница в шаблоне админки, иначе — обычная 404.
     */
    public static function error(Exception $exception, bool $admin = false)
    {
        Log::error('WebResponse: ' . $exception->getMessage(), [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        if ($admin) {
            return response()->view('errors.404_admin', [], Response::HTTP_NOT_FOUND);
        }

        abort(Response::HTTP_NOT_FOUND);
    }
}
