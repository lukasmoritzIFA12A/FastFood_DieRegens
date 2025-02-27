<?php

namespace App\utils;

class BundeslandFetcher
{
    public static function getBundesland($plz): bool|string
    {
        try {
            //cURL initialisieren
            $ch = curl_init("https://api.zippopotam.us/de/$plz");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Antwort als String zurückgeben

            // API-Anfrage senden
            $response = curl_exec($ch);

            // Fehlerbehandlung
            if (curl_errno($ch)) {
                return false;
            } else {
                // JSON-Daten dekodieren
                $data = json_decode($response, true);

                // Überprüfen, ob Daten vorhanden sind
                if (!empty($data['places'])) {
                    return $data['places'][0]['state'];
                } else {
                    return false;
                }
            }
        } finally {
            curl_close($ch);
        }
    }
}