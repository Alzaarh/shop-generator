<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'picture',
        'details',
        'parent_id',
    ];

    public $casts = [
        'details' => 'json',
    ];

    public function parents()
    {
        $parents = [];

        $parent = self::find($this->parent_id);

        while($parent)
        {
            array_push($parents, $parent);

            $parent = self::find($parent->parent_id);
        }

        return $parents;
    }
}
