<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private PaymentMethod $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function index(FilterRequest $request)
    {
        $paymentMethodRepository = new PaymentMethodRepository($this->paymentMethod);

        $request->validated();

        if ($request->has("attribute")) {
            $paymentMethodRepository->selectAttributes($request->attribute);
        }

        if ($request->has("filter")) {
            $paymentMethodRepository->filterSelection($request->filter);
        }

        return response($paymentMethodRepository->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $validation = $request->validated();
        $this->paymentMethod = $this->paymentMethod->create($validation);
        return response($this->paymentMethod, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentMethod = $this->paymentMethod->find($id);
        if ($paymentMethod === null) {
            return response(["message" => "Metódo do pagamento não encontrado"], 404);
        }
        return response($paymentMethod, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $changePaymentMethod = $this->paymentMethod->find($id);

        if ($changePaymentMethod === null) {
            return response(["message" => "Metódo do pagamento não encontrado"], 404);
        }

        $validation = $request->validated();

        $changePaymentMethod->fill($validation);

        $changePaymentMethod->save();

        return response($changePaymentMethod, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePaymentMethod = $this->paymentMethod->find($id);

        if ($deletePaymentMethod === null) {
            return response(["message" => "Metódo do pagamento não encontrado"], 404);
        }

        $deletePaymentMethod->delete();
        return response(["message"=>"Deletado Com sucesso"], 200);
    }
}
