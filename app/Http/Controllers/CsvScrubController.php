<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsvScrubController extends Controller
{
    public function index()
    {
        return view('csv-import.manual.index');
    }

    public function scrub(Request $request)
    {
        if ($request->has('number')) {
            $manualNumbers = explode("\n", $request->input('number'));
            $badRows = [];
            $categoryCounts = [];

            // Fetch categories from the database
            $categories = DB::table('all_rows_table')->distinct('category')->pluck('category');

            foreach ($categories as $category) {
                $categoryCounts[$category] = ['bad' => 0];
            }

            foreach ($manualNumbers as $number) {
                $number = trim($number);
                $cleanedManualNumber = preg_replace('/[^0-9]/', '', $number);
                $duplicateCount = DB::table('all_rows_table')->where('number', $cleanedManualNumber)->count();

                if ($duplicateCount == 0) {
                    // Number is unique
                    continue;
                }

                $categories = $this->determineCategories($cleanedManualNumber);

                $found = false;

                foreach ($categories as $category) {
                    if ($duplicateCount > 0) {
                        $found = true;
                        $badRows[] = [$number, $category, 1]; // 1 indicates bad
                        $categoryCounts[$category]['bad']++;
                    }
                }

                if (!$found) {
                    // Number is unique
                }
            }

            // Generate CSV file for "Bad" numbers
            // Implement code to save CSV file

            // Display results
            return view('csv-import.manual.results', compact('categoryCounts'));
        } else {
            return "Please enter at least one number to check.";
        }
    }

    private function determineCategories($number)
{
    // Implement your logic to determine categories based on the number
    // Fetch categories from the database based on the number
    $categories = [];

    // Example: Using Laravel Query Builder to fetch categories
    $categories = DB::table('all_rows_table')
                    ->whereRaw("REPLACE(number, '+', '') = ?", [$number])
                    ->pluck('category')
                    ->toArray();

    return $categories;
}

}
