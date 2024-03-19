<?php

namespace App\Http\Controllers\api;

use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Départements
 *
 * Requêtes sur les départements
 */

class DepartementController extends Controller
{
    /**
     * Récupère la liste des départements.
     *
     * @return \Illuminate\Http\JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */
    public function index()
    {
        $departements = Departement::all();
        return response()->json($departements);
    }

    /**
     * Récupère tous les départements avec leurs communes, arrondissements et quartiers.
     *
     * @return \Illuminate\Http\JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getAllDepartementsWithDetails()
    {
        // Récupérer tous les départements avec leurs relations
        $departements = Departement::with('communes.arrondissements.quartiers')->get();

        return response()->json($departements);
    }

    /**
     * Récupère un département avec ses communes, arrondissements et quartiers.
     *
     * @urlParam departementName string required Le nom de la commune. Example: Alibori
     * @return \Illuminate\Http\JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getDepartementWithDetails($departementName)
    {
        //Opérer des opérations sur l'entrée de l'utilsateur
        $departementLabel = strtoupper(htmlspecialchars(trim($departementName)));
        $departement = Departement::where('label', $departementLabel)->get();
        $departement = Departement::with('communes.arrondissements.quartiers')->find($departement);
        if (!$departement) {
            return response()->json(['message' => 'Département non trouvé'], 404);
        }

        return response()->json($departement);
    }

    /**
     * Récupère un département avec ses communes.
     *
     * @urlParam departementName string required Le nom de la commune. Example: Alibori
     * @return \Illuminate\Http\JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getCommunes($departementName)
    {
        $departementLabel = strtoupper(htmlspecialchars(trim($departementName)));
        $departement = Departement::where('label', $departementLabel)->get();
        $departement = Departement::with('communes')->find($departement);
        if (!$departement) {
            return response()->json(['message' => 'Département non trouvé'], 404);
        }

        return response()->json($departement);

    }
}