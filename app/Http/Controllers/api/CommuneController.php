<?php

namespace App\Http\Controllers\api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Communes
 *
 * Requêtes sur les communes
 */

class CommuneController extends Controller
{
    /**
     * Récupère la liste des communes.
     *
     * @return \Illuminate\Http\JsonResponse La liste des communes.
     */
    public function index()
    {
        $communes = Commune::all();
        return response()->json($communes);
    }


    /**
     * Récupère toutes les communes avec leurs arrondissements et quartiers.
     *
     * @return \Illuminate\Http\JsonResponse Les détails des communes avec arrondissements et quartiers.
     */

     public function getAllCommunesWithDetails()
     {
         // Récupérer toutes les départements avec leurs relations
         $communes = Commune::with('arrondissements.quartiers')->get();
         
         return response()->json($communes);
     }
 
     /**
      * Récupère une commune avec ses arrondissements et quartiers.
      *
      *@urlParam communeName string Le nom de la commune. Example: Cotonou
      * @return \Illuminate\Http\JsonResponse Les détails de la communes avec ses arrondissements et quartiers.
      */
 
     public function getCommuneWithDetails($communeName)
     {
         $communeLabel = strtoupper(htmlspecialchars(trim($communeName)));
         $commune = Commune::where('label', $communeLabel)->first();
         if (!$commune) {
            return response()->json(['message' => 'Commune non trouvée'], 404);
        }
         $commune = Commune::with('arrondissements.quartiers')->find($commune->id);
         return response()->json($commune);
     }
 
     /**
      * Récupère une commune avec ses arrondissements.
      *
      *@urlParam communeName string required Le nom de la commune. Example: Cotonou
      * @param  string  $departement  Le nom du département à récupérer.
      * @return \Illuminate\Http\JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
      */
 
     public function getArrondissements($communeName)
     {
        $communeLabel = strtoupper(htmlspecialchars(trim($communeName)));
        $commune = Commune::where('label', $communeLabel)->first();
        if (!$commune) {
           return response()->json(['message' => 'Commune non trouvée'], 404);
       }
         $commune = Commune::with('arrondissements')->find($commune->id);
         return response()->json($commune);
 
     }
}