<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $breed
 * @property string $fluffyness
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Cat extends Model
{
    protected $fillable = ['name', 'breed', 'fluffyness', 'color'];
}
