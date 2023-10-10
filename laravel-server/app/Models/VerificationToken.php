<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VerificationToken
 *
 * @property int $id
 * @property string $token
 * @property string $duration
 * @property int $user_id
 * @property bool $is_used
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereIsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken whereUserId($value)
 * @method static \Database\Factories\VerificationTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationToken validToken()
 * @mixin Eloquent
 */

class VerificationToken extends Model
{
    use HasFactory;

    static int $CODE_MIN = 100000;
    static int $CODE_MAX = 999999;
    protected $fillable = [
        'token',
        'duration',
        'user_id'
    ];

    public function scopeValidToken(): Builder
    {
        return $this
            ->where('duration', '>', now())
            ->where('is_used', false);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->duration = now()->addMinutes(User::$TOKEN_DURATION);
            $model->token = random_int(VerificationToken::$CODE_MIN, VerificationToken::$CODE_MAX);
        });
    }
}
