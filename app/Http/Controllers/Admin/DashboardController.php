<?php

namespace App\Http\Controllers\Admin;

use Dompdf\Dompdf;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard/Index');
    }

    public function convertWordToPdf(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx'
        ]);

        $wordFile = $request->file('file');
        $originalFIlename = $wordFile->getClientOriginalName();
        $wordFilePath = $wordFile->storeAs('word', $originalFIlename);

        $newPath = $this->assignValue($wordFilePath);

        //Generate to PDF
        $htmlFilePath = $this->wordToHtml($newPath);
        $this->htmlToPdf($htmlFilePath);

        // Generate URL for the PDF file
        $pdfUrl = storage_path('app/temp/converted.pdf'); // Use Laravel Storage if needed

        // Step 4: Return PDF URL as JSON response
        return response()->download($pdfUrl);

    }

    private function assignValue($filePath)
    {
        $templateProcessor = new TemplateProcessor(storage_path('app/public/' . $filePath));
        $templateProcessor->setValue('firstname', 'Aryum');
        $templateProcessor->setValue('lastname', 'NE');
        $filename = 'word/doc' . now()->timestamp . '.docx';
        $newPath  = storage_path('app/public/' . $filename);
        $templateProcessor->saveAs($newPath);
        return $filename;
    }

    private function wordToHtml($filePath)
    {
        $phpWord = IOFactory::load(storage_path('app/public/'. $filePath));
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        $htmlFilePath = storage_path('app/temp/temp.html');
        $htmlWriter->save($htmlFilePath);

        return $htmlFilePath;
    }

    private function htmlToPdf($filePath)
    {
        $htmlContent = file_get_contents($filePath);

        $domPdf = new Dompdf();
        $domPdf->loadHtml($htmlContent);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();

        $pdfFilePath = storage_path('app/temp/converted.pdf');
        file_put_contents($pdfFilePath, $domPdf->output());

        return $pdfFilePath;
    }
}
