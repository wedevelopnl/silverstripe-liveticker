<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\ORM\DataObject;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerMessage extends DataObject {

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

}
