<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const KEY_LANDING_PAGE_PASSWORD = "secret_key";
    const KEY_SHIFTING_EMAIL_DEPARTMENTS = "shifting_email_departments_ids";
    const KEY_SHIFTING_EMAIL_INDIVIDUALS = "shifting_email_individuals_ids";
    const KEY_SHIFTING_NOTIFICATION_DEPARTMENTS = "shifting_notification_departments_ids";
    const KEY_SHIFTING_NOTIFICATION_INDIVIDUALS = "shifting_notification_individuals_ids";
    const KEY_SHIFTING_UPDATE_DEPARTMENTS = "shifting_update_departments_ids";
    const KEY_SHIFTING_UPDATE_INDIVIDUALS = "shifting_update_individuals_ids";

    const KEY_FA_EMAIL_DEPARTMENTS = "fa_email_departments_ids";
    const KEY_FA_EMAIL_INDIVIDUALS = "fa_email_individuals_ids";
    const KEY_FA_NOTIFICATION_DEPARTMENTS = "fa_notification_departments_ids";
    const KEY_FA_NOTIFICATION_INDIVIDUALS = "fa_notification_individuals_ids";
    const KEY_FA_UPDATE_DEPARTMENTS = "fa_update_departments_ids";
    const KEY_FA_UPDATE_INDIVIDUALS = "fa_update_individuals_ids";
    
    const KEY_GEMSTONE_EMAIL_DEPARTMENTS = "gemstone_email_departments_ids";
    const KEY_GEMSTONE_EMAIL_INDIVIDUALS = "gemstone_email_individuals_ids";
    const KEY_GEMSTONE_NOTIFICATION_DEPARTMENTS = "gemstone_notification_departments_ids";
    const KEY_GEMSTONE_NOTIFICATION_INDIVIDUALS = "gemstone_notification_individuals_ids";
    const KEY_GEMSTONE_UPDATE_DEPARTMENTS = "gemstone_update_departments_ids";
    const KEY_GEMSTONE_UPDATE_INDIVIDUALS = "gemstone_update_individuals_ids";
    
    const KEY_COLUMBARIUM_EMAIL_DEPARTMENTS = "columbarium_email_departments_ids";
    const KEY_COLUMBARIUM_EMAIL_INDIVIDUALS = "columbarium_email_individuals_ids";
    const KEY_COLUMBARIUM_NOTIFICATION_DEPARTMENTS = "columbarium_notification_departments_ids";
    const KEY_COLUMBARIUM_NOTIFICATION_INDIVIDUALS = "columbarium_notification_individuals_ids";
    const KEY_COLUMBARIUM_UPDATE_DEPARTMENTS = "columbarium_update_departments_ids";
    const KEY_COLUMBARIUM_UPDATE_INDIVIDUALS = "columbarium_update_individuals_ids";
    
    const KEY_FA_ALA_CARTE_ITEMS = "fa_ala_carte_items";
    const KEY_FA_INDIVIDUAL_SALES_ITEMS = "fa_individual_sales_items";
    const KEY_FA_SALES_PACKAGES = "fa_individual_sales_items_package_names";   
    
    const KEY_INVENTORY_EDIT_DEPARTMENTS = "inventory_edit_departments_ids";
    const KEY_INVENTORY_EDIT_INDIVIDUALS = "inventory_edit_individuals_ids";
    const KEY_INVENTORY_DELETE_DEPARTMENTS = "inventory_delete_departments_ids";
    const KEY_INVENTORY_DELETE_INDIVIDUALS = "inventory_delete_individuals_ids";
    
    const KEY_FA_DISCOUNT = "fa_discount";
    const KEY_FA_REPATRIATION_DISCOUNT = "fa_repatriation_discount";
    
    const FA_ALA_CARTE_CATEGORY_NAMES = array( 1 => "Backdrop", 2 => "Burial plot", 3 => "Coffin catalog", 4 => "Flowers", 5=> "Gem stones", 6 => "Urns");
    const FA_ALA_CREATE_CATEGORY_NAMES_NEW = array(1=>'Coffin catalog');

    const KEY_NICHE = "niche";
    const KEY_GEMSTONE_TERMS_CONDITIONS = "gemstone_terms_conditions";
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public function getValueArray($separator = ',') {
        return explode($separator, $this->value);
    }
}
