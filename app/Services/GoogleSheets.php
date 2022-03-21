<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class GoogleSheets
{
    private $client;
    private $service;
    private $spreadsheetId;

    public function __construct($spreadsheetId)
    {
        $this->spreadsheetId = $spreadsheetId;
        $this->client = new \Google_Client();
        $this->client->setAuthConfig(config('redesul.google_credentials_file'));
        $this->client->addScope(['https://www.googleapis.com/auth/spreadsheets']);

        $this->service = new \Google\Service\Sheets($this->client);
    }

    // get headers from a sheet
    public function getHeaders($sheetName)
    {
        // clear headers to set new ones
        $clearValuesRequest = new \Google\Service\Sheets\ClearValuesRequest();
        $values =  $this->service->spreadsheets_values->clear($this->spreadsheetId, $sheetName . '!1:1', $clearValuesRequest);

        // get Answer attributes
        // $submission_columns = Schema::getColumnListing('submissions'); // users table
        $headers =
            [
                "ID",
                "NOME",
                "CIDADE",
                "ASSINATURA",
                "INÍCIO",
                "DURAÇÃO",
                "TÉRMINO",
            ];

        \App\Models\Quiz::first()->questions->each(function ($question) use (&$headers) {
            $headers[] = $question->full_code;
        });

        $headers = collect($headers)->map(function ($header) {
            return strtoupper($header);
        })->unique()->values()->toArray();

        // set header in first row
        $this->setValues($sheetName, [$headers]);

        return $headers;
    }

    public function getSheet($sheetName)
    {
        $sheet = $this->service->spreadsheets_values->get($this->spreadsheetId, $sheetName);
        $values = $sheet->getValues();

        $headers = array_shift($values);
        $data = [];

        foreach ($values as $row) {
            $data[] = array_combine($headers, array_pad($row, count($headers), null));
        }

        return $data;
    }

    // set sheet values
    public function setValues($sheetName, $values)
    {
        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values,
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $result = $this->service->spreadsheets_values->update($this->spreadsheetId, $sheetName, $body, $params);

        return $result;
    }

    // append values to a sheet
    public function appendValues($sheetName, $values)
    {
        // get headers
        $headers = $this->getHeaders($sheetName);

        // map values to ordered array
        $values = array_change_key_case($values, CASE_UPPER);

        $values = array_map(function ($value) use ($headers) {
            $data = [];
            foreach ($headers as $header) {
                $data[] = $value[$header] ?? "";
            }
            return $data;
        }, $values);


        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values,
            'majorDimension' => 'ROWS',
            'range' => $sheetName,
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        // append values
        $appended_values = $this->service->spreadsheets_values->append($this->spreadsheetId, $sheetName, $body, $params);

        return $appended_values;
    }
}
