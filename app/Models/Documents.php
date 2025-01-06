<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'min_size',
        'max_size',
        'alphanumeric',
        'status'
    ];

    public function empresas()
    {
        return $this->hasMany(Empresas::class, 'document_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'document_id');
    }
}
