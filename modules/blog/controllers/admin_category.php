<?php

class Blog_Admin_CategoryController extends Controller {

    /**
     * Displays a table of categories.
     *
     * Route: admin/blog/categories/manage
     */
    public static function manage()
    {
        $table = Html::table();
        $table->addHeader()->addCol('Name', array('colspan' => 2));

        $cats = Blog::category()->orderBy('name')->all();

        if($cats)
        {
            foreach($cats as $c)
            {
                $row = $table->addRow();
                $row->addCol(Html::a()->get($c->name, 'admin/blog/categories/edit/' . $c->id));
                $row->addCol(
                    Html::a()->get('Delete', 'admin/blog/categories/delete/' . $c->id),
                    array('class' => 'right')
                );
            }
        }
        else
            $table->addRow()->addCol('<em>No categories.</em>', array('colspan' => 2));

        return array(
            'title' => 'Manage Categories',
            'content' => $table->render()
        );
    }

    /**
     * Displays a form for creating categories.
     *
     * Route: admin/blog/categories/create
     */
    public static function create()
    {
        if(isset($_POST['create_category']) && Html::form()->validate())
        {
            if(!Blog::category()->where('name', 'LIKE', $_POST['name'])->first())
            {
                $categoryId = Blog::category()->insert(array(
                    'name' => $_POST['name'],
                    'slug' => String::slugify($_POST['name'])
                ));

                if($categoryId)
                {
                    $_POST = array(); // Clear form
                    Message::ok('Category created successfully.');
                }
                else
                    Message::error('Error creating category. Please try again.');
            }
            else
                Message::error('A category with that name already exists.');
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'validate' => array('required')
                ),
                'create_category' => array(
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
     * Displays a form for editing a category.
     *
     * Route: admin/blog/categories/edit/:id
     *
     * @param int $id The id of the category to edit.
     */
    public static function edit($id)
    {
        if(!$cat = Blog::category()->find($id))
            return ERROR_NOTFOUND;

        if(isset($_POST['update_category']) && Html::form()->validate())
        {
            $status = Blog::category()->where('id', '=', $id)->update(array(
                'name' => $_POST['name'],
                'slug' => $_POST['slug']
            ));

            if($status)
            {
                $cat = Blog::category()->find($id);
                Message::ok('Category updated successfully.');
            }
            else
                Message::error('Error updating category, please try again.');
        }

        $formData[] = array(
            'fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'validate' => array('required'),
                    'default_value' => $cat->name
                ),
                'slug' => array(
                    'title' => 'Slug',
                    'type' => 'text',
                    'validate' => array('required'),
                    'default_value' => $cat->slug
                ),
                'update_category' => array(
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
     * Deletes a category and redirects back to manage category page.
     *
     * Route: admin/blog/categories/delete/:id
     *
     * @param int $id The id of the category to delete.
     */
    public static function delete($id)
    {
        if(Blog::category()->delete($id))
            Message::ok('Category deleted successfully.');
        else
            Message::error('Error deleting category. Please try again.');
        
        Url::redirect('admin/blog/categories');
    }

}
