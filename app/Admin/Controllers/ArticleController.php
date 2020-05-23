<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('序号'));
        $grid->column('author.name', __('用户名'));
        $grid->column('type', __('类型'))->display(function($v){
            return $v??'无';
        });

        $grid->column('tag', __('标签'))->display(function($v){
            return $v??'无';
        });
        $grid->column('category.name', __('分类名'));
        $grid->column('title', __('标题'));
        $grid->column('content', __('内容'));

        $states = [
            'on'  => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'default'],
        ];
        $grid->column('is_show', __('显示开关'))->switch($states);
        $grid->column('weight', __('权重'));
        $grid->column('updated_at', __('更新日期'));
        $grid->column('created_at', __('创建日期'));

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('序号'));
        $show->field('user_id', __('用户id'));
        $show->field('type', __('类型'));
        $show->field('tag', __('标签'));
        $show->field('category_id', __('分类id'));
        $show->field('title', __('标题'));
        $show->field('content', __('内容'));
        $show->field('is_show', __('是否显示'));
        $show->field('weight', __('权重'));
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
        $form = new Form(new Article());

        $form->number('user_id', __('用户id'));
        $form->text('type', __('类型'));
        $form->text('tag', __('标签'));
        $form->number('category_id', __('分类id'));
        $form->text('title', __('标题'));
        $form->textarea('content', __('内容'));
        $form->switch('is_show', __('是否显示'))->default(1);
        $form->switch('weight', __('权重'));

        return $form;
    }
}
