<?php

namespace TheWebmen\Liveticker\Models;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Parsers\URLSegmentFilter;
use TheWebmen\Liveticker\Pages\LivetickerPage;

class LivetickerCategory extends DataObject {

    private static $singular_name = 'Category';
    private static $plural_name = 'Categories';

    private static $table_name = 'LivetickerCategory';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Slug' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Page' => LivetickerPage::class
    ];

    private static $has_many = [
        'Messages' => LivetickerMessage::class
    ];

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
