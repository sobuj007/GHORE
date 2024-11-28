<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\Location;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetAllData extends Controller
{
    public function getAllData()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $bodyparts = BodyPart::all();
        $cities = City::all();
        $locations = Location::all();

        $data = [
            "category" => $categories->map(function($category) {
                return [
                    "id" => $category->id,
                    "name" => $category->name,
                    "image" => $category->image,
                    "gender" => $category->gender,
                ];
            }),
            "subcategory" => $subcategories->map(function($subcategory) {
                return [
                    "id" => $subcategory->id,
                    "category_id" => $subcategory->category_id,
                    "name" => $subcategory->name,
                    "image" => $subcategory->image,
                ];
            }),
            "bodypart" => $bodyparts->map(function($bodypart) {
                return [
                    "id" => $bodypart->id,
                    "subcategory_id" => $bodypart->subcategory_id,
                    "name" => $bodypart->name,
                    
                ];
            }),
            "cities" => $cities->map(function($city) {
                return [
                    "id" => $city->id,
                    "name" => $city->name,
                ];
            }),
            "location" => $locations->map(function($location) {
                return [
                    "id" => $location->id,
                    "cities_id" => $location->city_id,
                    "name" => $location->name,
                ];
            }),
        ];

        return response()->json($data);
    }
    
    public function getAllDataBygender()
{
    // Fetch categories, subcategories, and body parts for male
    $maleCategories = Category::where('gender', 'male')->get();
    $maleSubcategories = Subcategory::whereIn('category_id', $maleCategories->pluck('id'))->get();
    $maleBodyParts = BodyPart::whereIn('subcategory_id', $maleSubcategories->pluck('id'))->get();

    // Fetch categories, subcategories, and body parts for female
    $femaleCategories = Category::where('gender', 'female')->get();
    $femaleSubcategories = Subcategory::whereIn('category_id', $femaleCategories->pluck('id'))->get();
    $femaleBodyParts = BodyPart::whereIn('subcategory_id', $femaleSubcategories->pluck('id'))->get();

    // Fetch all cities and locations (assuming they are not gender-specific)
    $cities = City::all();
    $locations = Location::all();

    // Create the response data for male
    $maleData = [
        "category" => $maleCategories->map(function($category) {
            return [
                "id" => $category->id,
                "name" => $category->name,
                "img" => $category->img,
                "gender" => $category->gender,
            ];
        }),
        "subcategory" => $maleSubcategories->map(function($subcategory) {
            return [
                "id" => $subcategory->id,
                "category_id" => $subcategory->category_id,
                "name" => $subcategory->name,
                "img" => $subcategory->img,
            ];
        }),
        "bodypart" => $maleBodyParts->map(function($bodypart) {
            return [
                "id" => $bodypart->id,
                "subcategory_id" => $bodypart->subcategory_id,
                "name" => $bodypart->name,
                "img" => $bodypart->img,
            ];
        }),
        "cities" => $cities->map(function($city) {
            return [
                "id" => $city->id,
                "name" => $city->name,
            ];
        }),
        "location" => $locations->map(function($location) {
            return [
                "id" => $location->id,
                "cities_id" => $location->city_id,
                "name" => $location->name,
            ];
        }),
    ];

    // Create the response data for female
    $femaleData = [
        "category" => $femaleCategories->map(function($category) {
            return [
                "id" => $category->id,
                "name" => $category->name,
                "img" => $category->img,
                "gender" => $category->gender,
            ];
        }),
        "subcategory" => $femaleSubcategories->map(function($subcategory) {
            return [
                "id" => $subcategory->id,
                "category_id" => $subcategory->category_id,
                "name" => $subcategory->name,
                "img" => $subcategory->img,
            ];
        }),
        "bodypart" => $femaleBodyParts->map(function($bodypart) {
            return [
                "id" => $bodypart->id,
                "subcategory_id" => $bodypart->subcategory_id,
                "name" => $bodypart->name,
                "img" => $bodypart->img,
            ];
        }),
        "cities" => $cities->map(function($city) {
            return [
                "id" => $city->id,
                "name" => $city->name,
            ];
        }),
        "location" => $locations->map(function($location) {
            return [
                "id" => $location->id,
                "cities_id" => $location->city_id,
                "name" => $location->name,
            ];
        }),
    ];

    // Combine male and female data into a single response
    $data = [
        "male" => $maleData,
        "female" => $femaleData,
    ];

    return response()->json($data);
}
}
