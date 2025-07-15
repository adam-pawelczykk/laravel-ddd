<?php

/** @author: Adam Pawełczyk */

namespace App\System\Console;

use App\System\MessageBus\HandlerDiscoverer;
use Illuminate\Console\Command;
use App\System\MessageBus\HandlerPathProvider;
use Illuminate\Support\Str;

class BusDebugCommand extends Command
{
    protected $signature = 'bus:debug';
    protected $description = 'List all registered message handlers (Command, Query, Event)';

    private const TYPE_COMMAND = 'Commands';
    private const TYPE_QUERY = 'Queries';
    private const TYPE_EVENT = 'Events';

    public function __construct(
        private readonly HandlerDiscoverer   $discoverer,
        private readonly HandlerPathProvider $paths
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $handlersByType = [
            self::TYPE_COMMAND => [],
            self::TYPE_QUERY => [],
            self::TYPE_EVENT => [],
        ];

        foreach ($this->paths->all() as $path) {
            $discovered = $this->discoverer->discover($path);

            foreach ($discovered as $message => $handlers) {
                $type = $this->resolveTypeFromMessage($message);
                if ($type && isset($handlersByType[$type])) {
                    foreach ($handlers as $handler) {
                        $handlersByType[$type][] = [$message, $handler];
                    }
                }
            }
        }

        foreach ($handlersByType as $type => $rows) {
            $this->info("==== $type ====");

            foreach ($rows as [$message, $handler]) {
                $this->line("- $message => $handler");
            }

            $this->newLine();
        }

        return self::SUCCESS;
    }

    private function resolveTypeFromMessage(string $fqcn): ?string
    {
        return match (true) {
            Str::contains($fqcn, '\\Command\\') => self::TYPE_COMMAND,
            Str::contains($fqcn, '\\Query\\') => self::TYPE_QUERY,
            Str::contains($fqcn, '\\Event\\') => self::TYPE_EVENT,
            default => null,
        };
    }
}
