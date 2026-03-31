<?php

namespace App\Http\Controllers;

use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use App\DataTables\ResourceCategoryDataTable;
use App\DataTables\ResourcesDataTable;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index(ResourceCategoryDataTable $datatable)
    {
        return $datatable->render('admin.resources.index');
    }

    public function categoryStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('resources', 'public');
        }

        ResourceCategory::create($validated);
        return redirect()->back()->with(['success' => 'Resource Category added successfully!']);
    }

    public function categoryUpdate(Request $request, $id)
    {
        $resourceCategory = ResourceCategory::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('resources', 'public');
        }

        $resourceCategory->update($validated);
        return redirect()->back()->with(['success' => 'Resource Category updated successfully!']);
    }

    public function categoryDestroy($id)
    {
        $resourceCategory = ResourceCategory::findOrFail($id);
        $resourceCategory->delete();
        return redirect()->back()->with(['success' => 'Resource Category deleted successfully!']);
    }

    public function resourceIndex(ResourcesDataTable $datatable)
    {
        $resources = Resource::get();
        return $datatable->render('admin.resources.resource-index', compact('resources'));
    }

    public function resourceStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
            'about' => 'nullable|string'
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('resources', 'public');
        }

        $resource = Resource::create($validated);

        $message = "💡 Boost your knowledge with the new resource: '{$resource->title}'.";

        app(NotificationController::class)->send($message, 'resource');

        return redirect()->back()->with(['success' => 'Resource added successfully and notifications sent!']);
    }

    public function resourceUpdate(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('resources', 'public');
        }

        $resource->update($validated);
        return redirect()->back()->with(['success' => 'Resource updated successfully!']);
    }

    public function resourceDestroy($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();
        return redirect()->back()->with(['success' => 'Resource deleted successfully!']);
    }
}
