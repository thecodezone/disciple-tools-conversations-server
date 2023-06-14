<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceDestroyRequest;
use App\Http\Requests\ServiceIndexRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Instance;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Instance $instance, ServiceIndexRequest $request)
    {
        $services = Service::where('instance_id', $instance->id)->paginate();

        return ServiceResource::collection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instance $instance, Service $service)
    {
        if (!$service || !$instance) {
            abort(404);
        }

        if ($service->instance_id !== $instance->id) {
            abort(404);
        }

        $service->delete();

        return response()
            ->noContent()
            ->setStatusCode(204);
    }
}
