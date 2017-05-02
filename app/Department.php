<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    const OPERATIONS = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';
}
