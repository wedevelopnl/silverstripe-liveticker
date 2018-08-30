<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use TheWebmen\Liveticker\Models\LivetickerCategory;
use TheWebmen\Liveticker\Models\LivetickerMessage;

class LivetickerPage extends \Page {

    private static $table_name = 'LivetickerPage';

    private static $has_many = [
        'Messages' => LivetickerMessage::class,
        'Categories' => LivetickerCategory::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if($this->exists()){
            $fields->addFieldToTab('Root.Messages', GridField::create('Messages', 'Messages', $this->Messages(), GridFieldConfig_RecordEditor::create()));
            $fields->addFieldToTab('Root.Categories', GridField::create('Categories', 'Categories', $this->Categories(), GridFieldConfig_RecordEditor::create()));
        }

        return $fields;
    }

}
