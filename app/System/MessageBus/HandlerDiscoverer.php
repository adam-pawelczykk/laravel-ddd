<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use ReflectionClass;

readonly class HandlerDiscoverer
{
    public function __construct(
        private Filesystem $files
    ) {
    }

    public function discover(string $basePath): array
    {
        $handlers = [];

        foreach ($this->files->allFiles($basePath) as $file) {
            // Skip non-PHP files
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $className = $this->resolveClassFromFile($file->getPathname());

            // Skip if class name is not valid or does not end with 'Handler'
            if (!$className || !Str::endsWith($className, 'Handler')) {
                continue;
            }

            // Skip if class does not exist
            if (!class_exists($className)) {
                continue;
            }

            $reflector = new ReflectionClass($className);

            // Skip if class does not have an __invoke method
            if (!$reflector->hasMethod('__invoke')) {
                continue;
            }

            $param = $reflector->getMethod('__invoke')->getParameters()[0] ?? null;

            // Skip if the first parameter does not have a type
            if (!$param?->getType()) {
                continue;
            }

            $messageClass = $param->getType()->getName();
            $handlers[$messageClass][] = $className;
        }

        return $handlers;
    }

    private function resolveClassFromFile(string $path): ?string
    {
        $content = file_get_contents($path);

        if (
            preg_match('/namespace\s+(.+);/', $content, $ns) &&
            preg_match('/class\s+(\w+)/', $content, $cls)
        ) {
            return $ns[1] . '\\' . $cls[1];
        }

        return null;
    }
}
