<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database;

class SelectOptionsCategories extends Model
{
    const RELIGION = 1;
    const RACE = 2;
    const DIALECTS = 3;
    const SOURCE = 4;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'select_options_categories';
    

}
