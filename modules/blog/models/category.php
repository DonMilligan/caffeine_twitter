<?php

class Blog_CategoryModel extends Model {


    public $_hasAndBelongsToMany = array('blog.post');


    public $_fields = array(
        'name' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'slug' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        )
    );


    public $_indexes = array('slug');


}
