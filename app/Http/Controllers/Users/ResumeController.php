<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ResumeContactDetail;
use App\Models\ResumeEducationCertification;
use App\Models\ResumeUserSkill;
use App\Models\ResumeUserSummary;
use App\Models\ResumeWorkHistory;
use App\Models\SkillCategory;
use App\Models\UserResume;
use Illuminate\Http\Request;
use Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $resume = UserResume::where('user_id', $user->id)->first();

        return view('user.resume.index', compact('resume'));
    }

    public function searchSkills(Request $request)
    {
        $query = $request->input('q');

        $category = SkillCategory::where('name', 'like', '%' . $query . '%')->first();

        if (!$category) {
            return response()->json([]);
        }

        $skills = $category->skills()->pluck('skill');

        return response()->json($skills);
    }

    public function saveTemplateSession(Request $request)
    {
        $request->validate([
            'template_id' => 'required|string'
        ]);
        session()->put('selected_template_id', $request->template_id);

        return response()->json(['success' => true]);
    }

    // public function getTemplatePreview()
    // {
    //     $templateId = session('selected_template_id');

    //     $mapping = [
    //         'template1' => 'user.resume.partials.templates.template2',
    //         'template2' => 'user.resume.partials.templates.template3',
    //         'template3' => 'user.resume.partials.templates.template4',
    //     ];

    //     $view = $mapping[$templateId] ?? 'user.resume.partials.templates.template1';

    //     return view($view)->render();
    // }

    public function getTemplatePreview()
    {
        $templateId = session('selected_template_id') ?? 'template1';

        return response()->json(['templateId' => $templateId]);
    }

    public function saveExperienceLevelSession(Request $request)
    {
        $request->validate([
            'experience_level' => 'required|string'
        ]);

        session()->put('experience_level', $request->experience_level);

        return response()->json([
            'success' => true,
            'experience_level' => $request->experience_level
        ]);
    }

    public function saveJob(Request $request)
    {
        $job = $request->all();

        $jobs = session()->get('jobs', []);

        $jobs[] = $job;

        session()->put('jobs', $jobs);

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    public function getJobs()
    {
        $jobs = session()->get('jobs', []);
        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    public function updateJob(Request $request)
    {
        $jobs = session('jobs', []);
        $index = $request->input('index');

        if (isset($jobs[$index])) {
            $jobs[$index] = $request->except(['_token', 'index']);
            session(['jobs' => $jobs]);
        }

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    public function deleteJob(Request $request)
    {
        $jobs = session('jobs', []);
        $index = $request->input('index');

        if (isset($jobs[$index])) {
            unset($jobs[$index]);
            $jobs = array_values($jobs);
            session(['jobs' => $jobs]);
        }

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    public function saveBestMatchEducationSession(Request $request)
    {
        $request->validate([
            'best_match' => 'required|string|max:255',
        ]);

        session()->put('best_match', $request->best_match);

        return response()->json([
            'success' => true,
            'best_match' => $request->best_match
        ]);
    }

    public function saveEducationSession(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'graduation_month' => 'required|string',
            'graduation_year' => 'required|string',
        ]);

        $educations = session()->get('educations', []);

        $eduData = [
            'school_name' => $request->school_name,
            'school_location' => $request->school_location,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'graduation_month' => $request->graduation_month,
            'graduation_year' => $request->graduation_year,
            'additional_coursework' => $request->additional_coursework,
            'certificates' => $request->certificates ?? [],
        ];

        $educations[] = $eduData;

        session()->put('educations', $educations);

        return response()->json([
            'success' => true,
            'educations' => $educations
        ]);
    }

    public function getEducations(Request $request)
    {
        $index = $request->query('index');
        $educations = session()->get('educations', []);

        if ($index !== null && isset($educations[$index])) {
            return response()->json([
                'success' => true,
                'education' => $educations[$index],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Education not found',
        ], 404);
    }

    public function updateEducation(Request $request)
    {
        $request->validate([
            'index' => 'required|integer',
            'school_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'graduation_month' => 'required|string',
            'graduation_year' => 'required|string',
        ]);

        $educations = session()->get('educations', []);

        if (!isset($educations[$request->index])) {
            return response()->json([
                'success' => false,
                'message' => 'Education not found'
            ], 404);
        }

        $educations[$request->index] = [
            'school_name' => $request->school_name,
            'school_location' => $request->school_location,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'graduation_month' => $request->graduation_month,
            'graduation_year' => $request->graduation_year,
            'additional_coursework' => $request->additional_coursework,
            'certificates' => $request->certificates ?? [],
        ];

        session()->put('educations', $educations);

        return response()->json([
            'success' => true,
            'educations' => $educations
        ]);
    }

    public function deleteEducation(Request $request)
    {
        $index = $request->input('index');
        $educations = session()->get('educations', []);

        if (isset($educations[$index])) {
            unset($educations[$index]);
            $educations = array_values($educations);
            session()->put('educations', $educations);
        }

        return response()->json([
            'success' => true,
            'educations' => $educations
        ]);
    }

    public function store(Request $request)
    {
        $step = $request->input('step');
        $userId = auth()->id();

        switch ($step) {
            case 'details':
                $data = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                    'phone' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                    'date_of_birth' => 'required|date',
                    'nationality' => 'required|string|max:255',
                    'residential_address' => 'required|string|max:500',
                    'is_licensed' => 'nullable|boolean',
                    'license_no' => 'nullable|string|max:255',
                    'hobbies' => 'nullable|string|max:255',
                    'language' => 'required|string|max:100',
                    'marital_status' => 'nullable|string|max:50',
                ]);

                $data['user_id'] = $userId;
                $data['active_status'] = 1;

                $experienceLevel = session()->get('experience_level');
                if ($experienceLevel) {
                    $data['experience_level'] = $experienceLevel;
                }

                $record = ResumeContactDetail::updateOrCreate(
                    ['user_id' => $userId],
                    $data
                );

                return response()->json([
                    'success' => true,
                    'id' => $record->id,
                    'step' => 'details'
                ]);


            case 'work':
                $sessionJobs = session()->get('jobs', []);

                $currentJob = [];
                if ($request->filled('job_title') && $request->filled('employer')) {
                    $currentJob = $request->validate([
                        'job_title' => 'required|string|max:255',
                        'employer' => 'required|string|max:255',
                        'location' => 'required|string|max:255',
                        'remote' => 'nullable|boolean',
                        'start_date' => 'required|string|max:50',
                        'end_date' => 'nullable|string|max:50',
                        'currently_work' => 'nullable|boolean',
                        'experienced_with' => 'nullable|string',
                    ]);
                    $currentJob['user_id'] = $userId;
                    $currentJob['active_status'] = 1;
                }

                $allJobs = $sessionJobs;
                if (!empty($currentJob)) {
                    $allJobs[] = $currentJob;
                }

                ResumeWorkHistory::where('user_id', $userId)->delete();

                foreach ($allJobs as $index => $job) {
                    ResumeWorkHistory::create(array_merge($job, [
                        'user_id' => $userId,
                        'active_status' => 1,
                        'count' => $index + 1,
                    ]));
                }

                // session()->forget('jobs');

                return response()->json([
                    'success' => true,
                    'count' => count($allJobs),
                    'step' => 'work'
                ]);


            case 'education':
                $sessionEducations = session()->get('educations', []);
                $bestMatch = session()->get('best_match');

                $currentEducation = [];
                if ($request->filled('school_name') && $request->filled('degree')) {
                    $currentEducation = $request->validate([
                        'school_name' => 'required|string|max:255',
                        'school_location' => 'nullable|string|max:255',
                        'degree' => 'required|string|max:100',
                        'field_of_study' => 'nullable|string|max:255',
                        'graduation_month' => 'required|string|max:20',
                        'graduation_year' => 'required|string|max:10',
                        'certificates' => 'nullable',
                        'additional_coursework' => 'nullable|string',
                    ]);

                    if (is_array($currentEducation['certificates'] ?? null)) {
                        $currentEducation['certificates'] = implode(', ', $currentEducation['certificates']);
                    }

                    $currentEducation['user_id'] = $userId;
                    $currentEducation['best_match'] = $bestMatch;
                }

                $allEducations = $sessionEducations;
                if (!empty($currentEducation)) {
                    $allEducations[] = $currentEducation;
                }

                ResumeEducationCertification::where('user_id', $userId)->delete();

                foreach ($allEducations as $index => $edu) {
                    if (is_array($edu['certificates'] ?? null)) {
                        $edu['certificates'] = implode(', ', $edu['certificates']);
                    }

                    ResumeEducationCertification::create(array_merge($edu, [
                        'user_id' => $userId,
                        'best_match' => $edu['best_match'] ?? $bestMatch,
                        'count' => $index + 1,
                    ]));
                }

                // session()->forget(['best_match', 'educations']);

                return response()->json([
                    'success' => true,
                    'count' => count($allEducations),
                    'step' => 'education'
                ]);


            case 'skills':
                $skills = $request->input('skills', []);

                ResumeUserSkill::where('user_id', $userId)->delete();

                if (!empty($skills)) {
                    foreach ($skills as $skill) {
                        ResumeUserSkill::updateOrCreate(
                            ['user_id' => $userId, 'skill' => $skill],
                            []
                        );
                    }
                }

                return response()->json([
                    'success' => true,
                    'step' => 'skills',
                ]);


            case 'summary':
                $data = $request->validate([
                    'professional_summary' => 'required|string',
                ]);

                $record = ResumeUserSummary::updateOrCreate(
                    ['user_id' => $userId],
                    ['summary' => $data['professional_summary']]
                );

                return response()->json([
                    'success' => true,
                    'id' => $record->id,
                    'step' => 'summary',
                ]);

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid step'
                ], 422);
        }
    }

    public function fetchFinalizeTemplate()
    {
        $templateId = session('selected_template_id');

        $mapping = [
            'template1' => 'user.resume.partials.templates.template2',
            'template2' => 'user.resume.partials.templates.template3',
            'template3' => 'user.resume.partials.templates.template4',
        ];

        $view = $mapping[$templateId] ?? 'user.resume.partials.templates.template2';

        return view($view)->render();
    }

    public function saveResumeImage(Request $request)
    {
        $user = auth()->user();

        $hasContact = ResumeContactDetail::where('user_id', $user->id)->exists();
        $hasWork = ResumeWorkHistory::where('user_id', $user->id)->exists();
        $hasEducation = ResumeEducationCertification::where('user_id', $user->id)->exists();
        $hasSkills = ResumeUserSkill::where('user_id', $user->id)->exists();
        $hasSummary = ResumeUserSummary::where('user_id', $user->id)->exists();

        if (!$hasContact || !$hasWork || !$hasEducation || !$hasSkills || !$hasSummary) {
            return response()->json([
                'error' => 'Please fill the required fields before saving your resume.'
            ], 400);
        }

        $imageData = $request->input('image');
        if (!$imageData) {
            return response()->json(['error' => 'No image data'], 400);
        }

        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = $user->id . '_' . time() . '.png';
        $path = 'resumes/' . $imageName;

        Storage::disk('public')->put($path, base64_decode($image));

        UserResume::updateOrCreate(
            ['user_id' => $user->id],
            [
                'resume'      => $path,
                'template_id' => session('selected_template_id', 'template1'),
            ]
        );

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function convertToPdf(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string',
        ]);

        $imageRelative = $request->image_path;
        $imagePath = storage_path('app/public/' . ltrim($imageRelative, '/'));

        if (!file_exists($imagePath)) {
            return response()->json(['error' => 'Image not found.'], 404);
        }

        try {
            $dpi = 150;
            $a4HeightPx = intval((297 / 25.4) * $dpi);
            $a4WidthPx = intval((210 / 25.4) * $dpi);

            $originalData = file_get_contents($imagePath);
            $srcImage = @imagecreatefromstring($originalData);
            if ($srcImage === false) {
                $imageData = base64_encode($originalData);
                $srcDataUri = 'data:image/png;base64,' . $imageData;
            } else {
                $origW = imagesx($srcImage);
                $origH = imagesy($srcImage);

                $scale = min(1, $a4WidthPx / $origW, $a4HeightPx / $origH);

                if ($scale < 1) {
                    $newW = max(1, intval($origW * $scale));
                    $newH = max(1, intval($origH * $scale));

                    $tmp = imagecreatetruecolor($newW, $newH);
                    imagealphablending($tmp, false);
                    imagesavealpha($tmp, true);
                    imagecopyresampled($tmp, $srcImage, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

                    $tmpFile = sys_get_temp_dir() . '/resume_resized_' . uniqid() . '.png';
                    imagepng($tmp, $tmpFile, 6);
                    imagedestroy($tmp);
                    imagedestroy($srcImage);

                    $imageData = base64_encode(file_get_contents($tmpFile));
                    $srcDataUri = 'data:image/png;base64,' . $imageData;

                    @unlink($tmpFile);
                } else {
                    imagedestroy($srcImage);
                    $imageData = base64_encode($originalData);
                    $srcDataUri = 'data:image/png;base64,' . $imageData;
                }
            }

            $html = <<<HTML
                <!doctype html>
                <html>
                <head>
                <meta charset="utf-8">
                <style>
                    @page { size: A4 portrait; margin: 0; }
                    html, body { margin: 0; padding: 0; }
                    .a4 { width:210mm; height:297mm; margin:0; padding:0; box-sizing: border-box; background:#fff; display:flex; align-items:center; justify-content:center; }
                    .a4 img { display:block; width:auto; height:auto; max-width:210mm; max-height:297mm; margin:0; padding:0; }
                </style>
                </head>
                <body>
                    <div class="a4">
                        <img src="{$srcDataUri}" alt="Resume"/>
                    </div>
                </body>
                </html>
                HTML;

            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait')->setOption('isRemoteEnabled', true)
                ->setOption('dpi', $dpi);

            $pdfName = pathinfo($imageRelative, PATHINFO_FILENAME) . '.pdf';
            $pdfPath = 'resumes/' . $pdfName;

            Storage::disk('public')->put($pdfPath, $pdf->output());

            return response()->json([
                'success' => true,
                'pdf_path' => asset('storage/' . $pdfPath)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Conversion failed: ' . $e->getMessage()], 500);
        }
    }

    private function buildResumeData(int $userId): array
    {
        $contact    = ResumeContactDetail::where('user_id', $userId)->first();
        $works      = ResumeWorkHistory::where('user_id', $userId)->get();
        $educations = ResumeEducationCertification::where('user_id', $userId)->get();
        $skills     = ResumeUserSkill::where('user_id', $userId)->pluck('skill');
        $summary    = ResumeUserSummary::where('user_id', $userId)->first();

        // Decode certificates stored as a JSON array string (e.g. ["Test Certification"])
        foreach ($educations as $edu) {
            $raw = $edu->certificates ?? '';
            if (is_string($raw) && str_starts_with(ltrim($raw), '[')) {
                $decoded = json_decode($raw, true);
                $edu->certificates = is_array($decoded)
                    ? implode(', ', array_filter($decoded))
                    : $raw;
            }
        }

        return compact('contact', 'works', 'educations', 'skills', 'summary');
    }

    public function serveResumeImage()
    {
        $user   = auth()->user();
        $resume = UserResume::where('user_id', $user->id)->first();

        if (!$resume || !$resume->resume) {
            abort(404);
        }

        $path = storage_path('app/public/' . $resume->resume);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, ['Content-Type' => 'image/png', 'Cache-Control' => 'no-store']);
    }

    private function renderResumePdf(int $userId): \Barryvdh\DomPDF\PDF
    {
        $userResume = UserResume::where('user_id', $userId)->first();
        if (!$userResume) {
            abort(404, 'No saved resume found. Please complete the Resume Builder first.');
        }

        $data = $this->buildResumeData($userId);

        // Guard: ensure core data exists
        if (!$data['contact'] || $data['works']->isEmpty()) {
            abort(422, 'Resume data is incomplete. Please go through the Resume Builder again to repopulate your resume.');
        }

        $templateId = $userResume->template_id ?? 'template1';
        $pdfViewMap = [
            'template1' => 'user.resume.pdf.template1',
            'template2' => 'user.resume.pdf.template2',
            'template3' => 'user.resume.pdf.template3',
        ];
        $view = $pdfViewMap[$templateId] ?? 'user.resume.pdf.template1';

        return Pdf::loadView($view, $data)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isRemoteEnabled', false)
            ->setOption('dpi', 150);
    }

    public function viewResumePdf()
    {
        $user = auth()->user();
        $pdf  = $this->renderResumePdf($user->id);
        return $pdf->stream('resume_' . $user->id . '.pdf');
    }

    public function downloadResumePdf()
    {
        $user = auth()->user();
        $pdf  = $this->renderResumePdf($user->id);
        return $pdf->download('resume_' . $user->id . '.pdf');
    }

    public function clearSession(Request $request)
    {
        // Only clear session variables — resume data must stay in the DB so
        // downloadResumePdf / viewResumePdf can render the PDF at any time.
        session()->forget([
            'jobs',
            'educations',
            'best_match',
            'experience_level',
            'selected_template_id'
        ]);

        return response()->json(['success' => true]);
    }

}
