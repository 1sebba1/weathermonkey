<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WeatherController extends Controller
{
    // Helper function to convert city name to latitude and longitude
    private function convertCitytoLatLon($city)
    {
        try {
            $apiKey = 'e34447b336e23cc1af3e42b28494eafd';
            $client = new Client();

            // Send a GET request to the OpenWeatherMap API to retrieve latitude and longitude data for the given city
            $response      = $client->get("http://api.openweathermap.org/geo/1.0/direct?q={$city}&appid={$apiKey}");
            $convertedData = json_decode($response->getBody(), true);

            foreach ($convertedData as $cdItem) {
                $lat = number_format((float) $cdItem['lat'], 2, '.', '');
                $lon = number_format((float) $cdItem['lon'], 2, '.', '');

            }

            // Return the latitude and longitude as an array
            return array('lat' => $lat, 'lon' => $lon);
        } catch (\Exception $e) {

            return null;
        }
    }

    // Controller method to get weather data
    public function getWeather(Request $request)
    {
        $apiKey = 'e34447b336e23cc1af3e42b28494eafd';
        $city   = $request->input('search');

        $client = new Client();

        // Convert city name to latitude and longitude

        $latlon = $this->convertCityToLatLon($city);
        if ($latlon != null) {
            foreach ($latlon as $coord) {
                $lat = $latlon['lat'];
                $lon = $latlon['lon'];
            }
        }


        try {

            // Get current weather data from OpenWeatherMap API
            $responseCurrent = $client->get("https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&units=metric&appid=$apiKey");
            $convertedData   = json_decode($responseCurrent->getBody(), true);
            $dataCurrent     = json_decode($responseCurrent->getBody(), true);


            foreach ($dataCurrent as $item) {

                // Extract relevant weather information
                $weather = $dataCurrent['weather'][0];
                $main    = $dataCurrent['main'];
                $wind    = $dataCurrent['wind'];
                $sys     = $dataCurrent['sys'];

                $temp      = round($main['temp'], 0);
                $feelsLike = round($main['feels_like']);
                $humidity  = $main['humidity'];

                $weatherMain = $weather['main'];
                $description = $weather['description'];
                $icon        = $weather['icon'];

                $speed   = $wind['speed'];
                $country = $sys['country'];

                $name       = $dataCurrent['name'];
                $mytime     = Carbon::now();
                $todaysDate = $mytime->toDateString();
                $today      = $mytime->dayName;

            }
            // Get forecast weather data using the latitude and longitude
            $forecastData = $this->getForecastWeather($lat, $lon);

            // Create arrays with relevant data for the view
            $compactData = array('name', 'country', 'temp', 'speed', 'feelsLike', 'humidity', 'main', 'description', 'icon', 'todaysDate', 'today', 'forecastData');
            $viewData    = array('name' => $name, 'country' => $country, 'temp' => $temp, 'speed' => $speed, 'feels_like' => $feelsLike, 'humidity' => $humidity, 'main' => $main, 'description' => $description, 'icon' => $icon);


            return view('dashboard', compact($compactData));
        } catch (\Exception $e) {

            return view('dashboard-error');
        }

    }

    // Helper function to get forecast weather data
    private function getForecastWeather($lat, $lon)
    {

        $apiKey = 'e34447b336e23cc1af3e42b28494eafd';

        $client = new Client();

        // Retrieve forecast data from the OpenWeatherMap API
        $responseForecast      = $client->get("https://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&units=metric&appid=$apiKey");
        $convertedDataForecast = json_decode($responseForecast->getBody(), true);
        $dataForecast          = json_decode($responseForecast->getBody(), true);

        // Get the current date in the local timezone
        $currentDate        = Carbon::now()->toDateString();
        $representativeData = [];

        // Iterate over the forecast data and filter out representative data for each date

        foreach ($dataForecast['list'] as $data) {
            $dateTime = new \DateTime($data['dt_txt']);
            $date     = $dateTime->format('Y-m-d');

            // If the date is different from the current date, consider it as representative data
            if ($date !== $currentDate) {
                $representativeData[$date] = $data;

                $currentDate = $date;
            }
        }
        $dataForecast = [];

        // Process the representative data and extract relevant information

        foreach ($representativeData as $dataItem) {
            $temp        = round($dataItem['main']['temp'], 0);
            $date        = $dataItem['dt_txt'];
            $day         = Carbon::parse($date)->format('D');
            $icon        = $dataItem['weather'][0]['icon'];
            $dataForecast[] = [
                'temp' => $temp,
                'day'  => $day,
                'icon' => $icon
            ];
        }
        $dataForecast = array_slice($dataForecast, 0, 4);

        return $dataForecast;
    }


}