<?php

class Portfolio_ItemModel extends Model {

    public $_timestamps = true;

    public $_belongsTo = array('portfolio.category');

    public $_hasAndBelongsToMany = array('media.file');

    public $_fields = array(
        'slug' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'title' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'blurb' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'description' => array(
            'type' => 'text',
            'size' => 'normal',
            'not null' => true
        )
    );

    public $_indexes = array('slug');

}
