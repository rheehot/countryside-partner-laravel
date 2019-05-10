<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MainController extends Controller
{

    private $mentor = null;

    public function __construct(Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    protected function index()
    {
        $mentors = $this->mentor::inRandomOrder()->limit(8)->get();
        return Response::success($mentors);
    }
}
