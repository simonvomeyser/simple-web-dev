<?php

namespace App;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

class ViewQueryBuilder
{
    protected $model;

    public function __construct(BladeBasedModel $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->get();
    }

    public function get()
    {
        $collection = collect();

        if (! File::isDirectory($this->model->getViewFolder())) {
            return $collection;
        }

        $files = File::allFiles($this->model->getViewFolder());

        foreach ($files as $value) {
            $viewName = Str::before($value->getFilenameWithoutExtension(), '.blade');

            $view = view($this->model->lowerBaseName().'.'.$viewName);
            $data = $view->renderSections();

            $instance = (new ReflectionClass($this->model))->newInstance();
            foreach ($data as $key => $value) {
                $instance->$key = $value;
            }
            $instance->exists = true;
            $collection->add($instance);
        }

        return $collection;
    }
}
