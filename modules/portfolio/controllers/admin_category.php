<?php

class Portfolio_Admin_CategoryController extends Controller {

    /**
     * Displays a table of categories.
     *
     * Route: admin/portfolio/categories/manage
     */
    public static function manage()
    {
        $rows = array();
        $headers = array(
            array(
                'Name',
                'attributes' => array(
                    'colspan' => 2
                )
            )
        );

        $categories = Portfolio::category()->orderBy('name')->all();

        if($categories)
        {
            foreach($categories as $c)
            {
                $rows[] = array(
                    Html::a()->get($c->name, 'admin/portfolio/categories/edit/' . $c->id),
                    array(
                        Html::a()->get('Delete', 'admin/portfolio/categories/delete/' . $c->id),
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
                    '<em>No categories.</em>',
                    'attributes' => array(
                        'colspan' => 2
                    )
                )
            );
        }

        return array(
            'title' => 'Manage Categories',
            'content' => Html::table()->build($headers, $rows)
        );
    }

    /**
     * Displays a form for creating categories.
     *
     * Route: admin/portfolio/categories/create
     */
    public static function create()
    {
        if($_POST)
        {
            if(Html::form()->validate())
            {
                if(!Portfolio::category()->where('name', 'LIKE', $_POST['name'])->first())
                {
                    $categoryId = Portfolio::category()->insert(array(
                        'slug' => String::slugify($_POST['name']),
                        'name' => $_POST['name'],
                        'description' => $_POST['description']
                    ));

                    if($categoryId)
                    {
                        Message::ok('Category created successfully.');
                        $_POST = array(); // Clear form
                    }
                    else
                        Message::error('Error creating category, please try again.');
                }
                else
                    Message::error('That category name is already in use.');
            }
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'validate' => array('required')
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea'
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => 'Create Category'
                )
            )
        );

        return array(
            'title' => 'Create Category',
            'content' => Html::form()->build($formData)
        );
    }

    /**
     * Displays a form for editing a category based on the given $id.
     *
     * Route: admin/portfolio/categories/edit/:num
     *
     * @param int $id The id of the category to edit
     */
    public static function edit($id)
    {
        if(!$category = Portfolio::category()->find($id))
            return ERROR_NOTFOUND;

        if($_POST)
        {
            if(Html::form()->validate())
            {
                if(!Portfolio::category()->where('name', 'LIKE', $_POST['name'])->first() || $_POST['name'] == $category->name)
                {
                    $status = Portfolio::category()->where('id', '=', $id)->update(array(
                        'slug' => String::slugify($_POST['name']),
                        'name' => $_POST['name'],
                        'description' => $_POST['description']
                    ));

                    if($status)
                    {
                        Message::ok('Category updated successfully.');
                        $category = Portfolio::category()->find($id); // Get updated category for form
                    }
                    elseif($status === 0)
                        Message::info('Nothing changed.');
                    else
                        Message::error('Error updating category, please try again.');
                }
                else
                    Message::error('That category name is already in use.');
            }
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'validate' => array('required'),
                    'default_value' => $category->name
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea',
                    'default_value' => $category->description
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => 'Update Category'
                )
            )
        );

        return array(
            'title' => 'Edit Category',
            'content' => Html::form()->build($formData)
        );
    }

    /**
     * Deletes the given category based on $id.
     *
     * Route: admin/portfolio/categories/delete/:num
     *
     * @param int $id The id of the category to delete.
     */
    public static function delete($id)
    {
        if(Portfolio::category()->delete($id))
            Message::ok('Category deleted successfully.');
        else
            Message::error('Error deleting category, please try again.');

        Url::redirect('admin/portfolio/categories');
    }

}
