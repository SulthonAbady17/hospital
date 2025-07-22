<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'referral_letter_path',
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function isPendingV1()
    {
        return $this->status === 'pending_v1';
    }
    public function isPendingV2()
    {
        return $this->status === 'pending_v2';
    }
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
