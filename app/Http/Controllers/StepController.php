<?php

namespace App\Http\Controllers;

use App\Models\EventStep;

class StepController extends Controller
{
    public function update(EventStep $step)
    {

        $step->update(['completed' => ! $step->completed]);

        return back();
    }
}
