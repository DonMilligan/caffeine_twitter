<?php

class Portfolio_CategoryModel extends Model {

    public $_hasMany = array('portfolio.item');

    public $_fields = array(
        'slug' => array(
            'type' => 'varchar',
            'length' => 255,
            'not null' => true
        ),
        'name' => array(
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
