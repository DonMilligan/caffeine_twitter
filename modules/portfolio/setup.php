<?php return array(

    'permissions' => array(
        'portfolio.admin' => 'Administer portfolio',

        'portfolio.admin_categories' => 'Administer categories',
        'portfolio.manage_categories' => 'Manage categories',
        'portfolio.create_categories' => 'Create categories',
        'portfolio.edit_categories' => 'Edit categories',
        'portfolio.delete_categories' => 'Delete categories',

        'portfolio.admin_items' => 'Administer items',
        'portfolio.manage_items' => 'Manage items',
        'portfolio.create_items' => 'Create items',
        'portfolio.edit_items' => 'Edit items',
        'portfolio.delete_item_photos' => 'Delete item photos',
        'portfolio.delete_items' => 'Delete items'
    ),

    'routes' => array(
        // Default
        'portfolio' => array(
            'title' => 'Portfolio',
            'redirect' => 'portfolio/web'
        ),

        // Front
        'portfolio/:slug' => array(
            'title' => 'Portfolio Category',
            'callback' => array('portfolio', 'category')
        ),
        'portfolio/:slug/:slug' => array(
            'title' => 'Portfolio Item',
            'callback' => array('portfolio', 'item')
        ),

        // Admin
        'admin/portfolio' => array(
            'title' => 'Portfolio',
            'redirect' => 'admin/portfolio/items',
            'permissions' => array('portfolio.admin')
        ),

        // Admin Items
        'admin/portfolio/items' => array(
            'title' => 'Items',
            'redirect' => 'admin/portfolio/items/manage',
            'permissions' => array('portfolio.admin_items')
        ),
        'admin/portfolio/items/manage' => array(
            'title' => 'Manage',
            'callback' => array('admin_item', 'manage'),
            'permissions' => array('portfolio.manage_items')
        ),
        'admin/portfolio/items/create' => array(
            'title' => 'Create',
            'callback' => array('admin_item', 'create'),
            'permissions' => array('portfolio.create_items')
        ),
        'admin/portfolio/items/edit/:num' => array(
            'title' => 'Edit',
            'callback' => array('admin_item', 'edit'),
            'permissions' => array('portfolio.edit_items')
        ),
        'admin/portfolio/items/edit/:num/delete-photo/:num' => array(
            'callback' => array('admin_item', 'deletePhoto'),
            'permissions' => array('portfolio.delete_item_photos')
        ),
        'admin/portfolio/items/delete/:num' => array(
            'callback' => array('admin_item', 'delete'),
            'permissions' => array('portfolio.delete_items')
        ),

        // Admin Categories
        'admin/portfolio/categories' => array(
            'title' => 'Categories',
            'redirect' => 'admin/portfolio/categories/manage',
            'permissions' => array('portfolio.admin_categories')
        ),
        'admin/portfolio/categories/manage' => array(
            'title' => 'Manage',
            'callback' => array('admin_category', 'manage'),
            'permissions' => array('portfolio.manage_categories')
        ),
        'admin/portfolio/categories/create' => array(
            'title' => 'Create',
            'callback' => array('admin_category', 'create'),
            'permissions' => array('portfolio.create_categories')
        ),
        'admin/portfolio/categories/edit/:num' => array(
            'title' => 'Edit',
            'callback' => array('admin_category', 'edit'),
            'permissions' => array('portfolio.edit_categories')
        ),
        'admin/portfolio/categories/delete/:num' => array(
            'callback' => array('admin_category', 'delete'),
            'permissions' => array('portfolio.delete_categories')
        )
    )

);
