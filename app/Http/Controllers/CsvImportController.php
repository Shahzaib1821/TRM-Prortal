<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsvImportController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->pluck('category_name');
        return view('csv-import.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'csvfile' => 'required|file|mimes:csv,txt',
            'category' => 'required',
            'column_selection' => 'required',
        ]);

        // Process CSV and insert numbers into the database
        $file = $request->file('csvfile');
        $selected_category = $request->input('category');
        $selected_column_index = $request->input('column_selection');

        $csvData = array_map('str_getcsv', file($file->getPathname()));

        foreach ($csvData as $row) {
            // Check if the selected column index is within bounds
            if ($selected_column_index > 0 && $selected_column_index <= count($row)) {
                $number = trim($row[$selected_column_index - 1]);

                // Remove non-numeric characters from the phone number, except for the leading plus sign
                $number = preg_replace("/[^0-9+]/", "", $number);

                // Validate the phone number format
                if (strlen($number) >= 10) { // Check if the number has at least 10 digits
                    // Insert into the database
                    DB::table('all_rows_table')->insert([
                        'number' => $number,
                        'category' => $selected_category,
                        'created_at' => now()
                    ]);
                } else {
                    // Log invalid phone numbers
                    // \Log::warning("Invalid phone number: $number");
                }
            }
        }

        return redirect()->back()->with('success', 'Data inserted successfully!');
    }
}
