<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'qr_session_id',
        'discount_percent',
        'scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function qrSession()
    {
        return $this->belongsTo(QrSession::class);
    }
}
