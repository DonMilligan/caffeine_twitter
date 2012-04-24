<?php return array(

    'configs' => array(
        'blog.posts_per_page' => 5
    ),

    'permissions' => array(
        'blog.admin' => 'Administer blog',
        'blog.admin_posts' => 'Administer posts',
        'blog.manage_posts' => 'Manage posts',
        'blog.manage_my_posts' => 'Manage my posts',
        'blog.create_posts' => 'Create posts',
        'blog.edit_posts' => 'Edit posts',
        'blog.edit_my_posts' => 'Edit my posts',
        'blog.delete_posts' => 'Delete posts',
        'blog.delete_my_posts' => 'Delete my posts',

        'blog.admin_categories' => 'Administer categories',
        'blog.manage_categories' => 'Manage categories',
        'blog.create_categories' => 'Create categories',
        'blog.edit_categories' => 'Edit categories',
        'blog.delete_categories' => 'Delete categories'
    ),

    'routes' => array(
        // Front
        'blog' => array(
            'title' => 'Blog',
            'redirect' => 'blog/posts'
        ),
        'blog/posts' => array(
            'title' => 'Blog Posts',
            'callback' => array('post', 'all')
        ),
        'blog/posts/:num' => array( // Pagination
            'title' => 'Blog Posts',
            'callback' => array('post', 'all')
        ),
        'blog/post/:slug' => array(
            'title' => 'Blog Post',
            'callback' => array('post', 'single')
        ),
        'blog/category/:slug' => array(
            'title' => 'Blog Posts by Category',
            'callback' => array('post', 'postsByCategory')
        ),
        'blog/category/:slug/:num' => array( // Pagination
            'title' => 'Blog Posts by Category',
            'callback' => array('post', 'postsByCategory')
        ),
        'blog/search' => array(
            'title' => 'Blog Search',
            'callback' => array('post', 'search')
        ),

        // Admin
        'admin/blog' => array(
            'title' => 'Blog',
            'redirect' => 'admin/blog/posts',
            'permissions' => array('blog.admin')
        ),

        // Admin Posts
        'admin/blog/posts' => array(
            'title' => 'Posts',
            'redirect' => 'admin/blog/posts/manage',
            'permissions' => array('blog.admin_posts')
        ),
        'admin/blog/posts/manage' => array(
            'title' => 'Manage',
            'callback' => array('admin_post', 'manage'),
            'permissions' => array('blog.manage_posts', 'blog.manage_my_posts')
        ),
        'admin/blog/posts/create' => array(
            'title' => 'Create',
            'callback' => array('admin_post', 'create'),
            'permissions' => array('blog.create_posts')
        ),
        'admin/blog/posts/edit/:id' => array(
            'title' => 'Edit',
            'callback' => array('admin_post', 'edit'),
            'permissions' => array('blog.edit_posts', 'blog.edit_my_posts')
        ),
        'admin/blog/posts/delete/:id' => array(
            'callback' => array('admin_post', 'delete'),
            'permissions' => array('blog.delete_posts', 'blog.delete_my_posts')
        ),

        // Admin Categories
        'admin/blog/categories' => array(
            'title' => 'Categories',
            'redirect' => 'admin/blog/categories/manage',
            'permissions' => array('blog.admin_categories')
        ),
        'admin/blog/categories/manage' => array(
            'title' => 'Manage',
            'callback' => array('admin_category', 'manage'),
            'permissions' => array('blog.manage_categories')
        ),
        'admin/blog/categories/create' => array(
            'title' => 'Create',
            'callback' => array('admin_category', 'create'),
            'permissions' => array('blog.create_categories')
        ),
        'admin/blog/categories/edit/:id' => array(
            'title' => 'Edit',
            'callback' => array('admin_category', 'edit'),
            'permissions' => array('blog.edit_categories')
        ),
        'admin/blog/categories/delete/:id' => array(
            'callback' => array('admin_category', 'delete'),
            'permissions' => array('blog.delete_categories')
        )
    )

);
