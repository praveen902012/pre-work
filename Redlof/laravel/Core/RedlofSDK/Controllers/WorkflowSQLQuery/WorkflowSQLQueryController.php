<?php
namespace Redlof\Core\RedlofSDK\Controllers\WorkflowSQLQuery;

use Illuminate\Http\Request;
use Redlof\Core\RedlofSDK\Controllers\RedlofSDKBaseController;

class WorkflowSQLQueryController extends RedlofSDKBaseController
{
    public function createWorkflow(Request $request)
    {
        // set query logging in some json file in storage
        // Add workflow name in the settings file
        $request_data = [
            'workflow_enabled' => true,
            'file_name' => $request->file_name,
        ];

        $settings_content = json_encode($request_data);

        \Storage::disk('local')->put('redlof/redlof-db-querylogger-settings', $settings_content);

        $data['message'] = "Workflow created and started successfully";

        return response()->json($data);
    }

    public function fetchWorkflow(Request $request)
    {
        // Check if file is generated
        if (\Storage::disk('local')->exists('redlof/' . $request->file_name)) {

            $data['message'] = "No query is initialized yet";

            return response()->json($data, 406);
        }

        $data['file_content'] = \Storage::disk('local')->get('redlof/' . $request->file_name);

        $data['message'] = "Data retrieved successfully";

        return response()->json($data);
    }

    public function stopWorkflow(Request $request)
    {
        $data['file_content'] = \Storage::disk('local')->get('redlof/' . $request->file_name);

        \Storage::disk('local')->delete('redlof/' . $request->file_name);

        // Update workflow settings
        $settings_data = [
            'workflow_enabled' => false,
            'file_name' => null,
        ];

        $settings_json = json_encode($settings_data);

        \Storage::disk('local')->put('redlof/redlof-db-querylogger-settings', $settings_json);

        $data['message'] = "Stopped successfully";

        return response()->json($data);

    }

}
