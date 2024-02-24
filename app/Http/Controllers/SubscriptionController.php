<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    /**
     * This method handles the subscription of an email to a website.
     *
     * It first checks if the email is already subscribed to the website.
     * If it is not, it creates a new subscription and links it to the website.
     *
     * @param  Request $request
     * @param  Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(SubscriptionRequest $request, Website $website)
    {
        $email = $request->email;
        $website_id = $website->id;

        // Check if the email already exists in subscriptions table
        if (Subscription::where('email', $email)
            ->where('website_id', $website_id)
            ->exists()) {
            return response(['error' => 'Already subscribed'], 409);
        }

        $subscription = new Subscription;
        $subscription->website_id = $website_id;
        $subscription->email = $email;
        $subscription->save();

        return response($subscription, 201);
    }
    /**
     * This method handles the unsubscription of an email from a website.
     *
     * It finds the subscription for the provided email and deletes it.
     *
     * @param  Website $website
     * @param  string  $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe(Website $website, $email)
    {
        $subscription = $website->subscriptions()->where('email', $email)->first();

        if(!$subscription){
            return response(['error' => 'Subscription does not exist'], 404);
        }

        $subscription->delete();

        return response(null, 204);
    }
    
    /**
     * This method returns a list of all the subscriptions for a given website.
     *
     * @param  Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscriptions(Website $website)
    {
        $subscriptions = $website->subscriptions;
        return response($subscriptions);
    }
}