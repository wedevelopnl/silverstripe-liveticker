<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\View\Requirements;
use TheWebmen\Liveticker\Models\LivetickerCategory;

class LivetickerPageController extends \PageController {

    public function init()
    {
        parent::init();
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/tmpl.min.js');
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/graphql.min.js');
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/liveticker.js');
    }

    public function ActiveCategory()
    {
        $category = $this->getRequest()->getVar('category');
        if(!$category){
            return false;
        }
        return LivetickerCategory::get()->filter('Slug', $category)->first();
    }

}
