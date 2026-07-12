<?php

declare(strict_types=1);

/**
 * Fixture synthesizer for the ESI OpenAPI schema.
 *
 * Usage:
 *   php synth.php '<path>' '<method>'        -> prints example 200 response JSON
 *   php synth.php --schema '<ComponentName>' -> prints example for a named component
 *   php synth.php --list                     -> lists all paths + methods
 */
$SP = __DIR__;
$spec = json_decode((string) file_get_contents($SP.'/openapi.json'), true, 512, JSON_THROW_ON_ERROR);

function ref(array $spec, string $ref): array
{
    $parts = explode('/', mb_ltrim($ref, '#/'));
    $node = $spec;
    foreach ($parts as $p) {
        $node = $node[$p];
    }

    return $node;
}

function gen(array $spec, array $schema, int $depth = 0): mixed
{
    if ($depth > 12) {
        return null;
    }

    if (isset($schema['$ref'])) {
        return gen($spec, ref($spec, $schema['$ref']), $depth + 1);
    }

    // allOf: merge object schemas
    if (isset($schema['allOf'])) {
        $merged = [];
        foreach ($schema['allOf'] as $sub) {
            $val = gen($spec, $sub, $depth + 1);
            if (is_array($val)) {
                $merged = array_merge($merged, $val);
            }
        }

        return $merged;
    }

    if (isset($schema['oneOf'])) {
        return gen($spec, $schema['oneOf'][0], $depth + 1);
    }
    if (isset($schema['anyOf'])) {
        return gen($spec, $schema['anyOf'][0], $depth + 1);
    }

    if (isset($schema['examples']) && is_array($schema['examples']) && $schema['examples'] !== []) {
        return $schema['examples'][0];
    }
    if (array_key_exists('example', $schema)) {
        return $schema['example'];
    }
    if (isset($schema['enum'])) {
        return $schema['enum'][0];
    }
    if (isset($schema['const'])) {
        return $schema['const'];
    }

    $type = $schema['type'] ?? null;
    if (is_array($type)) {
        $type = $type[0];
    }

    switch ($type) {
        case 'object':
            $out = [];
            foreach (($schema['properties'] ?? []) as $name => $prop) {
                $out[$name] = gen($spec, $prop, $depth + 1);
            }

            return $out;
        case 'array':
            $item = gen($spec, $schema['items'] ?? [], $depth + 1);

            return [$item];
        case 'integer':
            return ($schema['format'] ?? '') === 'int64' ? 90000001 : 42;
        case 'number':
            return 1.5;
        case 'boolean':
            return true;
        case 'string':
            return match ($schema['format'] ?? '') {
                'date-time' => '2026-06-09T12:00:00Z',
                'date' => '2026-06-09',
                'uuid' => '00000000-0000-0000-0000-000000000000',
                default => 'string',
            };
        default:
            // objects with properties but no explicit type
            if (isset($schema['properties'])) {
                $out = [];
                foreach ($schema['properties'] as $name => $prop) {
                    $out[$name] = gen($spec, $prop, $depth + 1);
                }

                return $out;
            }

            return null;
    }
}

$args = $argv;
array_shift($args);

if (($args[0] ?? '') === '--list') {
    foreach ($spec['paths'] as $path => $ops) {
        foreach ($ops as $method => $op) {
            if (in_array($method, ['get', 'post', 'put', 'delete', 'patch'], true)) {
                echo mb_strtoupper($method)."\t".$path."\n";
            }
        }
    }
    exit;
}

if (($args[0] ?? '') === '--schema') {
    $schema = $spec['components']['schemas'][$args[1]] ?? null;
    if ($schema === null) {
        fwrite(STDERR, "Unknown schema: {$args[1]}\n");
        exit(1);
    }
    echo json_encode(gen($spec, $schema), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."\n";
    exit;
}

[$path, $method] = [$args[0] ?? '', mb_strtolower($args[1] ?? 'get')];
$op = $spec['paths'][$path][$method] ?? null;
if ($op === null) {
    fwrite(STDERR, "No such path/method: $method $path\n");
    exit(1);
}
$schema = $op['responses']['200']['content']['application/json']['schema']
    ?? $op['responses']['201']['content']['application/json']['schema']
    ?? null;
if ($schema === null) {
    echo "null\n";
    exit;
}
echo json_encode(gen($spec, $schema), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."\n";
