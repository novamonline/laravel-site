<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    //
    public static function canBeUsedBy()
    {
        return parent::user_id == auth()->id()? self: null;
    }
}
