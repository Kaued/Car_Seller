<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Models\CarModel;
use App\Repositories\CarModelRepository;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    private CarModel $carModel;

    public function __construct(CarModel $carModel)
    {
        $this->carModel = $carModel;
    }

    public function index(Request $request)
    {
        $carModelRepository = new CarModelRepository($this->carModel);

        if ($request->has("attribute")) {
            $carModelRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $carModelRepository->filterSelection($request->filter);
        }

        if ($request->has("with")) {
            $carModelRepository->with($request->with);
        }

        return response($carModelRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarModelRequest $request)
    {
        $validation = $request->validated();
        $this->carModel = $this->carModel->create($validation);
        return response($this->carModel, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carModel = $this->carModel->with("brand")->find($id);
        if ($carModel === null) {
            return response(["message" => "Modelo não encontrado"], 404);
        }
        return response($carModel, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarModelRequest $request, $id)
    {
        $changeCarModel = $this->carModel->find($id);

        if ($changeCarModel === null) {
            return response(["message" => "Modelo não encontrado"], 404);
        }

        $validation = $request->validated();

        $changeCarModel->fill($validation);

        $changeCarModel->save();

        return response($changeCarModel, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCarModel = $this->carModel->find($id);

        if ($deleteCarModel === null) {
            return response(["message" => "Modelo não encontrado"], 404);
        }

        $deleteCarModel->delete();
        return response("Deletado com sucesso", 200);
    }
}
