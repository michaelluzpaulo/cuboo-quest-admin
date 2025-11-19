<?php
/**
 * Instancia de rerturn Validator::make($arr, []);
 * @param $v object
 * @return \Illuminate\Http\JsonResponse
 */
function __format_error_html($v){
    return response()->json(['message' => "<b class='text-danger'>Erro(s)</b><br>- ".implode('<br>- ',$v->errors()->all()), 'data' => []], 400);
}


function __format_error($v){
    return response()->json(['message' => "<b class='text-danger'>Erro</b><br>- ".$v, 'data' => []], 400);
}