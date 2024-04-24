<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwmmController extends Controller
{

    public function test()
    {
        // $url = "http://127.0.0.1:8000/api/test2";
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // $response = curl_exec($ch);
        // if ($response !== false) {
        //     // Process the response
        //     return $response;
        // } else {
        //     // Handle error
        //     echo "Error: " . curl_error($ch);
        // }

        // curl_close($ch);
        // return "nothing happens";
        $inputFile = "F:/\"Water Resource\"/SWMM/first-sample-project.inp";

        // Lệnh thực thi SWMM
        $swmmCommand = "C:/\"Program Files\"/\"EPA SWMM 5.2.4 (64-bit)\"/runswmm.exe < $inputFile"; // Điều chỉnh đường dẫn tùy thuộc vào hệ điều hành và cài đặt của bạn

        // Thực thi lệnh và lấy kết quả
        $output = [];
        exec($swmmCommand, $output, $returnCode);

        // Kiểm tra mã trả về để xem liệu quá trình thực thi có thành công hay không
        if ($returnCode === 0) {
            echo "SWMM executed successfully!";
        } else {
            echo "SWMM execution failed. Return code: $returnCode";
        }

        // return $output;
        // print_r($output);
    }


    public function test1()
    {
        $pythonScript = "f:/\"Programming project\"\Personal/web-gis-dev\back-end/resources/swmm/run-app.py";
        $testInputData = array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        );
        $json_data = json_encode($testInputData);


        $output = [];
        exec("python $pythonScript '$json_data'", $output);

        if (!empty($output)) {
            $jsonData = $output[0];
            $data = json_decode($jsonData, true);

            // Hiển thị dữ liệu nhận được từ Python
            return $output;
        } else {
            return "Không có dữ liệu trả về từ Python.";
        }
    }

    public function readInp()
    {
        $pythonScript = "f:/\"Programming project\"\Personal/web-gis-dev\back-end/resources/swmm/read-inp.py";

        $output = '';
        exec("python $pythonScript", $output);

        if (!empty($output)) {
            $jsonData = $output[0];


            $data = json_decode($jsonData, true);
            $newData = json_encode($data);
            return $newData;
        } else {
            return "Không có dữ liệu trả về từ Python.";
        }
    }

    public function writeInp()
    {
        $pythonScript = "f:/\"Programming project\"\Personal/web-gis-dev\back-end/resources/swmm/write-inp.py";
        // Dữ liệu bạn muốn truyền cho script Python
        $input_data = '{"Hello": "1", "world": "2"}';

        // Chuyển đổi dữ liệu thành chuỗi JSON
        $json_input = json_encode($input_data);

        // $output = [];
        $output = exec("python $pythonScript  $json_input anhquyendeptraivcl");

        if (!empty($output)) {
            $jsonData = $output;


            $data = json_decode($jsonData, true);
            $newData = json_encode($data);
            // return "Array: {$jsonData}";
            // return implode(", ", $jsonData);
            // return implode(", ", $jsonData);

            // return json_decode($output);
            return $output;
        } else {
            return "Không có dữ liệu trả về từ Python.";
        }
        // Hiển thị kết quả
        // return $output[0];
    }

    public function readRpt()
    {
        $pythonScript = "f:/\"Programming project\"\Personal/web-gis-dev\back-end/resources/swmm/read-rpt.py";

        // $output = [];
        $output = exec("python $pythonScript");

        if (!empty($output)) {
            $jsonData = $output;


            $data = json_decode($jsonData, true);
            $newData = json_encode($data);

            return $newData;
        } else {
            return "Không có dữ liệu trả về từ Python.";
        }
        // Hiển thị kết quả
        // return $output[0];
    }

    public function readOut()
    {
        $pythonScript = "f:/\"Programming project\"\Personal/web-gis-dev\back-end/resources/swmm/read-out.py";

        // $output = [];
        $output = exec("python $pythonScript");

        if (!empty($output)) {
            $jsonData = $output;


            $data = json_decode($jsonData, true);
            $newData = json_encode($data);

            return $data;
        } else {
            return "Không có dữ liệu trả về từ Python.";
        }
        // Hiển thị kết quả
        // return $output[0];
    }
}
