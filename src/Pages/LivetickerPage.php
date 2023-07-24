<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\HasManyList;
use TheWebmen\Liveticker\Models\LivetickerCategory;
use TheWebmen\Liveticker\Models\LivetickerMessage;

/**
 * @method HasManyList|LivetickerMessage Messages()
 * @method HasManyList|LivetickerCategory Categories()
 */
class LivetickerPage extends \Page {

    /** @config */
    private static $table_name = 'LivetickerPage';

    /** @config */
    private static $has_many = [
        'Messages' => LivetickerMessage::class,
        'Categories' => LivetickerCategory::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if($this->exists()){
            $fields->addFieldToTab('Root.Messages', new GridField('Messages', 'Messages', $this->Messages(), GridFieldConfig_RecordEditor::create()));
            $fields->addFieldToTab('Root.Categories', new GridField('Categories', 'Categories', $this->Categories(), GridFieldConfig_RecordEditor::create()));
        }

        return $fields;
    }

}
