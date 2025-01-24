<?php

namespace App\Controllers;

class SummaryController extends BaseController
{

    public function index()
    {
        $ch = curl_init();
        $flag = $this->request->getVar('flag');
        $currentPage = $this->request->getVar('page') ?? 1;

        if ($flag == 1) {
            $url = "http://localhost:4000/mysql/hourlyReport"; // Updated URL  
        } elseif ($flag == 2) {
            $url = "http://localhost:4000/mongo/getsummary/hourlyreport"; // Updated URL
        } elseif ($flag == 3) {
            $url = "http://localhost:4000/elastic/getsummary/hourlyreport"; // Updated URL
        } else {
            echo 'Data Not Found'; // Default URL or handle error
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

        return view('reports/summary_reports', $data, ['repnum' => $flag]);
    }

    public function downloadSummaryCsv() 
    {
        $ch = curl_init();
        $repnum = $this->request->getVar('flag');
        $url = '';
        $filename = '';
    
        switch ($repnum) {
            case 1:
                $url = "http://localhost:4000/mysql/hourlyReport";
                $filename = 'Summary_Report_mysql' . date('Ymd') . '.csv';
                break;
            case 2:
                $url = "http://localhost:4000/mongo/getsummary/hourlyreport";
                $filename = 'Summary_Report_mongo' . date('Ymd') . '.csv';
                break;
            case 3:
                $url = "http://localhost:4000/elastic/getsummary/hourlyreport";
                $filename = 'Summary_Report_elastic' . date('Ymd') . '.csv';
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
            'hour' ,'totalCalls', 'totalHoldTime', 'totalTalkTime', 'totalDisposeTime', 'totalDuration', 'totalMuteTime', 'totalConferenceTime', 'totalProcesses', 'totalCampaigns'
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
}