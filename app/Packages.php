<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PackageItems;

class Packages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fa_packages';

    public function items(){
        return PackageItems::where("fa_package_id",$this->id)->where("is_deleted",0)->orderBy("id")->get();
    }
}
