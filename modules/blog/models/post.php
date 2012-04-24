<?php

class Blog_PostModel extends Model {


    public $_timestamps = true;


    public $_hasAndBelongsToMany = array('blog.category');


    public $_belongsTo = array('user.user');


    public $_fields = array(
        'title' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'slug' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'body' => array(
            'type' => 'text',
            'size' => 'big',
            'not null' => true
        )
    );


    public $_indexes = array('slug');


    public $_fulltext = array('title', 'body');


}
