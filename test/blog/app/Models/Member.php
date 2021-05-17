<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * 会员
 * Class Member
 * @package App\Models
 */
class Member extends Model {
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * 自动填充
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
    ];

    /**
     * 隐藏
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier () {
        return $this->getKey();
    }

    public function getJWTCustomClaims () {
        return [];
    }

}
