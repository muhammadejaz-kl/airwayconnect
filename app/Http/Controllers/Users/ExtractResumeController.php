<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Wapmorgan\DocxFileReader\DocxFileReader;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Storage;
use Imagick;

class ExtractResumeController extends Controller
{
    public function parseResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:8192',
        ]);

        $file = $request->file('resume');
        $extension = strtolower($file->getClientOriginalExtension());
        $text = '';

        try {
            if ($extension === 'pdf') {
                $text = $this->extractFromPdf($file->getPathname());
            } elseif ($extension === 'docx') {
                $reader = new DocxFileReader($file->getPathname());
                $text = $reader->readText();
            } elseif ($extension === 'doc') {
                $phpWord = IOFactory::load($file->getPathname());
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . ' ';
                        }
                    }
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Unsupported file type.']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to parse file: ' . $e->getMessage(),
            ]);
        }

        $text = preg_replace('/\s+/', ' ', strip_tags($text));
        $text = trim($text);

        $data = $this->extractData($text);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function extractFromPdf($path)
    {
        $text = trim(Pdf::getText($path));

        if (strlen($text) < 20) {
            $ocrText = '';
            $tempDir = storage_path('app/pdf_ocr_temp');

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            try {
                $outputPrefix = $tempDir . '/page';
                $cmd = "pdftoppm -jpeg -r 300 " . escapeshellarg($path) . " " . escapeshellarg($outputPrefix);
                exec($cmd);

                foreach (glob($tempDir . '/page-*.jpg') as $imgPath) {
                    $ocrText .= (new TesseractOCR($imgPath))->lang('eng')->psm(3)->run() . "\n";
                    @unlink($imgPath);
                }

                $text = trim($ocrText);
            } catch (\Exception $e) {
                $text = $this->extractUsingImagick($path, $tempDir);
            }

            @rmdir($tempDir);
        }

        return $text;
    }

    private function extractUsingImagick($path, $tempDir)
    {
        $ocrText = '';
        try {
            $imagick = new Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($path);
            $imagick->setImageFormat('jpeg');

            foreach ($imagick as $i => $page) {
                $tempPath = "{$tempDir}/page_{$i}.jpg";
                $page->writeImage($tempPath);
                $ocrText .= (new TesseractOCR($tempPath))->lang('eng')->psm(3)->run() . "\n";
                @unlink($tempPath);
            }

            $imagick->clear();
            $imagick->destroy();
        } catch (\Exception $e) {
            $ocrText = 'OCR failed: ' . $e->getMessage();
        }

        return trim($ocrText);
    }

    private function extractData($text)
    {
        $data = [
            'first_name' => null,
            'surname' => null,
            'phone' => null,
            'email' => null,
            'residential_address' => null,
            'job_title' => null,
            'employer' => null,
            'location' => null,
            'start_date' => null,
            'end_date' => null,
            'school_name' => null,
            'degree' => null,
            'field_of_study' => null,
            'skills' => [],
            'professional_summary' => null,
        ];

        if (preg_match('/([A-Z][a-zA-Z]+)\s+([A-Z][a-zA-Z]+)/', $text, $m)) {
            $data['first_name'] = $m[1] ?? null;
            $data['surname'] = $m[2] ?? null;
        }

        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}/', $text, $m)) {
            $data['email'] = $m[0];
        }

        if (preg_match('/(\+?\d{1,3}[-.\s]?)?\d{10}/', $text, $m)) {
            $data['phone'] = preg_replace('/\D/', '', $m[0]);
        }

        if (preg_match('/\d{1,3}\s+[A-Za-z0-9\s,]+(Street|St|Avenue|Ave|Road|Rd|Block|Lane|Ln)/i', $text, $m)) {
            $data['residential_address'] = trim($m[0]);
        }

        if (preg_match('/(Developer|Engineer|Manager|Designer|Coordinator|Analyst|Technician|Consultant|Supervisor|Executive)/i', $text, $m)) {
            $data['job_title'] = ucfirst(strtolower($m[0]));
        }

        if (preg_match('/(?:at|@)\s+([A-Z][a-zA-Z&\s]+)/', $text, $m)) {
            $data['employer'] = trim($m[1]);
        }

        if (preg_match('/\b(New York|Los Angeles|London|Delhi|Mumbai|Bangalore|Dubai|Singapore)\b/i', $text, $m)) {
            $data['location'] = ucfirst(strtolower($m[0]));
        }

        if (preg_match_all('/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s?\d{4}/i', $text, $m)) {
            $data['start_date'] = $m[0][0] ?? null;
            $data['end_date'] = end($m[0]) ?? null;
        }

        if (preg_match('/(University|College|Institute|School)[^.,\n]*/i', $text, $m)) {
            $data['school_name'] = trim($m[0]);
        }

        if (preg_match('/(Bachelor|Master|B\.?Tech|M\.?Tech|Ph\.?D|Diploma|Associate)\s+(in\s+[A-Za-z\s]+)/i', $text, $m)) {
            $data['degree'] = trim($m[1]);
            $data['field_of_study'] = isset($m[2]) ? trim(preg_replace('/^in\s+/i', '', $m[2])) : null;
        }

        if (preg_match('/(Skills|Technical Skills|Key Skills)\s*[:\-]?\s*(.+?)(?=\s*(Education|Experience|Summary|$))/is', $text, $m)) {
            $skillsText = trim($m[2]);
            $skills = preg_split('/[,;•\-\n]/', $skillsText);
            $skills = array_filter(array_map(fn($s) => ucfirst(trim($s)), $skills));
            $data['skills'] = array_values($skills);
        }

        if (preg_match('/(Summary|Profile|About Me|Overview)\s*[:\-]?\s*(.+?)(?=\s*(Experience|Skills|Education|$))/is', $text, $m)) {
            $data['professional_summary'] = trim($m[2]);
        }

        return $data;
    }
}
