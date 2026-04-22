<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(CouponsDataTable $dataTable)
    {
        return $dataTable->render("admin.coupons.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:coupons,code',
            'discount'    => 'required|numeric|min:1|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $data = [
            'name'        => $request->name,
            'code'        => $request->code,
            'discount'    => $request->discount,
            'description' => $request->description,
        ];

        Coupon::create($data);

        return redirect()->back()->with('success', 'Coupon created successfully!');
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);

        $lastUsedAt = Transaction::where('coupon_id', $coupon->id)
            ->where('payment_status', 'paid')
            ->latest('created_at')
            ->value('created_at');

        // Weekly data — last 7 days
        $weekLabels = [];
        $weekCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $weekLabels[] = $day->format('D');
            $weekCounts[] = Transaction::where('coupon_id', $coupon->id)
                ->whereDate('created_at', $day->toDateString())
                ->count();
        }

        // Monthly data — last 6 months
        $monthLabels = [];
        $monthCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabels[] = $month->format('M');
            $monthCounts[] = Transaction::where('coupon_id', $coupon->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return view('admin.coupons.show', [
            'coupon'      => $coupon,
            'lastUsedAt'  => $lastUsedAt,
            'weeklyData'  => ['labels' => $weekLabels, 'data' => $weekCounts],
            'monthlyData' => ['labels' => $monthLabels, 'data' => $monthCounts],
        ]);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount'    => 'required|numeric|min:1|max:100',
            'description' => 'nullable|string|max:500',
            'status'      => 'required|boolean',
        ]);

        $coupon->update([
            'name'        => $request->name,
            'code'        => $request->code,
            'discount'    => $request->discount,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }
}
