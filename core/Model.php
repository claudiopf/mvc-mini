<?php

abstract class Model
{
    protected static string $table;

    protected static function db(): mysqli
    {
        global $connection;
        return $connection;
    }

    protected static function query(string $sql, array $params = []): mysqli_stmt|false
    {
        $stmt = self::db()->prepare($sql);
        if (!$stmt) return false;

        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) return false;

        return $stmt;
    }

    public static function all(): array
    {
        $stmt = self::query("SELECT * FROM " . static::$table);
        $result = $stmt?->get_result();
        return $result?->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    public static function find(int|string $id): ?array
    {
        $stmt = self::query("SELECT * FROM " . static::$table . " WHERE id = ?", [$id]);
        $result = $stmt?->get_result();
        return $result?->fetch_assoc() ?: null;
    }

    public static function insert(array $data): bool|int
    {
        $keys = array_keys($data);
        $cols = implode(',', $keys);
        $placeholders = implode(',', array_fill(0, count($keys), '?'));

        $stmt = self::query("INSERT INTO " . static::$table . " ($cols) VALUES ($placeholders)", array_values($data));

        return $stmt ? self::db()->insert_id : false;
    }

    public static function update(int|string $id, array $data): bool
    {
        $set = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $params = [...array_values($data), $id];

        $stmt = self::query("UPDATE " . static::$table . " SET $set WHERE id = ?", $params);
        return $stmt !== false;
    }

    public static function delete(int|string $id): bool
    {
        $stmt = self::query("DELETE FROM " . static::$table . " WHERE id = ?", [$id]);
        return $stmt !== false;
    }
}
