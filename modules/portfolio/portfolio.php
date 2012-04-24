<?php

class Portfolio extends Module {

    /** 
     * Gets all categories sorted by their name ascending.
     *
     * @return Array of category objects.
     */
    public static function getCategories() {
        return Portfolio::category()->orderBy('name')->all();
    }

    /**
     * Gets an array of recent item objects sorted by creation date descending.
     *
     * @param int $limit The number of recent items to get
     * @return An array of portfolio item objects
     */
    public static function recentItems($limit)
    {
        if($items = Portfolio::item()->orderBy('created_at', 'DESC')->limit($limit)->get())
        {
            foreach($items as &$item)
                $item = self::getItemExtras($item);
        }

        return $items;
    }
    
    /**
     * Used to get category and file information for a given item. The category and photos associated
     * with the item are added as new object properties.
     *
     * @param object $item The portfolio item to get additional data for
     * @return The object with new data added as object properties
     */
    public static function getItemExtras($item)
    {
        $item->category = Portfolio::category()->find($item->category_id);
        $item->photos = Db::table('files_items')->where('item_id', '=', $item->id)->all();

        return $item;
    }

}
