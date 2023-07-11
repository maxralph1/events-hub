<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;

/**
 * @group Admin endpoints
 */
class CountryController extends Controller
{
    /**
     * GET Countries
     *
     * Returns paginated list of countries.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"Slovekia", ...}, ...}
     */
    public function index()
    {
        $countries = Country::withTrashed()
            ->latest()
            ->paginate();

        return CountryResource::collection($countries);
    }

    /**
     * POST Country
     *
     * Creates a new country record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"Slovekia", ...}, ...}
     * @response 422 {"message":"The name field is required.","errors":{"name":["The name field is required."]}, ...}
     */
    public function store(StoreCountryRequest $request)
    {
        $country = Country::create($request->validated());

        return new CountryResource($country);
    }

    /**
     * GET Country
     *
     * Returns a country record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"Slovekia", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    /**
     * PUT Country
     *
     * Updates country record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"Slovekia", ...}, ...}
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        return new CountryResource($country);
    }

    /**
     * DELETE Country
     *
     * Deletes country record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return response()->noContent();
    }
}
