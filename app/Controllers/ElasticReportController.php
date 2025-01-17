<?php

namespace App\Controllers;

class ElasticReportController extends BaseController{
    public function index()
    {
        // Initialize cURL
        $ch = curl_init();
        $url = "http://localhost:4000/elastic/getall"; // Updated URL

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "cURL Error: " . $error_msg;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data['reports'] = json_decode($response, true)['hits'];
        // $data['reports'] = json_decode($response, true)['nextHits'];


        // Debug: Log the response data
        log_message('debug', 'Response Data: ' . print_r($data['reports'], true));

        // Paginate the data
        $pager = \Config\Services::pager();
        $perPage = 10; // Number of items per page
        $currentPage = $this->request->getVar('page') ?? 1;
        $totalItems = count($data['reports']);
        $data['reports'] = array_slice($data['reports'], ($currentPage - 1) * $perPage, $perPage);
        $data['pager'] = $pager->makeLinks($currentPage, $perPage, $totalItems);

        return view('reports/elasticreport', $data); // Pass data to the view
    }

//     public function index()
// {
//     // Initialize cURL
//     $ch = curl_init();
//     $url = "http://localhost:4000/elastic/getall"; // Updated URL

//     // Set cURL options
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL request
//     $response = curl_exec($ch);

//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         $error_msg = curl_error($ch);
//         curl_close($ch);
//         return "cURL Error: " . $error_msg;
//     }

//     // Close cURL session
//     curl_close($ch);

//     // Decode the JSON response
//     $data = json_decode($response, true);

//     // Debug: Log the response data
//     log_message('debug', 'Response Data: ' . print_r($data, true));

//     // Paginate the data
//     $pager = \Config\Services::pager();
//     $perPage = 10; // Number of items per page
//     $currentPage = $this->request->getVar('page') ?? 1;
//     $totalItems = count($data['hits']) + count($data['nextHits']);
//     $allReports = array_merge($data['hits'], $data['nextHits']);
//     $data['reports'] = array_slice($allReports, ($currentPage - 1) * $perPage, $perPage);
//     $data['pager'] = $pager->makeLinks($currentPage, $perPage, $totalItems);

//     return view('reports/elasticreport', $data); // Pass data to the view
// }

// public function index()
// {
//     // Initialize cURL
//     $ch = curl_init();
//     $url = "http://localhost:4000/elastic/getall"; // Updated URL

//     // Set cURL options
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL request
//     $response = curl_exec($ch);

//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         $error_msg = curl_error($ch);
//         curl_close($ch);
//         return "cURL Error: " . $error_msg;
//     }

//     // Close cURL session
//     curl_close($ch);

//     // Decode the JSON response
//     $data['reports'] = json_decode($response, true)['allHits'];
//     echo "Data: " . print_r($data, true);

//     // Paginate the data
//     $perPage = 10; // Number of items per page
//     $currentPage = $this->request->getVar('page') ?? 1;
//     $totalItems = count($data['reports']);

//     // Chunk the data
//     $chunkSize = 100;
//     $chunks = array_chunk($data['reports'], $chunkSize);

//     // Lazy load the data
//     $lazyLoadData = [];
//     foreach ($chunks as $chunk) {
//         $lazyLoadData[] = $chunk;
//     }

//     // Render the view
//     $data['reports'] = $lazyLoadData;
//     $data['pager'] = \Config\Services::pager()->makeLinks($currentPage, $perPage, $totalItems);

//     return view('reports/elasticreport', $data); // Pass data to the view
// }

    // public function downloadCsv()
    // {
    //     $ch = curl_init();
    //     $url = "http://localhost:4000/elastic/getall"; // Updated URL with pagination
    //     // Set cURL options
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 300);

    //     // Execute cURL request
    //     $response = curl_exec($ch);

    //     // Check for cURL errors
    //     if (curl_errno($ch)) {
    //         $error_msg = curl_error($ch);
    //         curl_close($ch);
    //         return "cURL Error: " . $error_msg;
    //     }

    //     // Close cURL session
    //     curl_close($ch);

    //     // Decode JSON response
    //     $responseData = json_decode($response, true);
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return "JSON Error: " . json_last_error_msg();
    //     }

    //     $data = $responseData['response'] ?? [];

    //     // Define headers
    //     $headers = array('date_time', 'type', 'dispose_type', 'dispose_name', 'duration', 'agent_name', 'campaign_name', 'process_name', 'leadset', 'reference_uuid', 'customer_uuid', 'hold', 'mute', 'ringing', 'transfer', 'conference', 'callkey', 'dispose_time');

    //     // Create CSV file
    //     $filename = 'CDR_Report_elastic' . date('Ymd') . '.csv';
    //     header("Content-Description: File Transfer");
    //     header("Content-Disposition: attachment; filename=$filename");
    //     header("Content-Type: application/csv; ");

    //     $file = fopen('php://output', 'w');
    //     if (!$file) {
    //         return "Error opening file for writing";
    //     }

    //     // Write headers to CSV file
    //     fputcsv($file, $headers);

    //     // Write data to CSV file
    //     foreach ($data as $row) {
    //         // Ensure row data matches headers
    //         $rowData = array();
    //         foreach ($headers as $header) {
    //             $rowData[] = $row[$header] ?? '';
    //         }
    //         fputcsv($file, $rowData);
    //     }

    //     fclose($file);
    //     exit;
    // }
    public function downloadCsv()
    {
        $ch = curl_init();
        $url = "http://localhost:4000/elastic/getall"; // Updated URL with pagination
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "cURL Error: " . $error_msg;
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return "JSON Error: " . json_last_error_msg();
        }

        $data = $responseData['hits'] ?? [];

        // Define headers
        $headers = array('date_time', 'type', 'dispose_type', 'dispose_name', 'duration', 'agent_name', 'campaign_name', 'process_name', 'leadset', 'reference_uuid', 'customer_uuid', 'hold', 'mute', 'ringing', 'transfer', 'conference', 'callkey', 'dispose_time');

        // Create CSV file
        $filename = 'CDR_Report_Elastic' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $file = fopen('php://output', 'w');
        if (!$file) {
            return "Error opening file for writing";
        }

        // Write headers to CSV file
        fputcsv($file, $headers);

        // Write data to CSV file
        foreach ($data as $row) {
            // Ensure row data matches headers
            $rowData = array();
            foreach ($headers as $header) {
                $rowData[] = $row[$header] ?? '';
            }
            fputcsv($file, $rowData);
        }

        fclose($file);
        exit;
    }   
    
}