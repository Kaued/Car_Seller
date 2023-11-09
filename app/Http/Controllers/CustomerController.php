<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreCustomeRequest;
use App\Http\Requests\UpdateCustomeRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(FilterRequest $request)
    {
        $customerRepository = new CustomerRepository($this->customer);

        $request->validated();

        if($request->has("attribute")){
            $customerRepository->selectAttributes($request->attribute);
        }

        if($request->has("filter")){
            $customerRepository->filterSelection($request->filter);
        }

        return response($customerRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomeRequest $request)
    {
        $validation = $request->validated();
        $this->customer=$this->customer->create($validation);
        return response($this->customer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customer->find($id);
        if($customer === null){
            return response(["message"=>"Cliente não encontrado"], 404);
        }
        return response($customer, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomeRequest $request, $id)
    {
        $changeCustomer = $this->customer->find($id);

        if($changeCustomer === null){
            return response(["message" => "Cliente não encontrado"], 404);
        }

        $validation = $request->validated();

        $changeCustomer->fill($validation);

        $changeCustomer->save();

        return response($changeCustomer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCustomer = $this->customer->find($id);

        if ($deleteCustomer === null) {
            return response(["message" => "Cliente não encontrado"], 404);
        }

        $deleteCustomer->delete();
        return response("Deletado com sucesso", 200);
    }
}
