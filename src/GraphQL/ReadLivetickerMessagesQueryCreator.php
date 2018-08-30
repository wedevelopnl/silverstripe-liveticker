<?php

namespace TheWebmen\Liveticker\GraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use TheWebmen\Liveticker\Models\LivetickerCategory;
use TheWebmen\Liveticker\Models\LivetickerMessage;
use SilverStripe\GraphQL\Pagination\PaginatedQueryCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class ReadLivetickerMessagesQueryCreator extends PaginatedQueryCreator
{

    public function createConnection()
    {
        return Connection::create('readLivetickerMessages')
            ->setConnectionType($this->manager->getType('livetickermessage'))
            ->setArgs([
                'PageID' => ['type' => Type::int()],
                'LastUpdate' => ['type' => Type::string()],
                'DateType' => ['type' => Type::string()],
                'Category' => ['type' => Type::string()]
            ])
            ->setDefaultLimit(5)
            ->setMaximumLimit(20)
            ->setSortableFields(['Created'])
            ->setConnectionResolver(function ($object, array $args, $context, ResolveInfo $info) {
                $list = LivetickerMessage::get();

                if (!isset($args['PageID'])) {
                    throw new \InvalidArgumentException(sprintf(
                        'PageID is required'
                    ));
                }

                if(isset($args['LastUpdate'])){
                    $dateType = isset($args['DateType']) ? $args['DateType'] : 'GreaterThan';
                    $list = $list->filter('Created:' . $dateType, $args['LastUpdate']);
                }

                if(isset($args['Category'])){
                    $category = LivetickerCategory::get()->filter('Slug', $args['Category'])->first();
                    if($category){
                        $list = $list->filter('CategoryID', $category->ID);
                    }
                }

                return $list->filter('PageID', $args['PageID']);
            });
    }
}
