<?php

namespace TheWebmen\Liveticker\Pages;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
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
            $config = GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldPaginator(5))
                ->addComponent(new GridFieldAddNewInlineButton());
            $fields->addFieldToTab('Root.Messages', GridField::create('Messages', 'Messages', $this->Messages(), $config));
        }

        return $fields;
    }

}
