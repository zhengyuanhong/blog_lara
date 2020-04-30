<?php

namespace App\Admin\Controllers;

use App\Models\Categories;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '书籍管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Categories());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('创建者'))->display(function($user_id){
            /** @var User $user */
            $user = User::find($user_id);
            return $user->name;
        });
        $grid->column('name', __('书籍名称'));
        $grid->column('url_name', __('链接名称'));
        $grid->column('url', __('链接地址'));
        $grid->column('img_url', __('图片地址'));
        $grid->column('updated_at', __('更新时间'));
        $grid->column('created_at', __('创建时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Categories::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('创建者'));
        $show->field('name', __('书籍名称'));
        $show->field('url_name', __('链接名称'));
        $show->field('url', __('链接地址'));
        $show->field('img_url', __('图片地址'));
        $show->field('updated_at', __('更新时间'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Categories());

        $form->number('user_id', __('创建者'));
        $form->text('name', __('书籍名称'));
        $form->text('url_name', __('链接名称'));
        $form->url('url', __('链接地址'));
        $form->text('img_url', __('图片地址'));

        return $form;
    }
}
