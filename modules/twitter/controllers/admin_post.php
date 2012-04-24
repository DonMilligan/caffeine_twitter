<?php

class Twitter_Admin_PostController extends Controller {

    /**
     * Displays a table of tweet posts.
     *
     * Route: admin/twitter/posts/manage
     */
    public static function manage()
    {
        $table = Html::table();
        $table->addHeader()->addCol('Title', array('colspan' => 2));
        
        $posts = Twitter::tweet()->orderBy('created_at', 'DESC')->all();

        if($posts)
        {   
            foreach($posts as $p)
            {
                $row = $table->addRow();
                $row->addCol(Html::a()->get($p->subject, 'admin/twitter/posts/edit/' . $p->id));
                $row->addCol(
                    Html::a()->get('Delete', 'admin/twitter/posts/delete/' . $p->id),
                    array('class' => 'right')
                );
            }
        }
        else
            $table->addRow()->addCol('<em>No posts.</em>', array('colspan' => 2));

        return array(
            'title' => 'Manage Posts',
            'content' => $table->render()
        );
    }

    /**
     * Displays a form for creating a new tweet post.
     *
     * Route: admin/twitter/posts/create
     */
    public static function create()
    {
        if(isset($_POST['create_post']) && Html::form()->validate())
        {
            $postId = Twitter::tweet()->insert(array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'subject' => $_POST['subject'],
                'tweet' => $_POST['tweet']
            ));

            if($postId)
            {
                Message::ok('Post created successfully.');
                $_POST = array(); // Clear form
            }
            else
                Message::error('Error creating post. Please try again.');
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'validate' => array('required')
                ),
                'email' => array(
                    'title' => 'Body',
                    'type' => 'textarea',
                    'validate' => array('required')
                ),
                'subject' => array(
                    'title' => 'subject',
                    'type' => 'text',
                    'validate' => array('required')
                ),
        		'tweet' => array(
        				'title' => 'Tweet',
        				'type' => 'textarea',
        				'attributes' => array('class' => 'tinymce'),
        				'validate' => array('required')
        		),
                'create_post' => array(
                    'type' => 'submit',
                    'value' => 'Create Post'
                )
            )
        );

        return array(
            'title' => 'Create Post',
            'content' => Html::form()->build($formData)
        );
    }

    /**
     * Displays a form for editing a tweet post.
     *
     * Route: admin/twitter/posts/edit/:id
     *
     * @param int $id The id of the tweet post to edit.
     */
    public static function edit($id)
    {
        if(!$post = Twitter::tweet()->find($id))
            return ERROR_NOTFOUND;

        if(isset($_POST['update_post']))
        {
            $status = Twitter::tweet()->where('id', '=', $id)->update(array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
            	'subject' => $_POST['subject'],
                'tweet' => $_POST['tweet']
            ));

            if($status)
            {
                Message::ok('Post updated successfully.');
                $post = Twitter::tweet()->find($id); // Get updated for form
            }
            else
                Message::error('Error updating post. Please try again.');
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
//                     'validate' => array('required'),
                    'default_value' => $post->name
                ),
                'email' => array(
                    'title' => 'Email',
                    'type' => 'text',
//                     'validate' => array('required'),
                    'default_value' => $post->email
                ),
                'subject' => array(
                    'title' => 'Subject',
                    'type' => 'text',
//                     'validate' => array('required'),
                    'default_value' => $post->subject
                ),
                'tweet' => array(
                    'title' => 'Tweet',
                    'type' => 'textarea',
                    'attributes' => array('class' => 'tinymce'),
                	'default_value' => $post->tweet
                ),
                'update_post' => array(
                    'type' => 'submit',
                    'value' => 'Update Post'
                )
            )
        );

        return array(
            'title' => 'Edit Post',
            'content' => Html::form()->build($formData)
        );
    }

    /**
     * Deletes a tweet post and redirects back to the manage posts page.
     *
     * Route: admin/twitter/posts/delete/:id
     *
     * @param int $id The id of the tweet post to delete.
     */
    public static function delete($id)
    {
        Db::table('twitter_tweets')->where('post_id', '=', $id)->delete();

        if(Twitter::post()->delete($id))
            Message::ok('Post deleted successfully.');
        else
            Message::error('Error deleting post. Please try again.');

        Url::redirect('admin/twitter/posts');
    }


}