<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\View;

class ViewQueryBuilder
{
    protected $model;

    public function __construct(BladeBasedModel $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $files = File::allFiles($this->model->getViewFolder());

        $collection = collect();

        foreach ($files as $value) {
            $viewName = Str::before($value->getFilenameWithoutExtension(), '.blade');

            $view = view("posts.$viewName");
            $data = $view->renderSections();
            $instance = new Post(); // todo make dynamic
            $instance->title = $data['title'] ?? '';
            $instance->slug = $viewName;
            $instance->excerpt = $data['excerpt'] ?? '';
            $instance->date = $data['date'] ?? '';
            $collection->add($instance);
        }
        return $collection;
    }
}
