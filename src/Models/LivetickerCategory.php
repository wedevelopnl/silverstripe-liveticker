<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Parsers\URLSegmentFilter;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerCategory extends DataObject {

    /** @config */
    private static $singular_name = 'Category';

    /** @config */
    private static $plural_name = 'Categories';

    /** @config */
    private static $table_name = 'LivetickerCategory';

    /** @config */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Slug' => 'Varchar(255)'
    ];

    /** @config */
    private static $has_one = [
        'Page' => LivetickerPage::class
    ];

    /** @config */
    private static $has_many = [
        'Messages' => LivetickerMessage::class
    ];

    /** @config */
    private static $summary_fields = [
        'Title'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('PageID');
        $fields->removeByName('Slug');

        $messagesField = $fields->dataFieldByName('Messages');
        if($messagesField){
            $messagesField->setConfig(GridFieldConfig_RecordViewer::create());
        }

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $filter = new URLSegmentFilter();
        $this->Slug = $filter->filter($this->Title);
    }

    public function canView($member = null)
    {
        return true;
    }

    public function Link(){
        return $this->Page()->Link() . '?category=' . $this->Slug;
    }

}
