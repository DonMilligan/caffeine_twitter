<?php

class Blog extends Module {

    /**
     * Returns a model object of the last post created.
     */
    public static function getLastPost() {
        return Blog::post()->orderBy('created_at', 'DESC')->first();
    }

    /**
     * Returns an array of recent posts.
     *
     * @param int $limit The number of recent posts to get.
     * @return An array of recent posts.
     */
    public static function getPosts($limit = 3) {
        return Blog::post()->orderBy('created_at', 'DESC')->limit($limit)->get();
    }

    /**
     * Gets all categories, ordered by name.
     */
    public static function getCategories() {
        return Blog::category()->orderBy('name')->all();
    }

}
