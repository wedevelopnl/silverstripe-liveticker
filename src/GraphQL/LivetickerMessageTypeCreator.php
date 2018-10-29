<?php

namespace TheWebmen\Liveticker\GraphQL;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class LivetickerMessageTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'livetickermessage'
        ];
    }

    public function fields()
    {
        return [
            'ID' => ['type' => Type::int()],
            'Title' => ['type' => Type::string()],
            'Message' => ['type' => Type::string()],
            'Created' => ['type' => Type::string()],
            'ExtraClasses' => ['type' => Type::string()],
            'Category' => ['type' => $this->manager->getType('livetickercategory')]
        ];
    }
    
    public function resolveMessageField($object, array $args, $context, $info)
    {
        return ShortcodeParser::get_active()->parse($object->Message);
    }
}
