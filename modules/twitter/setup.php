<?php return array(

		'configs' => array(
				'twitter.age' => 100
		),

		'permissions' => array(
				'twitter.admin' => 'Administer twitter',
				'twitter.admin_posts' => 'Administer posts',
				'twitter.manage_posts' => 'Manage posts',
				'twitter.manage_my_posts' => 'Manage my posts',
				'twitter.create_posts' => 'Create posts',
				'twitter.edit_posts' => 'Edit posts',
				'twitter.edit_my_posts' => 'Edit my posts',
				'twitter.delete_posts' => 'Delete posts',
				'twitter.delete_my_posts' => 'Delete my posts',

		),

		'routes' => array(
				//manage tweets
				'twitter' => array(
						'callback' => array('twitter', 'entryPoint')
				),
				'twitter/tweet' => array(
						'callback' => array('twitter', 'tweet')
				),
				// Admin
				'admin/twitter' => array(
						'title' => 'Twitter',
						'redirect' => 'admin/twitter/posts',
						'permissions' => array('twitter.admin')
				),

				// Admin Posts
				'admin/twitter/posts' => array(
						'title' => 'Posts',
						'redirect' => 'admin/twitter/posts/manage',
						'permissions' => array('twitter.admin_posts')
				),
				'admin/twitter/posts/manage' => array(
						'title' => 'Manage',
						'callback' => array('admin_post', 'manage'),
						'permissions' => array('twitter.manage_posts', 'twitter.manage_my_posts')
				),
				'admin/twitter/posts/create' => array(
						'title' => 'Create',
						'callback' => array('admin_post', 'create'),
						'permissions' => array('twitter.create_posts')
				),
				'admin/twitter/posts/edit/:id' => array(
						'title' => 'Edit',
						'callback' => array('admin_post', 'edit'),
						'permissions' => array('twitter.edit_posts', 'twitter.edit_my_posts')
				),
				'admin/twitter/posts/delete/:id' => array(
						'callback' => array('admin_post', 'delete'),
						'permissions' => array('twitter.delete_posts', 'twitter.delete_my_posts')
				)

		)







		
// 		'events' => array()
		

);
