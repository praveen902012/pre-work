<?php
namespace Redlof\Core\RedlofSDK\Controllers\DatabaseQuery;

use Illuminate\Http\Request;
use Redlof\Core\RedlofSDK\Controllers\RedlofSDKBaseController;

class DatabaseQueryController extends RedlofSDKBaseController
{
    public function getDatabaseQueryResult(Request $request)
    {
        // Parse the request
        // Construct query string

        $model = $request->model;

        // Check if Model is allowed
        $allowed_models = explode(",", env("REDLOF_DB_MODELS"));

        if (!in_array($model, $allowed_models)) {

            $data['message'] = "Please make sure model retrieval is allowed or provide correct model value";

            return response()->json($data, 406);

        }

        $query = "\Models\\$model::";

        // Check for relations
        if (!empty($request->relations)) {

            // Parse relations and create query string
            $relations_array = explode(',', $request->relations);

            $relations = "";

            foreach ($relations_array as $value) {

                $relations = $relations . "'" . trim($value) . "',";
            }

            $relations = trim($relations, ",");

            $query = $query . "with($relations)->";
        }

        // Check for where clause
        if (!empty($request->where_key)) {

            $where_key = $request->where_key;
            $where_operator = $request->where_operator;
            $where_value = $request->where_value;

            $query = $query . "where('$where_key','$where_operator','$where_value')->";
        }

        // Check for and where clause
        if (!empty($request->where_key_2)) {

            $where_key_2 = $request->where_key_2;
            $where_operator_2 = $request->where_operator_2;
            $where_value_2 = $request->where_value_2;

            $query = $query . "where('$where_key_2','$where_operator_2','$where_value_2')->";
        }

        $query = $query . "get();";

        // Query from database
        try {

            $data = eval('return ' . $query . ';');

        } catch (\Exception $e) {

            $data['message'] = $e->getMessage();

            return response()->json($data, 406);
        }

        $data['message'] = "Data retrieved successfully";

        return response()->json($data);

    }

}
