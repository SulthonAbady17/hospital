<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'application_id',
        'verifier_id',
        'action',
        'notes',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}
