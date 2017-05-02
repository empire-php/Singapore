<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const ACTION_NEW_SHIFTING = "new_shifting";
    const ACTION_UPDATE_SHIFTING = "update_shifting";
    const ACTION_NEW_FA = "new_fa";
    const ACTION_UPDATE_FA = "update_fa";
    const ACTION_NEW_GEMSTONE = "new_gemstone";
    const ACTION_UPDATE_GEMSTONE = "update_gemstone";
    const ACTION_NEW_COLUMBARIUM = "new_columbarium";
    const ACTION_UPDATE_COLUMBARIUM = "update_columbarium";
    const ACTION_ADDED_COFFIN_SLIP = "coffin_slip";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

    public function getTitle()
    {
        $title = "";
        if ($this->action == self::ACTION_NEW_SHIFTING) {
            $title = "New Shifting form created by {$this->creator->name}";
        } elseif ($this->action == self::ACTION_UPDATE_SHIFTING) {
            $title = "The Shifting was edited by {$this->creator->name}";
        }
        elseif ($this->action == self::ACTION_NEW_FA) {
            $title = "New FA form created by {$this->creator->name}";
        } elseif ($this->action == self::ACTION_UPDATE_FA) {
            $title = "The FA was edited by {$this->creator->name}";
        }
        
        elseif ($this->action == self::ACTION_NEW_GEMSTONE) {
            $title = "New Gemstone form created by {$this->creator->name}";
        } elseif ($this->action == self::ACTION_UPDATE_GEMSTONE) {
            $title = "The Gemstone was edited by {$this->creator->name}";
        }
        
        elseif ($this->action == self::ACTION_NEW_COLUMBARIUM) {
            $title = "New Columbarium form created by {$this->creator->name}";
        }
        elseif ($this->action == self::ACTION_UPDATE_COLUMBARIUM) {
            $title = "The Columbarium was edited by {$this->creator->name}";
        }
        elseif ($this->action == self::ACTION_ADDED_COFFIN_SLIP) {
            $title = "New Coffin Slip was added by {$this->creator->name}";
        }

        return $title;
    }
}
