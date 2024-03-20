<?php

namespace App\Http\Controllers\api;

use App\Models\Quartier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuartierRequest;
/**
 * @group Quartiers
 *
 * Requêtes sur les départements
 */
class QuartierController extends Controller
{
    /**
     * Récupère la liste des quartiers.
     * 
     * @urlParam search  Une partie de l\'écriture du recherché. Example: Pa 
     * @urlParam perPage int Nombre de résultat par page. Example: 20
     * @urlParam page int Le numero de page. Example: 5
     * @return JsonResponse liste des quartiers.
     */
    // public function index(QuartierRequest $request)
    // {
    //     try {
    //         $quartiers = Quartier::query();
    //         if ($request->input('search') == null && $request->input('page')== null && $perPage = $request->input('perPage') == null) {
    //             $result = $quartiers->get();
    //             return response()->json($result);
    //         }
            
    //         $search = $request->input('search');
    //         $page = $request->input('page', 1);
    //         $perPage = $request->input('perPage', 50);
        
    //         // Filtrer les quartiers en fonction du terme de recherche s'il est fourni
    //         if ($search) {
    //             $quartiers->where('label', 'LIKE', '%' . $search . '%');
    //         }
    //         // Récupérer le nombre total de résultats
    //         $total = $quartiers->count();
    //         if ($total==0) {
    //             return response()->json(["error" => "Quartier non trouvé"], 404);
    //         }
    //         // Calculer le nombre total de pages
    //         $lastPage = ceil($total / $perPage);
    //         // Vérifier si la page demandée est valide
    //         if ($page < 1 || $page > $lastPage) {
    //             return response()->json(["error" => "Aucun résultat sur cette page"], 404);
    //         }
    //         // Récupérer les quartiers pour la page demandée
    //         $result = $quartiers->offset(($page - 1) * $perPage)->limit($perPage)->get();
    //         // Vérifier si aucun résultat sur la page
    //         if ($result->isEmpty()) {
    //             return response()->json(["error" => "Aucun résultat sur cette page"], 404);
    //         }
        
    //         return response()->json([
    //             "current_page" => $page,
    //             "last_page" => $lastPage,
    //             "quartiers" => $result
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json($e->getMessage(), 500);
    //     }  
    // }
}