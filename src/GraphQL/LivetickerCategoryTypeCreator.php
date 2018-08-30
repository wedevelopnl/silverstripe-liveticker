<?php

namespace TheWebmen\Liveticker\GraphQL;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class LivetickerCategoryTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'livetickercategory'
        ];
    }

    public function fields()
    {
        return [
            'Title' => ['type' => Type::string()]
        ];
    }
}
