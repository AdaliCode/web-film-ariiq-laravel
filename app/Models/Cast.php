<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Cast extends Model
{
    use HasUuids, SoftDeletes;
    public function scopeActive(EloquentBuilder $builder): void
    {
        $builder->where("is_active", true);
    }
    public function scopeNonActive(EloquentBuilder $builder): void
    {
        $builder->where("is_active", false);
    }
    protected $table = 'casts';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function uniqueIds(): array
    {
        return [$this->primaryKey, "cast_code"];
    }
}
