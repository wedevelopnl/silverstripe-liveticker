<?php

namespace TheWebmen\Liveticker\Resolvers;

use TheWebmen\Liveticker\Models\LivetickerMessage;

class LivertickerMessageResolver
{
    public static function readLivetickerMessages($object, array $args, $context, ResolveInfo $info)
    {
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
    }
}
