<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\ORM\DataObject;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerMessage extends DataObject {

    private static $singular_name = 'Message';
    private static $plural_name = 'Messages';

    private static $table_name = 'LivetickerMessage';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Message' => 'Text'
    ];

    private static $has_one = [
        'Page' => LivetickerPage::class
    ];

    private static $summary_fields = [
        'Title',
        'Message'
    ];

    private static $default_sort = 'Created DESC';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('PageID');

        return $fields;
    }

    public function canView($member = null)
    {
        return true;
    }

}
