<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fa_package_items';
    
    public function package()
    {
        return $this->belongsTo('App\Packages');
    }

}
