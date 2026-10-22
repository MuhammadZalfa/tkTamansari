<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Program;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Program', [
            'programs' => Program::query()->active()->orderBy('sort_order')->get(),
            'agendas' => Agenda::query()->active()->orderBy('sort_order')->get(),
        ]);
    }
}
