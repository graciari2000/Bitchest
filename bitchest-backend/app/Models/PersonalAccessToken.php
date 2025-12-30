<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $connection = 'mongodb';

    /**
     * Get the database connection for the model.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return static::resolveConnection($this->connection);
    }

    /**
     * Get the connection name for the model.
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
        'tokenable_id',
        'tokenable_type',
        'last_used_at',
    ];

    protected $hidden = [
        'token',
    ];

    protected function casts(): array
    {
        return [
            'abilities' => 'array',
            'expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'tokenable_id' => 'string', // MongoDB uses ObjectId, but we'll store as string
        ];
    }

    /**
     * Get the tokenable model that the access token belongs to.
     */
    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }

    /**
     * Find the token instance matching the given token.
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        if (!$token) {
            return null;
        }

        if (strpos($token, '|') === false) {
            // Token without ID prefix - search by hashed token
            return static::where('token', hash('sha256', $token))->first();
        }

        // Token with ID prefix: "id|plainTextToken"
        [$id, $plainTextToken] = explode('|', $token, 2);

        if (empty($id) || empty($plainTextToken)) {
            return null;
        }

        // For MongoDB, try multiple ways to locate the token document by id:
        // 1. Directly by the provided id
        // 2. As a string
        // 3. As a MongoDB\BSON\ObjectId (if available and id is a valid 24-hex string)
        $instance = static::where('_id', $id)->first();

        if (! $instance) {
            $instance = static::where('_id', (string) $id)->first();
        }

        if (! $instance) {
            // Try converting to MongoDB\BSON\ObjectId when possible
            try {
                if (class_exists('MongoDB\\BSON\\ObjectId')) {
                    // Only attempt if the id looks like a 24-hex string
                    if (is_string($id) && preg_match('/^[0-9a-fA-F]{24}$/', $id)) {
                        $objId = new \MongoDB\BSON\ObjectId($id);
                        $instance = static::where('_id', $objId)->first();
                    }
                }
            } catch (\Throwable $e) {
                // ignore conversion errors
            }
        }

        if (! $instance) {
            \Log::warning('Token not found', ['token_id' => $id, 'token_preview' => substr($token, 0, 20)]);
            return null;
        }

        // Verify the token hash matches
        $hashedToken = hash('sha256', $plainTextToken);
        if (!hash_equals($instance->token ?? '', $hashedToken)) {
            \Log::warning('Token hash mismatch', ['token_id' => $id]);
            return null;
        }

        return $instance;
    }

    /**
     * Determine if the token has a given ability.
     *
     * @param  string  $ability
     * @return bool
     */
    public function can($ability)
    {
        return in_array('*', $this->abilities) ||
            array_key_exists($ability, array_flip($this->abilities));
    }

    /**
     * Determine if the token is missing a given ability.
     *
     * @param  string  $ability
     * @return bool
     */
    public function cant($ability)
    {
        return ! $this->can($ability);
    }

    /**
     * Determine if the access token has been revoked.
     *
     * @return bool
     */
    public function revoke()
    {
        return $this->delete();
    }

    /**
     * Determine if the token is a transient token.
     *
     * @return bool
     */
    public function transient()
    {
        return false;
    }

    /**
     * Determine if the token is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        if ($this->expires_at === null) {
            return false;
        }

        return $this->expires_at->isPast();
    }
}
