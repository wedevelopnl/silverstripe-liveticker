<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerMessage extends DataObject {

    /** @config */
    private static $singular_name = 'Message';

    /** @config */
    private static $plural_name = 'Messages';

    /** @config */
    private static $table_name = 'LivetickerMessage';

    /** @config */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Message' => 'HTMLText',
        'ExtraClasses' => 'Varchar(255)'
    ];

    /** @config */
    private static $has_one = [
        'Page' => LivetickerPage::class,
        'Category' => LivetickerCategory::class
    ];

    /** @config */
    private static $summary_fields = [
        'Title',
        'Category.Title' => 'Category'
    ];

    /** @config */
    private static $default_sort = 'Created DESC';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('PageID');

        $categories = LivetickerCategory::get()->filter('PageID', $this->PageID)->map();
        $fields->addFieldToTab('Root.Main', DropdownField::create('CategoryID', 'Category', $categories)->setHasEmptyDefault(true));

        return $fields;
    }

    public function canView($member = null)
    {
        return true;
    }

}
