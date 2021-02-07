<?php


namespace App\Support\BlogPost;


use App\Support\Services\BlogPost\BlogPostsImportService;
use Exception;
use ReflectionObject;

class BlogPostsImport
{
    public static function service(): BlogPostsImportService
    {
        return new BlogPostsImportService();
    }

    public static function __callStatic($method, $arguments)
    {
        $service = static::service();
        if (!method_exists($service, $method)) {
            $message = sprintf(
                "Method %s does not exist on class %s",
                $method,
                (new ReflectionObject($service))->getName()
            );

            throw new Exception($message);
        }

        return static::service()->{$method}(...$arguments);
    }
}
