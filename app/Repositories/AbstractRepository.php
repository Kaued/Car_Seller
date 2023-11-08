<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAttributes(string $attributes){
        $this->model = $this->model->selectRaw($attributes);
    }

    public function filterSelection(string $filters){
        $separFilters = explode(";", $filters);
        foreach($separFilters as $key=>$filter){
            $conditions = explode(":", $filter);
            $this->model = $this->model->where($conditions[0], $conditions[1], $conditions[2]);
        }
    }

    public function with(string $with){
        $this->model=$this->model->with($with);
    }

    public function getResult(){
        return $this->model->get();
    }
}
?>
