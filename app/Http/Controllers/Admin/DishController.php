<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreDishRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateDishRequest;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dishes = Dish::all();
            $categories = Category::all();
            return view('Admin.dishes', compact('dishes', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to load dishes: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images'), $photoName);

            Dish::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'descraption' => $validatedData['descraption'],
                'photo' => $photoName,
                'cat_id' => $validatedData['cat_id'],
            ]);

            return redirect()->route('dishes.index')->with('success', 'Dish created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to create dish: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('photo')) {
                $photoName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('images'), $photoName);

                if ($dish->photo && file_exists(public_path('images') . '/' . $dish->photo)) {
                    unlink(public_path('images') . '/' . $dish->photo);
                    File::delete(public_path('images/' . $dish->photo));
                }

                $dish->photo = $photoName;
            }

            $dish->name = $validatedData['name'];
            $dish->price = $validatedData['price'];
            $dish->descraption = $validatedData['descraption'];
            $dish->cat_id = $validatedData['cat_id'];
            $dish->save();

            return redirect()->route('dishes.index', $dish)->with('success', 'Dish updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to update dish: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        try {
            if ($dish->photo && file_exists(public_path('images') . '/' . $dish->photo)) {
                File::delete(public_path('images/' . $dish->photo));
            }

            $dish->delete();
            return redirect()->route('dishes.index')->with('success', 'Dish deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to delete dish: ' . $e->getMessage());
        }
    }
}
