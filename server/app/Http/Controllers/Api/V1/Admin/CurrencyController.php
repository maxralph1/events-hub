<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::withTrashed()
            ->latest()
            ->paginate();

        return CurrencyResource::collection($currencies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::create($request->validated());

        return new CurrencyResource($currency);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());

        return new CurrencyResource($currency);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->noContent();
    }
}
