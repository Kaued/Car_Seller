<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreSelleRequest;
use App\Http\Requests\UpdateSelleRequest;
use App\Models\Seller;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private Seller $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    public function index(FilterRequest $request)
    {
        $sellerRepository = new SellerRepository($this->seller);

        $request->validated();

        if ($request->has("attribute")) {
            $sellerRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $sellerRepository->filterSelection($request->filter);
        }

        return response($sellerRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSelleRequest $request)
    {
        $validation = $request->validated();
        $this->seller = $this->seller->create($validation);
        return response($this->seller, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = $this->seller->find($id);
        if ($seller === null) {
            return response(["message" => "Vendedor não encontrado"], 404);
        }
        return response($seller, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSelleRequest $request, $id)
    {
        $changeSeller = $this->seller->find($id);

        if ($changeSeller === null) {
            return response(["message" => "Vendedor não encontrado"], 404);
        }

        $validation = $request->validated();

        $changeSeller->fill($validation);

        $changeSeller->save();

        return response($changeSeller, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteSeller = $this->seller->find($id);

        if ($deleteSeller === null) {
            return response(["message" => "Vendedor não encontrado"], 404);
        }

        $deleteSeller->delete();
        return response(["message"=>"Deletado Com sucesso"], 200);
    }
}
