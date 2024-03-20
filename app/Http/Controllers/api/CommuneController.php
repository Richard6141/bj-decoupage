<?php

namespace App\Http\Controllers\api;
use Exception; 
use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommuneRequest;

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
     * @urlParam search  Une partie de l\'écriture de la commune recherchée. Example: Pa
     * @urlParam perPage int Nombre de résultat par page. Example: 20 
     * @urlParam page int Le numero de page. Example: 3
     * @return JsonResponse La liste des communes.
     */
    // public function index(CommuneRequest $request)
    // {
    //     try {
    //         $communes = Commune::query();
    //         if ($request->input('search') == null && $request->input('page')== null && $perPage = $request->input('perPage') == null) {
    //             $result = $communes->get();
    //             return response()->json($result);
    //         }
            
    //         $search = $request->input('search');
    //         $page = $request->input('page', 1);
    //         $perPage = $request->input('perPage', 10);
        
    //         // Filtrer les communes en fonction du terme de recherche s'il est fourni
    //         if ($search) {
    //             $communes->where('label', 'LIKE', '%' . $search . '%');
    //         }
    //         // Récupérer le nombre total de résultats
    //         $total = $communes->count();
    //         if ($total==0) {
    //             return response()->json(["error" => "Commune non trouvé"], 404);
    //         }
    //         // Calculer le nombre total de pages
    //         $lastPage = ceil($total / $perPage);
    //         // Vérifier si la page demandée est valide
    //         if ($page < 1 || $page > $lastPage) {
    //             return response()->json(["error" => "Aucun résultat sur cette page"], 404);
    //         }
    //         // Récupérer les communes pour la page demandée
    //         $result = $communes->offset(($page - 1) * $perPage)->limit($perPage)->get();
    //         // Vérifier si aucun résultat sur la page
    //         if ($result->isEmpty()) {
    //             return response()->json(["error" => "Aucun résultat sur cette page"], 404);
    //         }
        
    //         return response()->json([
    //             "current_page" => $page,
    //             "last_page" => $lastPage,
    //             "communes" => $result
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json($e->getMessage(), 500);
    //     }  
    // }


    /**
     * Récupère toutes les communes avec leurs arrondissements et quartiers.
     *
     * @return JsonResponse Les détails des communes avec arrondissements et quartiers.
     */

     public function getAllCommunesWithDetails()
     {
         // Récupérer toutes les départements avec leurs relations
         try{
            $communes = Commune::with('arrondissements.quartiers')->get();
            
            return response()->json($communes);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        } 
     }
 
     /**
      * Récupère une commune avec ses arrondissements et quartiers.
      *
      *@urlParam communeName string required Le nom de la commune. Example: Cotonou
      * @return JsonResponse Les détails de la communes avec ses arrondissements et quartiers.
      */
 
     public function getCommuneWithDetails($communeName)
     {
        try{
         $communeLabel = strtoupper(htmlspecialchars(trim($communeName)));
         $commune = Commune::where('label', $communeLabel)->first();
         if (!$commune) {
            return response()->json(['message' => 'Commune non trouvée'], 404);
        }
         $commune = Commune::with('arrondissements.quartiers')->find($commune->id);
         return response()->json($commune);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
     }
 
     /**
      * Récupère une commune avec ses arrondissements.
      *
      *@urlParam communeName string required Le nom de la commune. Example: Cotonou
      * @return JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
      */
 
     public function getArrondissements($communeName)
     { 
        try{
            $communeLabel = strtoupper(htmlspecialchars(trim($communeName)));
            $commune = Commune::where('label', $communeLabel)->first();
            if (!$commune) {
            return response()->json(['message' => 'Commune non trouvée'], 404);
            }
            $commune = Commune::with('arrondissements')->find($commune->id);
            return response()->json($commune);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        } 
 
     }
    
}