<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@local.tld') && $this->hasVerifiedEmail();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public static function checkUsername($username): self
    {

        $user = self::where('username', $username)->first();
        if(!$user) {
            $user = self::create([
                'name' => $username,
                'email' => $username.'@coralfood.local',
                'email_verified_at' => now(),
                'password' => Hash::make($username),
                'username' => $username,
                'remember_token' => Str::random(10),
            ]);
            Cart::create([
                'user_id' => $user->id
            ]);
        }
        return $user;
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorite_product_user')->withTimestamps();
    }


}
