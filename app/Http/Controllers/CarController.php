<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    private Car $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function index(FilterRequest $request)
    {
        $carRepository = new CarRepository($this->car);

        $request->validated();

        if ($request->has("attribute")) {
            $carRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $carRepository->filterSelection($request->filter);
        }

        if ($request->has("with")) {
            $carRepository->with($request->with);
        }

        if ($request->has("filterWith")) {
            $carRepository->filterWith($request->filterWith);
        }

        return response($carRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        $validation = $request->validated();
        $image = $request->file("image");
        $validation["image_url"] = $image->store("imagens/car", "public");
        $validation["sold"] = false;
        $this->car = $this->car->create($validation);
        return response($this->car, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = $this->car->find($id);
        if ($car === null) {
            return response(["message" => "Carro não encontrado"], 404);
        }
        return response($car, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarRequest $request, $id)
    {
        $changeCar = $this->car->find($id);

        if ($changeCar === null) {
            return response(["message" => "Carro não encontrado"], 404);
        }


        $validation = $request->validated();

        if ($request->has("image")) {
            $image = $request->file("image");
            $image_url = $image->store("imagens/car", "public");

            Storage::disk("public")->delete($changeCar->image_url);

            $changeCar->fill(["image_url" => $image_url]);
        }

        $changeCar->fill($validation);

        $changeCar->save();

        return response($changeCar, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCar = $this->car->find($id);

        if ($deleteCar === null) {
            return response(["message" => "Carro não encontrado"], 404);
        }
        Storage::disk("public")->delete($deleteCar->image_url);

        $deleteCar->delete();
        return response("Deletado com sucesso", 200);
    }
}
