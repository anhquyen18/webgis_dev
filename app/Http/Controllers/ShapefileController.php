<?php

namespace App\Http\Controllers;

require_once('../vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');
// require_once('php-shapefile/src/Shapefile/ShapefileAutoloader.php');


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Shapefile\ShapefileWriter;
use Shapefile\Geometry\Point;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ShapefileController extends Controller
{
    public function testController()
    {
        // return Auth::check() . "dasds";
        echo 'anhquyen';
    }

    public function createShapefile(Request $request)
    {
        try {
            $data = $request->data;
            $epsg5899 = 'PROJCS["VN-2000 / TM-3 107-45",
            GEOGCS["VN-2000",
                DATUM["Vietnam_2000",
                    SPHEROID["WGS 84",6378137,298.257223563],
                    TOWGS84[-191.90441429,-39.30318279,-111.45032835,-0.00928836,0.01975479,-0.00427372,0.252906278]],
                PRIMEM["Greenwich",0,
                    AUTHORITY["EPSG","8901"]],
                UNIT["degree",0.0174532925199433,
                    AUTHORITY["EPSG","9122"]],
                AUTHORITY["EPSG","4756"]],
            PROJECTION["Transverse_Mercator"],
            PARAMETER["latitude_of_origin",0],
            PARAMETER["central_meridian",107.75],
            PARAMETER["scale_factor",0.9999],
            PARAMETER["false_easting",500000],
            PARAMETER["false_northing",0],
            UNIT["metre",1,
                AUTHORITY["EPSG","9001"]],
            AXIS["Easting",EAST],
            AXIS["Northing",NORTH],
            AUTHORITY["EPSG","5899"]]';

            $Shapefile = new ShapefileWriter('../resources/shapefile/test.shp');
            $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POINT);
            $Shapefile->setPRJ($epsg5899);
            $Shapefile->addNumericField('ID', 10);
            $Shapefile->addCharField('DESC', 25);


            // $Point = new Point(108.47, 15.55);
            // $Point->setData('ID', 1);
            // $Point->setData('DESC', "Point number 1");
            // $Shapefile->writeRecord($Point);
            $i = 0;

            foreach ($data as $value) {
                $i++;
                $Point = new Point($value[0], $value[1]);
                $Point->setData('ID', $i);
                $Point->setData('DESC', "Point number" . $i);
                $Shapefile->writeRecord($Point);
            }


            $Shapefile = null;
        } catch (ShapefileException $e) {
            echo "Error Type: " . $e->getErrorType()
                . "\nMessage: " . $e->getMessage()
                . "\nDetails: " . $e->getDetails();
        }
    }

    public function readShapefile()
    {
        try {
            // $Shapefile = new ShapefileWriter('../resources/shapefile/test.shp');
            // $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POINT);

            // $Shapefile->setPRJ("WGS 84");
            // $Shapefile->addNumericField('ID', 10);
            // $Shapefile->addCharField('DESC', 25);
            // $Point = new Point(108.47, 15.55);
            // $Point->setData('ID', 1);
            // $Point->setData('DESC', "Point number 1");
            // $Shapefile->writeRecord($Point);
            // $Shapefile = null;
        } catch (ShapefileException $e) {
            echo "Error Type: " . $e->getErrorType()
                . "\nMessage: " . $e->getMessage()
                . "\nDetails: " . $e->getDetails();
        }


        echo response()->json();
    }

    public function downloadShapefile()
    {
        // $filename = basename('../storage/app/public/test.txt');
        $headers = array(
            'Content-Type: application/txt',
        );
        // return $filename;
        // return Storage::download($filename, 'filename.txt', $headers);
        return Storage::download('../storage/app/public/test.txt', 'filename.txt', $headers);
    }


    function vn_to_str($str)
    {
        $unicode = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd' => 'đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i' => 'í|ì|ỉ|ĩ|ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D' => 'Đ',

            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach ($unicode as $nonUnicode => $uni) {

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        // $str = str_replace(' ', '_', $str);
        $str = strtolower($str);
        return $str;
    }

    public function searchFeature(Request $request)
    {
        $data = $request->json()->all();
        $searchValue = $data['data'];
        // $idOfFeature = filter_var($data['data'], FILTER_SANITIZE_NUMBER_INT);
        // $nameOfFeature = preg_split('/[0-9]/', $data['data'])[0];

        $featureArray = array();
        $layers = [
            'cong_ngam' => 'Cống ngầm', 'kenh' => 'Kênh', 'cong_ngan_trieu' => 'Cống ngăn triều',
            'ho_ga' => 'Hố ga', 'cua_xa' => 'Cửa xả', 'ho_dieu_hoa' => 'Hồ điều hoà', 'tram_do_mua' => 'Trạm đo mưa'
        ];
        foreach ($layers as $key => $value) {
            // if ((int)$data['data'][0] !== 0 && is_numeric((int)$data['data'][0])) {
            // array_push($featureArray, [preg_split('/[0-9]/', $data['data'])]);
            // array_push($featureArray, (int)$data['data'][0]);
            // } else {
            // if (str_contains($this->vn_to_str($value), $this->vn_to_str($nameOfFeature))) {
            // array_push($featureArray, [preg_split('/[0-9]/', $data['data'])]);

            $features =  DB::table($key)->select('gid')
                ->whereRaw('CONCAT(\'' . $this->vn_to_str($value)  . '\',\' \',gid) LIKE \'%' . $this->vn_to_str($searchValue) . '%\'')
                ->paginate(50);
            array_push($featureArray, ['features' => $features, 'featureName' => $value, 'layer' => $key]);

            // Trong trường hợp Hồ điều hoà sử dụng tên để tìm kiếm thay vì id ---------------------------------------------
            // if ($key === 'hodieuhoa') {
            // $features =  DB::table($key)->select('*')
            //     ->whereRaw('CONCAT(\'' . $this->vn_to_str($value)  . '\',\' \',unaccent("Ten")) LIKE \'%' . $nameOfFeature . '%\'')->get();
            // array_push($featureArray, [$value => $features]);

            // }

        }
        // return $this->vn_to_str($data['data']);
        return $featureArray;
    }

    public function getGeoserverFeatureById(Request $request)
    {
        $data = $request->json()->all();
        $id = $data['id'];
        $layer = $data['layer'];
        $host = 'http://localhost:8080';
        $workspace = 'webgis_dev';

        $response = Http::get($host . '/geoserver/wfs?service=WFS&version=2.0.0&request=GetFeature&typenames=' . $workspace . ':' . $layer . '&filter=%3Cfes:Filter%20xmlns:fes=%22http://www.opengis.net/fes/2.0%22%3E%3Cfes:ResourceId%20rid=%22' . $layer . '.' . $id . '%22/%3E%3C/fes:Filter%3E&outputFormat=application%2Fjson');

        $feature = $response->json();

        return $feature;
        // return $host . '/geoserver/wfs?service=WFS
        // &version=2.0.0&request=GetFeature&typenames=' . $workspace . ':' . $layer . '
        // &filter=%3Cfes:Filter%20xmlns:fes=%22http://www.opengis.net/fes/2.0%22%3E%3Cfes:
        // ResourceId%20rid=%22' . $layer . '.' . $id . '%22/%3E%3C/fes:Filter%3E
        // &outputFormat=application%2Fjson
        // ';
    }
}
