<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'oportunidade_id',
        'usuario_id',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];


    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }
    
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function oportunidade(){
         return $this->belongsTo(Oportunidade::class);
         }
    public function usuario(){ return $this->belongsTo(Usuario::class); }

    public function clubeReviewer(){
        return $this->belongsTo(Clube::class, 'reviewed_by');
    }
    public function clube(){
        return $this->oportunidade->clube();
    }

}

