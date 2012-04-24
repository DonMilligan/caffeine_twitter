<?php

class Portfolio_PortfolioController extends Controller {

    /**
     * Gets a category object populated with portfolio items associated with it based
     * on the given category slug. The category object is loaded into the current view.
     *
     * Route: portfolio/:slug
     *
     * @param string $categorySlug The slug for the category to get.
     */
    public static function category($categorySlug)
    {
        if(!$category = Portfolio::category()->find($categorySlug))
            return ERROR_NOTFOUND;

        if($items = Portfolio::item()->where('category_id', '=', $category->id)->orderBy('created_at', 'DESC')->all())
        {
            foreach($items as &$item)
                $item = Portfolio::getItemExtras($item);
        }

        View::data('items', $items);
    }

    /**
     * Gets an item based on the given category slug and item slug. This ensures that the item
     * exists within the given category. The item object is loaded into the current view.
     *
     * Route: portfolio/:slug/:slug
     *
     * @param string $categorySlug The category slug the item is associated with 
     * @param string $itemSlug The slug for the item to get
     */
    public static function item($categorySlug, $itemSlug)
    {
        if(!$item = Portfolio::item()->find($itemSlug))
            return ERROR_NOTFOUND;

        $item = Portfolio::getItemExtras($item);

        View::data('item', $item);
    }

}
