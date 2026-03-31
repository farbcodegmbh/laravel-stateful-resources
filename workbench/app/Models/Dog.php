<?php

namespace Workbench\App\Models;

use Database\Factories\DogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $breed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Dog extends Model
{
    /** @use HasFactory<DogFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'breed'];
}
