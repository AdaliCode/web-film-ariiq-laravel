<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    // protected $fillable = [
    //     'id', 'name', 'description'
    // ];

    protected static function booted()
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }
}
