<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

/**
 * @group Admin endpoints
 */
class CurrencyController extends Controller
{
    /**
     * GET Currencies
     *
     * Returns paginated list of currencies.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"First currency","description":"This is the first currency", ...}, ...}
     */
    public function index()
    {
        $currencies = Currency::withTrashed()
            ->latest()
            ->paginate();

        return CurrencyResource::collection($currencies);
    }

    /**
     * POST Currency
     *
     * Creates a new currency record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"First currency","description":"This is the first currency", ...}, ...}
     * @response 422 {"message":"The title field is required.","errors":{"title":["The title field is required."]}, ...}
     */
    public function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::create($request->validated());

        return new CurrencyResource($currency);
    }

    /**
     * GET Currency
     *
     * Returns a currency record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"First currency","description":"This is the first currency", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * PUT Currency
     *
     * Updates currency record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"First currency","description":"This is the first currency", ...}, ...}
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());

        return new CurrencyResource($currency);
    }

    /**
     * DELETE Currency
     *
     * Deletes currency record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->noContent();
    }
}
