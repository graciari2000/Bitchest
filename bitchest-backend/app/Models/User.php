<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model; // Correct for official package
use MongoDB\Laravel\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'role',
        'balance',
        'is_active',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Create a new personal access token for the user (MongoDB-compatible).
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $plainTextToken = Str::random(40);
        $hashedToken = hash('sha256', $plainTextToken);

        // Use MongoDB collection directly to avoid SQL methods
        $collection = \DB::connection('mongodb')->getCollection('personal_access_tokens');
        
        $tokenData = [
            'name' => $name,
            'token' => $hashedToken,
            'abilities' => $abilities,
            'tokenable_id' => (string) $this->_id,
            'tokenable_type' => static::class,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $tokenId = $collection->insertOne($tokenData)->getInsertedId();

        // Create a model instance for NewAccessToken
        $token = new PersonalAccessToken();
        $token->fill($tokenData);
        $token->_id = $tokenId;
        $token->exists = true;

        return new NewAccessToken($token, (string)$tokenId.'|'.$plainTextToken);
    }

    /**
     * Delete all tokens for this user (MongoDB-compatible).
     *
     * @return int Number of deleted tokens
     */
    public function deleteTokens()
    {
        $collection = \DB::connection('mongodb')->getCollection('personal_access_tokens');
        $result = $collection->deleteMany([
            'tokenable_id' => (string) $this->_id,
            'tokenable_type' => static::class,
        ]);
        
        return $result->getDeletedCount();
    }
}
