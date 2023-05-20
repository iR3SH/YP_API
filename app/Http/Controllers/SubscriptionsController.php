<?php

namespace App\Http\Controllers;

use App\Models\BuyLogs;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        $user = User::where('id', $request->get('idUser'))->get()[0];
        $subscription = Subscriptions::where('idUser', $user->id)->get();
        if(count($subscription) > 0){
            return $this->sendResponse($subscription, "Subscription for User has been found");
        }
        else {
            return $this->sendError('No subscription has been found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idUser" => 'required',
            "timestamp" => 'required',
            "nextCost" => 'required',
            "idAvantage" => 'required',
        ]);
        $verif = Subscriptions::where('idUser', $request->get('idUser'))->get();
        if(count($verif) > 0){
            return $this->sendError("This user already have a subscription");
        }
        $subscription = Subscriptions::create($request->all());
        BuyLogs::create([
            'idUser' => $request->get('idUser'),
            'idSubscription' => $subscription->id,
            'cost' => $request->get('nextCost')

        ]);
        return $this->sendResponse($subscription, "Subscription registered successfully !");
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriptions $subscription
     * @return JsonResponse
     */
    public function show(Subscriptions $subscription): JsonResponse
    {
        return $this->sendResponse($subscription, "Subscription found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscriptions $subscription
     * @return Response
     */
    public function edit(Subscriptions $subscription)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Subscriptions $subscription
     * @return JsonResponse
     */
    public function update(Request $request, Subscriptions $subscription): JsonResponse
    {
        $request->validate([
            "timestamp" => 'required',
            "nextCost" => 'required',
        ]);

        $subscription->update($request->all());
        return $this->sendResponse($subscription, 'Subscription updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriptions $subscription
     * @return JsonResponse
     */
    public function destroy(Subscriptions $subscription): JsonResponse
    {
        $subscription->delete();
        return $this->sendResponse($subscription, "Subscription cancelled successfully");
    }
}
