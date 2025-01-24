<?php

namespace App\Controllers;

class ReportController extends BaseController
{

    public function index()
    {
        $ch = curl_init();
        $flag = $this->request->getVar('flag');
        $currentPage = $this->request->getVar('page') ?? 1;

        if ($flag == 1) {
            $url = "http://localhost:4000/mysql/getall"; // Updated URL  
        } elseif ($flag == 2) {
            $url = "http://localhost:4000/mongo/getall"; // Updated URL
        } elseif ($flag == 3) {
            $url = "http://localhost:4000/elastic/getall"; // Updated URL
        } else {
            $url = "http://localhost:4000/default/getall"; // Default URL or handle error
        }

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
        $data['reports'] = json_decode($response, true);

        // Debug: Log the response data
        log_message('debug', 'Response Data: ' . print_r($data['reports'], true));

        // Paginate the data
        $pager = \Config\Services::pager();
        $perPage = 10; // Number of items per page
        $totalItems = count($data['reports']);
        $data['reports'] = array_slice($data['reports'], ($currentPage - 1) * $perPage, $perPage);
        $data['pager'] = $pager->makeLinks($currentPage, $perPage, $totalItems);
        $data['repnum'] = $flag; // Pass the flag to the view as repnum

        return view('reports/CDR_report', $data);
    }

    public function downloadCDRCsv()
    {
        $ch = curl_init();
        $repnum = $this->request->getVar('flag');
        $url = '';
        $filename = '';
    
        switch ($repnum) {
            case 1:
                $url = "http://localhost:4000/mysql/getall";
                $filename = 'CDR_Report_mysql' . date('Ymd') . '.csv';
                break;
            case 2:
                $url = "http://localhost:4000/mongo/getall";
                $filename = 'CDR_Report_mongo' . date('Ymd') . '.csv';
                break;
            case 3:
                $url = "http://localhost:4000/elastic/getall";
                $filename = 'CDR_Report_elastic' . date('Ymd') . '.csv';
                break;
            default:
                return "Invalid report number.";
        }
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            log_message('error', 'cURL Error: ' . $error_msg);
            return "cURL Error: " . $error_msg;
        }
    
        curl_close($ch);
        log_message('debug', 'Response Data: ' . $response);
    
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return "JSON Error: " . json_last_error_msg();
        }
    
        $data = $responseData ?? [];
        $headers = [
            'date_time', 'type', 'dispose_type', 'dispose_name', 'duration', 'agent_name', 
            'campaign_name', 'process_name', 'leadset', 'reference_uuid', 'customer_uuid', 
            'hold', 'mute', 'ringing', 'transfer', 'conference', 'callkey', 'dispose_time'
        ];
    
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/csv; ");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Transfer-Encoding: binary");
    
        if (ob_get_level()) {
            ob_end_clean();
        }
    
        $file = fopen('php://output', 'w');
        if (!$file) {
            return "Error opening file for writing";
        }
    
        fputcsv($file, $headers);
        foreach ($data as $row) {
            $rowData = array_map(function($header) use ($row) {
                return $row[$header] ?? '';
            }, $headers);
            fputcsv($file, $rowData);
        }
    
        fclose($file);
        exit;
    }

    public function filter()
{
    $flag = $this->request->getVar('flag');
    $database = $this->request->getVar('database');
    $currentPage = $this->request->getVar('page') ?? 1;

    $session = \Config\Services::session();

    $filteredData = [
        'agent_name' => $this->request->getVar('agent_name'),
        'campaign_name' => $this->request->getVar('campaign_name'),
        'process_name' => $this->request->getVar('process_name'),
        'filter_date' => $this->request->getVar('filter_date')
    ];

    $session->set('filteredData', $filteredData);
    switch ($database) {
        case 'Mysql':
            $url = "http://localhost:4000/mysql/filter";
            break;
        case 'MongoDB':
            $url = "http://localhost:4000/mongo/filter";
            break;
        case 'ElasticSearch':
            $url = "http://localhost:4000/elastic/filter";
            break;
        default:
            echo "Invalid database selection";
            return; 
    }

    // Set cURL options
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($filteredData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

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
    $data['reports'] = json_decode($response, true);

    // Debug: Log the response data
    log_message('debug', 'Response Data: ' . print_r($data['reports'], true));

    // Paginate the data
    $pager = \Config\Services::pager();
    $perPage = 10; 
    $totalItems = count($data['reports']);
    $data['reports'] = array_slice($data['reports'], ($currentPage - 1) * $perPage, $perPage);
    $data['pager'] = $pager->makeLinks($currentPage, $perPage, $totalItems);
    $data['repnum'] = $flag;

    return view('reports/CDR_report', $data);
}
    
}
