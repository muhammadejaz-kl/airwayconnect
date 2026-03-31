<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

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
