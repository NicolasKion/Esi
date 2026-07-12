<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Support;

/**
 * A fluent, read-only view over a decoded ESI JSON object.
 *
 * DTOs receive a Data instance in their fromData() and pull typed values out of
 * it — `$data->integer('bloodline_id')`, `$data->string('name', '')`,
 * `$data->list('attackers', Attacker::fromData(...))` — instead of repeating
 * isset()/cast boilerplate. All the unavoidable mixed -> scalar coercion lives
 * here, so the DTOs stay clean at PHPStan's strictest level. A key that is
 * absent or null yields the supplied default (null unless given).
 */
final class Data
{
    /**
     * @param  array<string, mixed>  $items
     */
    public function __construct(private array $items) {}

    /**
     * Wrap a raw decoded payload, guarding non-array input into an empty object.
     */
    public static function of(mixed $data): self
    {
        return new self(is_array($data) ? $data : []);
    }

    /**
     * Map a raw decoded JSON list through a factory that receives each item as
     * a Data instance. Non-array input yields an empty list.
     *
     * @template T
     *
     * @param  callable(self): T  $factory
     * @return array<int, T>
     */
    public static function mapList(mixed $data, callable $factory): array
    {
        if (! is_array($data)) {
            return [];
        }

        return array_map(static fn (mixed $item) => $factory(self::of($item)), array_values($data));
    }

    /**
     * Coerce a raw decoded payload to a list of integers (e.g. an id array).
     *
     * @return array<int, int>
     */
    public static function integerList(mixed $data): array
    {
        if (! is_array($data)) {
            return [];
        }

        return array_map(
            static fn (mixed $value): int => is_numeric($value) ? (int) $value : 0,
            array_values($data),
        );
    }

    /**
     * @return ($default is null ? int|null : int)
     */
    public function integer(string $key, ?int $default = null): ?int
    {
        $value = $this->items[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        return is_numeric($value) ? (int) $value : $default;
    }

    /**
     * @return ($default is null ? float|null : float)
     */
    public function float(string $key, ?float $default = null): ?float
    {
        $value = $this->items[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        return is_numeric($value) ? (float) $value : $default;
    }

    /**
     * @return ($default is null ? bool|null : bool)
     */
    public function boolean(string $key, ?bool $default = null): ?bool
    {
        $value = $this->items[$key] ?? null;

        return $value === null ? $default : (bool) $value;
    }

    /**
     * @return ($default is null ? string|null : string)
     */
    public function string(string $key, ?string $default = null): ?string
    {
        $value = $this->items[$key] ?? null;

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }

        return $default;
    }

    /**
     * The raw, uncoerced value for a key (null when absent).
     */
    public function raw(string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * A nested object as its own Data instance (empty when absent).
     */
    public function object(string $key): self
    {
        return self::of($this->items[$key] ?? null);
    }

    /**
     * Map a nested list through a factory that receives each item as Data.
     *
     * @template T
     *
     * @param  callable(self): T  $factory
     * @return array<int, T>
     */
    public function list(string $key, callable $factory): array
    {
        return self::mapList($this->items[$key] ?? null, $factory);
    }

    /**
     * A nested list of integers (e.g. label_ids) for the given key.
     *
     * @return array<int, int>
     */
    public function integers(string $key): array
    {
        return self::integerList($this->items[$key] ?? null);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
