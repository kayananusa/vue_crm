<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgamaRequest;
use App\Http\Requests\UpdateAgamaRequest;
use App\Http\Resources\Admin\AgamaResource;
use App\Models\Agama;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgamaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('agama_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AgamaResource(Agama::advancedFilter());
    }

    public function store(StoreAgamaRequest $request)
    {
        $agama = Agama::create($request->validated());

        return (new AgamaResource($agama))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('agama_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(Agama $agama)
    {
        abort_if(Gate::denies('agama_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AgamaResource($agama);
    }

    public function update(UpdateAgamaRequest $request, Agama $agama)
    {
        $agama->update($request->validated());

        return (new AgamaResource($agama))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Agama $agama)
    {
        abort_if(Gate::denies('agama_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new AgamaResource($agama),
            'meta' => [],
        ]);
    }

    public function destroy(Agama $agama)
    {
        abort_if(Gate::denies('agama_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $agama->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
