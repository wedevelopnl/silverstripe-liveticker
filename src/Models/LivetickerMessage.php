<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerMessage extends DataObject {

    private static $singular_name = 'Message';
    private static $plural_name = 'Messages';

    private static $table_name = 'LivetickerMessage';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Message' => 'Text',
        'ExtraClasses' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Page' => LivetickerPage::class,
        'Category' => LivetickerCategory::class
    ];

    private static $summary_fields = [
        'Title',
        'Message',
        'Category.Title' => 'Category'
    ];

    private static $default_sort = 'Created DESC';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('PageID');
        $fields->removeByName('ExtraClasses');

        $categories = LivetickerCategory::get()->filter('PageID', $this->PageID)->map();
        $fields->addFieldToTab('Root.Main', DropdownField::create('CategoryID', 'Category', $categories)->setHasEmptyDefault(true));

        return $fields;
    }

    public function canView($member = null)
    {
        return true;
    }

}
