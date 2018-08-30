<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\View\Requirements;

class LivetickerPageController extends \PageController {

    public function init()
    {
        parent::init();
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/tmpl.min.js');
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/graphql.min.js');
        Requirements::javascript('thewebmen/silverstripe-liveticker:resources/js/liveticker.js');
    }

}
