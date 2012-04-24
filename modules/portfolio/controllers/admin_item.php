<?php

class Portfolio_Admin_ItemController extends Controller {

    /**
     * Displays a list of tables for each category.
     *
     * Route: admin/portfolio/items
     */
    public static function manage()
    {
        $content = array(); // To be output
        
        if(!$categories = Portfolio::category()->orderBy('name')->all())
        {
            return array(
                'title' => 'No Categories',
                'content' => '<p>You need to ' . Html::a()->get('create some categories', 'admin/portfolio/categories/create') . ' before creating portfolio items.</p>'
            );
        }

        $headers[] = array(
            'Title', 
            'attributes' => array(
                'colspan' => 2
            )
        );

        foreach($categories as $category)
        {
            $rows = array();
            $items = Portfolio::item()->where('category_id', '=', $category->id)->orderBy('created_at')->all();

            if($items)
            {
                foreach($items as $item)
                {
                    $rows[] = array(
                        Html::a()->get($item->title, 'admin/portfolio/items/edit/' . $item->id),
                        array(
                            Html::a()->get('Delete', 'admin/portfolio/items/delete/' . $item->id),
                            'attributes' => array(
                                'class' => 'right'
                            )
                        )
                    );
                }
            }
            else
            {
                $rows[] = array(
                    array(
                        '<em>No items.</em>',
                        'attributes' => array(
                            'colspan' => 2
                        )
                    )
                );
            }

            $content[] = array(
                'title' => $category->name,
                'content' => Html::table()->build($headers, $rows)
            );
        }

        return $content;
    }

    /**
     * Displays a form for creating a new portfolio item.
     *
     * Route: admin/portfolio/items/create
     */
    public static function create()
    {
        if($_POST)
        {
            if(Html::form()->validate())
            {
                if(!Portfolio::item()->where('title', 'LIKE', $_POST['title'])
                    ->andWhere('category_id', '=', $_POST['category_id'])->first())
                {
                    $itemId = Portfolio::item()->insert(array(
                        'category_id' => $_POST['category_id'],
                        'slug' => String::slugify($_POST['title']),
                        'title' => $_POST['title'],
                        'blurb' => $_POST['blurb'],
                        'description' => $_POST['description']
                    ));

                    if($itemId)
                    {
                        Message::ok('Item created successfully.');
                        Url::redirect('admin/portfolio/items/edit/' . $itemId);
                    }
                    else
                        Message::error('Error creating item, please try again.');
                }
                else
                    Message::error('An item with that title already exists in the selected category.');
            }
        }

        $categories = Portfolio::category()->orderBy('name')->all();
        $sortedCategories = array('' => '-');

        if($categories)
            foreach($categories as $c)
                $sortedCategories[$c->id] = $c->name;

        $formData[] = array(
            'fields' => array(
                'category_id' => array(
                    'title' => 'Category',
                    'type' => 'select',
                    'options' => $sortedCategories,
                    'validate' => array('required')
                ),
                'title' => array(
                    'title' => 'Title',
                    'type' => 'text',
                    'validate' => array('required')
                ),
                'blurb' => array(
                    'title' => 'Blurb',
                    'type' => 'textarea',
                    'attributes' => array(
                        'maxlength' => 255
                    )
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea'
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => 'Create Item'
                )
            )
        );

        return array(
            'title' => 'Create Item',
            'content' => Html::form()->build($formData)
        );
    }

    /**
     * Display a form for editing a portfolio item based on the given $id
     *
     * Route: admin/portfolio/items/edit/:num
     *
     * @param int $id The id of the item to edit
     */
    public static function edit($id)
    {
        if(!$item = Portfolio::item()->find($id))
            return EROR_NOTFOUND;

        if(isset($_POST['submit']))
        {

        }

        if(isset($_POST['upload']))
        {
            $image = Media::image()->save('photo');

            if(!$image->hasError())
            {
                Db::table('files_items')->insert(array(
                    'file_id' => $image->getId(),
                    'item_id' => $id
                ));

                Message::ok('Photo uploaded successfully.');
            }
            else
                Message::error($image->getError());
        }

        $categories = Portfolio::category()->orderBy('name')->all();
        $sortedCategories = array('' => '-');

        if($categories)
            foreach($categories as $c)
                $sortedCategories[$c->id] = $c->name;

        $formData[] = array(
            'fields' => array(
                'category_id' => array(
                    'title' => 'Category',
                    'type' => 'select',
                    'options' => $sortedCategories,
                    'validate' => array('required'),
                    'selected' => array($item->category_id)
                ),
                'title' => array(
                    'title' => 'Title',
                    'type' => 'text',
                    'validate' => array('required'),
                    'default_value' => $item->title
                ),
                'blurb' => array(
                    'title' => 'Blurb',
                    'type' => 'textarea',
                    'attributes' => array(
                        'maxlength' => 255
                    ),
                    'default_value' => $item->blurb
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea',
                    'default_value' => $item->description
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => 'Update Item'
                )
            )
        );

        $uploadForm[] = array(
            'fields' => array(
                'photo' => array(
                    'title' => 'Choose a Photo',
                    'type' => 'file'
                ),
                'upload' => array(
                    'type' => 'submit',
                    'value' => 'Upload Photo'
                )
            )
        );

        $rows = array();
        $headers[] = array(
            'Photo',
            'attributes' => array(
                'colspan' => 2
            )
        );

        $photos = Db::table('files_items')->where('item_id', '=', $id)->all();

        if($photos)
        {
            foreach($photos as $photo)
            {
                $rows[] = array(
                    Html::img()->getMedia($photo->file_id, 0, 75, 75),
                    array(
                        Html::a()->get('Delete', 'admin/portfolio/items/edit/' . $id . '/delete-photo/' . $photo->file_id),
                        'attributes' => array(
                            'class' => 'right'
                        )
                    )
                );
            }
        }
        else
        {
            $rows[] = array(
                array(
                    '<em>No photos.</em>',
                    'attributes' => array(
                        'colspan' => 2
                    )
                )
            );
        }

        return array(
            array(
                'title' => 'Edit Item Details',
                'content' => Html::form()->build($formData)
            ),
            array(
                'title' => 'Upload Photo',
                'content' => Html::form()->build($uploadForm, null, 'post', true) // make multipart
            ),
            array(
                'title' => 'Manage Photos',
                'content' => Html::table()->build($headers, $rows)
            )
        );
    }

    /**
     * Deletes an items photo based on the current item id and file id
     *
     * Route: admin/portfolio/items/edit/:num/delete-photo/:num
     *
     * @param int $itemId The item id the file is associated with
     * @param int $fileId The id of the file to be deleted.
     */
    public static function deletePhoto($itemId, $fileId)
    {
        if(Media::delete($fileId))
        {
            if(Db::table('files_items')->where('item_id', '=', $itemId)->andWhere('file_id', '=', $fileId)->delete())
                Message::ok('Photo deleted successfully.');
            else
                Message::error('Error removing record from database, please try again.');
        }
        else
            Message::error('Error deleting photo, please try again.');

        Url::redirect('admin/portfolio/items/edit/' . $itemId);
    }

    /**
     * Deletes a portfolio item based on the given id. All item photos will also be deleted.
     *
     * Route: admin/portfolio/items/delete/:num
     *
     * @param int $id The id of the portfolio item to delete.
     */
    public static function delete($id)
    {
        if($photos = Db::table('files_items')->where('item_id', '=', $id)->all())
            foreach($photos as $photo)
                if(Db::table('files_items')->where('item_id', '=', $id)->andWhere('file_id', '=', $photo->file_id)->delete())
                    Media::delete($photo->file_id);

        if(Portfolio::item()->delete($id))
            Message::ok('Item deleted successfully.');
        else
            Message::error('Error deleting item, please try again.');

        Url::redirect('admin/portfolio/items');
    }

}
