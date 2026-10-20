<?php

spl_autoload_register(static function (string $class): void {
    if (str_starts_with($class, 'Mrstroz\\')) {
        require __DIR__.'/../src/'.str_replace('\\', '/', substr($class, 8)).'.php';
    }
}, true, true);
