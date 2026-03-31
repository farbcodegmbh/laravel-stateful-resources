<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $breed
 * @property string $fluffyness
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Cat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'breed', 'fluffyness', 'color'];

    public function enemies()
    {
        return $this->belongsToMany(Dog::class, 'cats_dogs');
    }
}
