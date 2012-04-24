<?php return array(

    'configs' => array(
        'twitter.age' => 100
    ),

    'routes' => array(
    	'twitter' => array(
    			'callback' => array('twitter', 'entryPoint')
    	),
        'twitter/hello' => array(
            'callback' => array('twitter', 'hello')
        ),
        'twitter/bye' => array(
            'callback' => array('twitter', 'bye')
        ),
    	'twitter/tweet' => array(
    		'callback' => array('twitter', 'tweet')
    	)
    )

    /*
    'permissions' => array(),

    'events' => array()
    */

);
