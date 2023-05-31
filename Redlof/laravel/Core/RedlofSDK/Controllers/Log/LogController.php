<?php
namespace Redlof\Core\RedlofSDK\Controllers\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Redlof\Core\RedlofSDK\Controllers\RedlofSDKBaseController;

class LogController extends RedlofSDKBaseController
{
    public function getLogList(Request $request)
    {
        $path = storage_path() . '/logs/';

        $files = glob($path . '*');

        $filesData = [];

        foreach ($files as $key => $file) {

            $path_array = explode('/', $file);

            $name = end($path_array);

            $filesData[$key]['name'] = $name;

            $filesData[$key]['size'] = filesize($file);

            $filesData[$key]['updated_at'] = filemtime($file);
        }

        $data['log_lists'] = $filesData;
        $data['message'] = "Log list retrieved";

        return response()->json($data);
    }

    public function getLogSingle(Request $request, $log_name)
    {
        $file_path = storage_path() . '/logs/' . $log_name;

        $file_content = file_get_contents($file_path);

        $data['log_content'] = $file_content;
        $data['message'] = "Log retrieved";

        return response()->json($data);
    }
}
