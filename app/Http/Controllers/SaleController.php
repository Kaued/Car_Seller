<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Car;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    private Sale $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function index(FilterRequest $request)
    {
        $saleRepository = new SaleRepository($this->sale);

        $request->validated();

        if ($request->has("attribute")) {
            $saleRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $saleRepository->filterSelection($request->filter);
        }

        if ($request->has("with")) {
            $saleRepository->with($request->with);
        }

        if ($request->has("filterWith")) {
            $saleRepository->filterWith($request->filterWith);
        }

        return response($saleRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $validation = $request->validated();
        $car = Car::find($validation["car_id"]);
        if($car->sold){
            return response("Carro já foi vendido anteriormente");
        }
        $tax = PaymentMethod::find($validation["payment_method_id"]);
        $validation["total_price"]= $car->price*($tax->tax+1);
        $this->sale = $this->sale->create($validation);
        $car->fill(["sold"=>true]);
        $car->save();
        return response($this->sale, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = $this->sale->find($id);
        if ($sale === null) {
            return response(["message" => "Cliente não encontrado"], 404);
        }
        return response($sale, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleRequest $request, $id)
    {
        $changeSale = $this->sale->find($id);

        if ($changeSale === null) {
            return response(["message" => "Cliente não encontrado"], 404);
        }

        $validation = $request->validated();

        $car = Car::find($validation["car_id"]);
        $tax = PaymentMethod::find($validation["payment_method_id"]);

        if ($car->sold && $changeSale->car_id != $car->id) {
            return response("Carro já foi vendido anteriormente");
        }

        $validation["total_price"] = $request->has("total_price") ? $validation["total_price"] : $car->price * ($tax->tax + 1);

        $changeSale->fill($validation);

        $changeSale->save();

        $car->fill(["sold" => true]);
        $car->save();

        return response($changeSale, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteSale = $this->sale->find($id);

        if ($deleteSale === null) {
            return response(["message" => "Cliente não encontrado"], 404);
        }

        $deleteSale->delete();
        return response(["message"=>"Deletado Com sucesso"], 200);
    }
}
