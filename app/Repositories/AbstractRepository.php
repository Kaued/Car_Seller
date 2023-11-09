<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery\Expectation;
use Throwable;

abstract class AbstractRepository
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAttributes(string $attributes)
    {
        $this->model = $this->model->selectRaw($attributes);
    }

    public function filterSelection(string $filters)
    {
        $separFilters = explode(";", $filters);
        foreach ($separFilters as $key => $filter) {
            $conditions = explode(":", $filter);
            $this->model = $this->model->where($conditions[0], $conditions[1], $conditions[2]);
        }
    }

    public function with(string $with)
    {
        $foreign = explode(",", $with);

        foreach ($foreign as $key => $w) {
            $this->model = $this->model->with($w);
        }
    }

    public function filterWith(string $filtersWith)
    {

        $filters = explode("|", $filtersWith);

        foreach ($filters as $key => $filter) {

            $where = explode("-", $filter, 2);

            $with = $where[0];
            $separFilters = explode(";", $where[1]);

            foreach ($separFilters as $key => $query) {
                $conditions = explode(":", $query);

                $this->model = $this->model->whereRelation($with, $conditions[0], $conditions[1], $conditions[2]);
            }
        }
    }



    public function getResult()
    {
        return $this->model->get();
    }
}
