<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;

    protected $connection = 'mysql';

    public const TABLE_NAME = 'users';

    public const ID_ATTRIBUTE = 'id';
    public const NAME_ATTRIBUTE = 'name';
    public const EMAIL_ATTRIBUTE = 'email';
    public const PASSWORD_ATTRIBUTE = 'password';
    public const PASSWORD_CONFIRMATION_FIELD = 'password_confirmation';
    private const REMEMBER_TOKEN_ATTRIBUTE = 'remember_token';
    public const EMAIL_VERIFIED_ATTRIBUTE = 'email_verified_at';
    public const TOKEN_ATTRIBUTE = 'token';


    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        self::NAME_ATTRIBUTE,
        self::EMAIL_ATTRIBUTE,
        self::PASSWORD_ATTRIBUTE
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        self::PASSWORD_ATTRIBUTE,
        self::REMEMBER_TOKEN_ATTRIBUTE
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            self::PASSWORD_ATTRIBUTE => 'hashed',
            self::EMAIL_VERIFIED_ATTRIBUTE => 'datetime',
        ];
    }

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
