<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ResumeSkillCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class ResumeSkillController extends Controller
{
    public function index(ResumeSkillCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.resume.category.index');
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        SkillCategory::create([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = SkillCategory::findOrFail($id);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function categoryDestroy($id)
    {
        $category = SkillCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'category deleted successfully!');
    }

    public function skillIndex($categoryId)
    {
        $category = SkillCategory::findOrFail($categoryId);
        $skills = $category->skills;
        return view('admin.resume.skills.index', compact('category', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:skill_categories,id',
        ]);

        Skill::create([
            'skill' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->back()->with('success', 'Skill added successfully.');
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return redirect()->back()->with('success', 'Skill deleted successfully!');
    }
}
 
