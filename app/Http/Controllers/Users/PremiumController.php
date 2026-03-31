<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Coupon;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function index(Request $request)
    {
        $transactionData = null;

        if ($request->has('status') && $request->has('transaction_id')) {
            $this->catchTransaction($request);
            $transactionData = $request->all();
        }

        $subscriptions = Subscription::where('status', '1')->get();
        return view("user.premiums.index", compact('subscriptions', 'transactionData'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->where('status', '1')->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }

        return response()->json([
            'success' => true,
            'discount' => $coupon->discount,
            'coupon_id' => $coupon->id
        ]);
    }

    public function createCheckout(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);
        $amount = intval($request->amount * 100);
        $user = $request->user();
        $couponId = $request->coupon_id ?? null;
        $transactionId = 'txn_' . uniqid();

        Stripe::setApiKey(env('STRIPE_SK'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => ['name' => $subscription->name],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('user.premium.index', [
                    'status' => 'paid',
                    'transaction_id' => $transactionId,
                    'user_id' => $user->id,
                    'plan_id' => $subscription->id,
                    'coupon_id' => $couponId,
                    'amount' => $amount
                ]),
                'cancel_url' => route('user.premium.index', [
                    'status' => 'canceled',
                    'transaction_id' => $transactionId,
                    'user_id' => $user->id,
                    'plan_id' => $subscription->id,
                    'coupon_id' => $couponId,
                    'amount' => $amount
                ]),
            ]);

            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function catchTransaction(Request $request)
    {
        $status = $request->status;
        $transactionId = $request->transaction_id;
        $userId = $request->user_id;
        $planId = $request->plan_id;
        $couponId = $request->coupon_id;
        $paidAmount = ($request->amount ?? 0) / 100;

        $user = User::find($userId);
        $subscription = Subscription::find($planId);
        $coupon = $couponId ? Coupon::find($couponId) : null;

        $totalAmount = $paidAmount;
        $couponDiscount = 0;
        $code = null;

        if ($coupon) {
            $totalAmount = $paidAmount / (1 - ($coupon->discount / 100));
            $couponDiscount = $coupon->discount;
            $code = $coupon->code;
        }

        Transaction::updateOrCreate(
            ['transaction_id' => $transactionId],
            [
                'user_id' => $userId,
                'username' => $user ? $user->name : null,
                'plan_id' => $planId,
                'validity' => $subscription ? $subscription->validity : null,
                'coupon_id' => $couponId,
                'code' => $code,
                'coupon_discount' => $couponDiscount,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'payment_status' => $status
            ]
        );

        if ($status === 'paid' && $user) {
            $startDate = now();
            $endDate = null;

            if ($subscription) {
                if ($subscription->validity === '1_month') {
                    $endDate = $startDate->copy()->addDays(30);
                } elseif ($subscription->validity === '1_year') {
                    $endDate = $startDate->copy()->addDays(365);
                }
            }

            $user->update([
                'premiun_status' => 1,
                'premium_start_date' => $startDate,
                'premium_end_date' => $endDate,
                'plan_id' => $planId
            ]);

            $msg = "🎉 Congratulations {$user->name}! Your subscription has been confirmed for amount \${$paidAmount}, starting from "
                . $startDate->format('d M Y') . " to " . $endDate->format('d M Y') . ".";

            app(NotificationController::class)->send($msg, 'subscription');
        }
    }

    public function updatePremiumStatus(Request $request)
    {
        $userId = $request->input('user_id') ?? Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($user->premiun_status == 1 && $user->premium_end_date) {
            $currentDate = now();
            if ($currentDate->gt($user->premium_end_date)) {
                $user->update([
                    'premiun_status' => 0,
                    'premium_start_date' => null,
                    'premium_end_date' => null,
                    'plan_id' => null
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Premium status updated to non-premium',
                    'user' => $user
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No update required. Premium is still active or already non-premium.'
        ]);
    }
}
