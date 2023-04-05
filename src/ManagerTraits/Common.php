<?php
namespace Rupesh\MicroMatrix\ManagerTraits;

trait Common {
    public static function camelize($input, $separator = '-')
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }

    public static function uncamelize($camel, $splitter = "-")
    {
        $camel = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $camel));
        return strtolower($camel);
    }
}