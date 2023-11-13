<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    private Brand $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function index(FilterRequest $request)
    {
        $brandRepository = new BrandRepository($this->brand);

        $request->validated();

        if ($request->has("attribute")) {
            $brandRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $brandRepository->filterSelection($request->filter);
        }

        return response($brandRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $validation = $request->validated();
        $image = $request->file("image");
        $image_url = $image->store("imagens/brand", "public");
        $this->brand = $this->brand->create([
            'name' => $validation["name"],
            'image_url' => $image_url
        ]);
        return response($this->brand, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);
        if ($brand === null) {
            return response(["message" => "Marca não encontrado"], 404);
        }
        return response($brand, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $changeBrand = $this->brand->find($id);

        if ($changeBrand === null) {
            return response(["message" => "Marca não encontrado"], 404);
        }


        $validation = $request->validated();

        if ($request->has("image")) {
            $image = $request->file("image");
            $image_url = $image->store("imagens/brand", "public");

            Storage::disk("public")->delete($changeBrand->image_url);

            $changeBrand->fill(["image_url" => $image_url]);
        }

        $changeBrand->fill($validation);

        $changeBrand->save();

        return response($changeBrand, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteBrand = $this->brand->find($id);

        if ($deleteBrand === null) {
            return response(["message" => "Marca não encontrado"], 404);
        }
        Storage::disk("public")->delete($deleteBrand->image_url);

        $deleteBrand->delete();
        return response(["message"=>"Deletado Com sucesso"], 200);
    }
}
