<?php

namespace App\Http\Controllers\Term;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Term\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function setActiveTerm(Request $request, $termId)
    {
        $term = Term::findOrFail($termId);
        session(['term_id' => $term->id]);
        return ApiResponse::sendResponse(200,"Term set successfully");
    }
}
