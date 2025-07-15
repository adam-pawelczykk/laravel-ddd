<?php

/** @author: Adam Pawełczyk */

namespace App\System\Providers;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class ModuleServiceProviderDiscoverer
{
    public function discover(string $modulesPath): array
    {
        $providers = [];

        $finder = new Finder();
        $finder->files()
            ->in($modulesPath)
            ->name('*ServiceProvider.php')
            ->depth('< 6'); // Dostosuj głębokość jeśli trzeba

        foreach ($finder as $file) {
            $realPath = $file->getRealPath();
            $relativePath = Str::of($realPath)
                ->after(realpath(base_path('app')) . DIRECTORY_SEPARATOR)
                ->replace(DIRECTORY_SEPARATOR, '\\')
                ->replace('.php', '');

            $fqcn = 'App\\' . $relativePath;

            if (class_exists($fqcn)) {
                $providers[] = $fqcn;
            }
        }

        return $providers;
    }
}
