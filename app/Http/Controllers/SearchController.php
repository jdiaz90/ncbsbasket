<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($search)
    {
        
        $id = $search;

        $players = new Collection;

        PlayerSearchController::getPlayers($id, $players);
        PlayerSearchController::getFormerPlayers($id, $players);

        $coaches = new Collection;

        CoachSearchController::getCoachs($id, $coaches);
        CoachSearchController::getFormerCoachs($id, $coaches);


        return view("search", compact("id", "players", "coaches"));

    }

    public function store(Request $request)
    {
        
        $id = $request->get('key');

        $players = new Collection;

        PlayerSearchController::getPlayers($id, $players);
        PlayerSearchController::getFormerPlayers($id, $players);

        $coaches = new Collection;

        CoachSearchController::getCoachs($id, $coaches);
        CoachSearchController::getFormerCoachs($id, $coaches);


        return view("search", compact("id", "players", "coaches"));

    }

    public function index(){
        return redirect("/player");
    }

    public function suggest(Request $request){
        $key = $request->input('key');

        if (strlen($key) < 3) {
            return response('');
        }

        $html = '';
        $players = [];
        $players2 = [];
        $coaches = [];
        $teams = [];

        try {
            $dbCareer = new \SQLite3(env('DB_DATABASE'));
            $dbMNL = new \SQLite3(env('DB_DATABASE2'));

            // Players
            $stmt = $dbMNL->prepare('SELECT FirstName || " " || LastName AS FullName, PlayerID, UniqueID FROM Players WHERE FullName LIKE :key ORDER BY LastName ASC');
            $stmt->bindValue(':key', "%$key%", SQLITE3_TEXT);
            $result = $stmt->execute();

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $players[] = $row;
            }

            // SeasonStats
            $stmt2 = $dbCareer->prepare('SELECT PlayerName AS FullName, PlayerID FROM SeasonStats WHERE FullName LIKE :key GROUP BY PlayerID ORDER BY FullName ASC');
            $stmt2->bindValue(':key', "%$key%", SQLITE3_TEXT);
            $result2 = $stmt2->execute();

            while ($row = $result2->fetchArray(SQLITE3_ASSOC)) {
                $players2[] = [
                    "PlayerID" => $row['PlayerID'],
                    "UniqueID" => $row['PlayerID'],
                    "FullName" => $row['FullName'],
                ];
            }

            foreach ($players2 as $p2) {
                if (!collect($players)->contains(fn($p) => $p['UniqueID'] === $p2['PlayerID'])) {
                    $players[] = $p2;
                }
            }

            // Coaches
            $stmt3 = $dbMNL->prepare('SELECT FirstName || " " || LastName AS FullName, CoachID FROM Coaches WHERE FullName LIKE :key ORDER BY LastName ASC');
            $stmt3->bindValue(':key', "%$key%", SQLITE3_TEXT);
            $result3 = $stmt3->execute();

            while ($row = $result3->fetchArray(SQLITE3_ASSOC)) {
                $coaches[] = $row;
            }

            // Teams
            $stmt4 = $dbMNL->prepare('SELECT CityName || " " || TeamName AS Team, TeamID FROM Teams WHERE Team LIKE :key ORDER BY TeamName ASC');
            $stmt4->bindValue(':key', "%$key%", SQLITE3_TEXT);
            $result4 = $stmt4->execute();

            while ($row = $result4->fetchArray(SQLITE3_ASSOC)) {
                $teams[] = $row;
            }

            // Render HTML
            if ($players) {
                $html .= '<div class="suggest-title"><b>Players</b></div>';
                foreach (array_slice($players, 0, 5) as $p) {
                    $html .= '<div><a class="suggest-element" url="/formerplayer/' . utf8_encode($p['UniqueID']) . '">' . utf8_encode($p['FullName']) . '</a></div>';
                }
                if (count($players) > 5) {
                    $html .= '<div><a class="suggest-element" url="/playersearch/' . utf8_encode($key) . '">More players...</a></div>';
                }
            }

            if ($coaches) {
                $html .= '<div class="suggest-title"><b>Coaches</b></div>';
                foreach (array_slice($coaches, 0, 5) as $c) {
                    $html .= '<div><a class="suggest-element" url="/coach/' . utf8_encode($c['CoachID']) . '">' . utf8_encode($c['FullName']) . '</a></div>';
                }
                if (count($coaches) > 5) {
                    $html .= '<div><a class="suggest-element" url="/coachsearch/' . utf8_encode($key) . '">More coaches...</a></div>';
                }
            }

            if ($teams) {
                $html .= '<div class="suggest-title"><b>Teams</b></div>';
                foreach ($teams as $t) {
                    $html .= '<div><a class="suggest-element" url="/team/' . utf8_encode($t['TeamID']) . '">' . utf8_encode($t['Team']) . '</a></div>';
                }
            }

            return response($html);

        } catch (\Exception $e) {
            return response('<div class="error">Error: ' . htmlspecialchars($e->getMessage()) . '</div>', 500);
        }
    }


}
