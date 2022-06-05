<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giderler extends Model
{
    protected $table = 'giderler';
    protected $fillable = [
                        'tutar',
                        'kategori',
                        'açıklama',
                        'tarih',
                        'konum',
                        'created_at',
                        'updated_at',
                    ];
}
