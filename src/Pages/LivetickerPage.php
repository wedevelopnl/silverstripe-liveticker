<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use TheWebmen\Liveticker\Models\LivetickerMessage;

class LivetickerPage extends \Page {

    private static $table_name = 'LivetickerPage';

    private static $has_many = [
        'Messages' => LivetickerMessage::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if($this->exists()){
            $config = GridFieldConfig_RecordEditor::create();
            $fields->addFieldToTab('Root.Messages', GridField::create('Messages', 'Messages', $this->Messages(), $config));
        }

        return $fields;
    }

}
