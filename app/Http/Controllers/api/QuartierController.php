<?php

namespace App\Http\Controllers\api;

use App\Models\Quartier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @group Quartiers
 *
 * Requêtes sur les départements
 */
class QuartierController extends Controller
{
    /**
     * Récupère la liste des quartiers.
     * * @return \Illuminate\Http\JsonResponse liste des quartiers.
     */
    public function index()
    {
        $quartiers = Quartier::all();
        return response()->json($quartiers);
    }
}