<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

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

    public function import()
    {
        return view('csv-import.duplicates.index');
    }

    // public function checkDuplicates(Request $request)
    // {
    //     $request->validate([
    //         'csvfile' => 'required|mimes:csv,txt|max:10240', // adjust max file size as needed
    //         'column_selection' => 'required|numeric|min:1', // assuming column selection starts from 1
    //     ]);

    //     // Check if a file was uploaded
    //     if ($request->hasFile('csvfile') && $request->file('csvfile')->isValid()) {
    //         // Initialize the database connection
    //         $host = env('DB_HOST');
    //         $user = env('DB_USERNAME');
    //         $password = env('DB_PASSWORD');
    //         $database = env('DB_DATABASE');

    //         $conn = mysqli_connect($host, $user, $password, $database);

    //         if (!$conn) {
    //             die("Database connection failed: " . mysqli_connect_error());
    //         }

    //         // Process CSV and calculate good and bad counts
    //         $file = $request->file('csvfile');
    //         $fileContents = file_get_contents($file->path());
    //         $csv_data = array_map('str_getcsv', explode("\n", $fileContents));
    //         $good_count = 0;
    //         $bad_count = 0;
    //         $unique_numbers = [];

    //         // Get the selected column index from the form
    //         $selectedColumnIndex = $request->input('column_selection') - 1; // Adjust for zero-based indexing

    //         // Batch processing: Adjust the batch size as needed
    //         $batchSize = 500;
    //         $good_rows = []; // Move this line outside of the loop
    //         $bad_rows = [];  // Move this line outside of the loop

    //         foreach (array_chunk($csv_data, $batchSize) as $batch) {
    //             foreach ($batch as $row) {
    //                 // Check if the selected column index exists in the row
    //                 if (isset($row[$selectedColumnIndex])) {
    //                     $number = trim($row[$selectedColumnIndex]);

    //                     if (in_array($number, $unique_numbers)) {
    //                         $bad_count++;
    //                         // Add the row to the bad rows array
    //                         $bad_rows[] = $row;
    //                     } else {
    //                         $unique_numbers[] = $number;
    //                         $good_count++;
    //                         // Add the row to the good rows array
    //                         $good_rows[] = $row;
    //                     }
    //                 }
    //             }

    //             // Clear unique numbers for the next batch
    //             $unique_numbers = [];
    //         }

    //         // Calculate percentages
    //         $total_records = $good_count + $bad_count;
    //         $good_percentage = ($good_count / $total_records) * 100;
    //         $bad_percentage = ($bad_count / $total_records) * 100;

    //         // Get the uploaded file name
    //         $fileName = $file->getClientOriginalName();

    //         // Insert scan result information into the database using Eloquent ORM
    //         $userName = "TRM"; // Replace with the actual user name
    //         $totalRows = $total_records;
    //         $goodCount = $good_count;
    //         $badCount = $bad_count;
    //         $date = Carbon::now();

    //         $lastAction = "Generated"; // No need to create links here, that will be handled in the view

    //         DB::table('scanned_info')->insert([
    //             'FileName' => $fileName,
    //             'User' => $userName,
    //             'TotalRows' => $totalRows,
    //             'Good' => $goodCount,
    //             'Bad' => $badCount,
    //             'TimeSpammed' => $date,
    //             'LastAction' => $lastAction,
    //         ]);

    //         // Generate and save compressed good and bad CSV files outside the loop
    //         $goodCsvFile = 'csvFilesFolder/good_' . $fileName . '.gz';
    //         $badCsvFile = 'csvFilesFolder/bad_' . $fileName . '.gz';

    //         // Function to save an array of data as a compressed CSV file
    //         function saveCompressedCsvFile($filename, $data)
    //         {
    //             $file = gzopen($filename, 'w');
    //             foreach ($data as $row) {
    //                 fputcsv($file, $row);
    //             }
    //             gzclose($file);
    //         }

    //         saveCompressedCsvFile($goodCsvFile, $good_rows);
    //         saveCompressedCsvFile($badCsvFile, $bad_rows);

    //         // Provide download links to the compressed generated files
    //         $goodCsvLink = Storage::url($goodCsvFile);
    //         $badCsvLink = Storage::url($badCsvFile);

    //         // Close the database connection
    //         mysqli_close($conn);
    //         // Redirect to the index page
    //         return Redirect::route('index')->with('success', 'CSV file has been processed successfully.');
    //     } else {
    //         return Redirect::back()->with('error', 'Please select a CSV file to scrub.');
    //     }
    // }

    // first working
    // public function checkDuplicates(Request $request)
    // {
    //     $request->validate([
    //         'csvfile' => 'required|mimes:csv,txt|max:10240', // adjust max file size as needed
    //         'column_selection' => 'required|numeric|min:1', // assuming column selection starts from 1
    //     ]);

    //     // Check if a file was uploaded
    //     if ($request->hasFile('csvfile') && $request->file('csvfile')->isValid()) {
    //         // Process CSV and calculate good and bad counts
    //         $file = $request->file('csvfile');
    //         $fileContents = file_get_contents($file->path());
    //         $csv_data = array_map('str_getcsv', explode("\n", $fileContents));
    //         $good_count = 0;
    //         $bad_count = 0;
    //         $unique_numbers = [];

    //         // Get the selected column index from the form
    //         $selectedColumnIndex = $request->input('column_selection') - 1; // Adjust for zero-based indexing

    //         // Batch processing: Adjust the batch size as needed
    //         $batchSize = 500;
    //         $good_rows = []; // Move this line outside of the loop
    //         $bad_rows = [];  // Move this line outside of the loop

    //         foreach (array_chunk($csv_data, $batchSize) as $batch) {
    //             foreach ($batch as $row) {
    //                 // Check if the selected column index exists in the row
    //                 if (isset($row[$selectedColumnIndex])) {
    //                     $number = trim($row[$selectedColumnIndex]);

    //                     if (in_array($number, $unique_numbers)) {
    //                         $bad_count++;
    //                         // Add the row to the bad rows array
    //                         $bad_rows[] = $row;
    //                     } else {
    //                         $unique_numbers[] = $number;
    //                         $good_count++;
    //                         // Add the row to the good rows array
    //                         $good_rows[] = $row;
    //                     }
    //                 }
    //             }

    //             // Clear unique numbers for the next batch
    //             $unique_numbers = [];
    //         }

    //         // Calculate percentages
    //         $total_records = $good_count + $bad_count;
    //         $good_percentage = ($good_count / $total_records) * 100;
    //         $bad_percentage = ($bad_count / $total_records) * 100;

    //         // Get the uploaded file name
    //         $fileName = $file->getClientOriginalName();

    //         // Insert scan result information into the database using Laravel's query builder
    //         $userName = "TRM"; // Replace with the actual user name
    //         $totalRows = $total_records;
    //         $goodCount = $good_count;
    //         $badCount = $bad_count;
    //         $date = Carbon::now();

    //         $lastAction = "Generated"; // No need to create links here, that will be handled in the view

    //         DB::table('scanned_info')->insert([
    //             'FileName' => $fileName,
    //             'User' => $userName,
    //             'TotalRows' => $totalRows,
    //             'Good' => $goodCount,
    //             'Bad' => $badCount,
    //             'TimeSpammed' => $date,
    //             'LastAction' => $lastAction,
    //         ]);

    //         // Generate and save compressed good and bad CSV files
    //         $goodCsvContent = $this->convertToCsv($good_rows);
    //         $badCsvContent = $this->convertToCsv($bad_rows);

    //         $goodCsvPath = 'csvFilesFolder/good_' . $fileName . '.gz';
    //         $badCsvPath = 'csvFilesFolder/bad_' . $fileName . '.gz';

    //         Storage::put($goodCsvPath, gzencode($goodCsvContent));
    //         Storage::put($badCsvPath, gzencode($badCsvContent));

    //         // Provide download links to the compressed generated files
    //         $goodCsvLink = Storage::url($goodCsvPath);
    //         $badCsvLink = Storage::url($badCsvPath);

    //         // Redirect to the index page
    //         return Redirect::route('csv-scanned-numbers')->with('success', 'CSV file has been processed successfully.');
    //     } else {
    //         return Redirect::back()->with('error', 'Please select a CSV file to scrub.');
    //     }
    // }

    //second attempt
    public function checkDuplicates(Request $request)
    {
        $request->validate([
            'csvfile' => 'required|mimes:csv,txt|max:10240', // adjust max file size as needed
            'column_selection' => 'required|numeric|min:1', // assuming column selection starts from 1
        ]);

        // Check if a file was uploaded
        if ($request->hasFile('csvfile') && $request->file('csvfile')->isValid()) {
            // Process CSV and calculate good and bad counts
            $file = $request->file('csvfile');
            $fileContents = file_get_contents($file->path());
            $csv_data = array_map('str_getcsv', explode("\n", $fileContents));
            $good_count = 0;
            $bad_count = 0;
            $unique_numbers = [];

            // Get the selected column index from the form
            $selectedColumnIndex = $request->input('column_selection') - 1; // Adjust for zero-based indexing

            // Batch processing: Adjust the batch size as needed
            $batchSize = 500;
            $good_rows = []; // Move this line outside of the loop
            $bad_rows = [];  // Move this line outside of the loop

            foreach (array_chunk($csv_data, $batchSize) as $batch) {
                foreach ($batch as $row) {
                    // Check if the selected column index exists in the row
                    if (isset($row[$selectedColumnIndex])) {
                        $number = trim($row[$selectedColumnIndex]);

                        if (in_array($number, $unique_numbers)) {
                            $bad_count++;
                            // Add the row to the bad rows array
                            $bad_rows[] = $row;
                        } else {
                            $unique_numbers[] = $number;
                            $good_count++;
                            // Add the row to the good rows array
                            $good_rows[] = $row;
                        }
                    }
                }

                // Clear unique numbers for the next batch
                $unique_numbers = [];
            }

            // Calculate percentages
            $total_records = $good_count + $bad_count;
            $good_percentage = ($good_count / $total_records) * 100;
            $bad_percentage = ($bad_count / $total_records) * 100;

            // Get the uploaded file name
            $fileName = $file->getClientOriginalName();

            // Insert scan result information into the database using Laravel's query builder
            $userName = "TRM"; // Replace with the actual user name
            $totalRows = $total_records;
            $goodCount = $good_count;
            $badCount = $bad_count;
            $date = Carbon::now();

            $lastAction = "Generated"; // No need to create links here, that will be handled in the view

            DB::table('scanned_info')->insert([
                'FileName' => $fileName,
                'User' => $userName,
                'TotalRows' => $totalRows,
                'Good' => $goodCount,
                'Bad' => $badCount,
                'TimeSpammed' => $date,
                'LastAction' => $lastAction,
            ]);

            // Generate and save compressed good and bad CSV files
            $goodCsvContent = $this->convertToCsv($good_rows);
            $badCsvContent = $this->convertToCsv($bad_rows);

            $goodCsvPath = 'csvFilesFolder/good_' . $fileName . '.gz';
            $badCsvPath = 'csvFilesFolder/bad_' . $fileName . '.gz';

            Storage::put($goodCsvPath, gzencode($goodCsvContent));
            Storage::put($badCsvPath, gzencode($badCsvContent));

            // Provide download links to the compressed generated files
            $goodCsvLink = Storage::url($goodCsvPath);
            $badCsvLink = Storage::url($badCsvPath);

            // Redirect to the index page with download links
            return Redirect::route('csv-scanned-numbers')->with([
                'success' => 'CSV file has been processed successfully.',
                'goodCsvLink' => $goodCsvLink,
                'badCsvLink' => $badCsvLink,
            ]);
        } else {
            return Redirect::back()->with('error', 'Please select a CSV file to scrub.');
        }
    }

    private function convertToCsv($data)
    {
        $csv = '';
        foreach ($data as $row) {
            $csv .= implode(',', $row) . "\n";
        }
        return $csv;
    }

    public function results()
    {
        $data = DB::table('scanned_info')->get();
        return view('csv-import.duplicates.results', compact('data'));
    }
}
