<?php

class Blog_PostController extends Controller {

    /**
     * Displays a page of blog posts.
     * TODO Need to make pagination work.
     *
     * Route: blog/posts
     *
     * @param int $page The page used for pagination, this is passed via the url.
     */
    public static function all($page = 0) {
        View::data('posts', Blog::post()->orderBy('created_at', 'DESC')->all());
    }

    /**
     * Gets a single post based on its slug.
     *
     * Route: blog/post/:slug
     *
     * @param string $postSlug The slug of the post, this is passed via the url.
     */
    public static function single($postSlug)
    {
        if(!$post = Blog::post()->find($postSlug))
            return ERROR_NOTFOUND;

        View::data('post', $post);
    }

    /**
     * Displays a page of all blog posts associated with a category.
     *
     * Route: blog/category/:slug
     *
     * @param string $categorySlug The slug of the category to get posts associated with.
     * @param int $page Used to determine page for pagination.
     */
    public static function postsByCategory($categorySlug, $page = 0)
    {
        $posts = Blog::post()
            ->select('blog_posts.*')
            ->leftJoin('categories_posts', 'categories_posts.post_id', '=', 'blog_posts.id')
            ->leftJoin('blog_categories', 'blog_categories.id', '=', 'categories_posts.category_id')
            ->where('blog_categories.slug', '=', $categorySlug)
            ->orderBy('blog_posts.created_at', 'DESC')
            ->all();

        View::data('posts', $posts);
    }

    /**
     * TODO Make searching for blog posts work.
     */
    public static function search()
    {

    }

}
