<?php

namespace App\Http\Controllers;

require_once('../vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');
// require_once('php-shapefile/src/Shapefile/ShapefileAutoloader.php');


use Illuminate\Http\Request;
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Shapefile\ShapefileWriter;
use Shapefile\Geometry\Point;
use Illuminate\Support\Facades\Storage;

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
}
