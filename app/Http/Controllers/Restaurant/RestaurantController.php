<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Requests\MassDestroyRestaurantRequest;
use App\Restaurant;
use App\RestaurantImage;
use Illuminate\Http\Request;
use File;

class RestaurantController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('restaurant_access'), 403);

        $restaurants = Restaurant::with('images')->get();
        // dd($restaurants);

        return view('admin.restaurant.index', compact('restaurants'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('restaurant_create'), 403);

        return view('admin.restaurant.create');
    }

    //StoreRoleRequest
    public function store(StoreRestaurantRequest $request)
    {
        
        abort_unless(\Gate::allows('restaurant_create'), 403);

        $fileName = time().'.'.$request->image->extension();
        $request->image->storeAs('uploads', $fileName);
        // $request->image->move(public_path('uploads'), $fileName);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'description' => $request->description,
            'phone' => $request->phone,
        ]);

        $restaurant_image = RestaurantImage::create([
            'restaurant_id' => $restaurant->id,
            'image' => $fileName,
        ]);

        return redirect()->route('admin.restaurant.index');
    }

    public function edit($restaurant_id)
    {
        abort_unless(\Gate::allows('restaurant_edit'), 403);

        $restaurant = Restaurant::with('images')->where('id',$restaurant_id)->first();

        return view('admin.restaurant.edit', compact('restaurant'));
    }

    //UpdateRoleRequest
    public function update(Request $request, $restaurant_id)
    {
        //UpdateRestaurantRequest
        abort_unless(\Gate::allows('restaurant_edit'), 403);

        if($request->hasFile('image')){
            $restaurant_image_data = RestaurantImage::where('restaurant_id',$restaurant_id)->first();
            $image_path = public_path("uploads/$restaurant_image_data->image");
            if (File::exists($image_path)) {
            unlink($image_path);
            }

            $fileName = time().'.'.$request->image->extension();
            $request->image->storeAs('uploads', $fileName);

            $restaurant_image = RestaurantImage::where('restaurant_id',$restaurant_id)->update([
                'image' => $fileName,
            ]);
        }
        
        $restaurant = Restaurant::where('id',$restaurant_id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'description' => $request->description,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.restaurant.index');
    }

    public function show(Restaurant $restaurant)
    {
        abort_unless(\Gate::allows('restaurant_show'), 403);

        return view('admin.restaurant.show', compact('restaurant'));
    }

    public function destroy($restaurant_id)
    {
        abort_unless(\Gate::allows('restaurant_delete'), 403);

        $restaurant_image_data = RestaurantImage::where('restaurant_id',$restaurant_id)->first();
        $image_path = public_path("uploads/$restaurant_image_data->image");
        if (File::exists($image_path)) {
        unlink($image_path);
        }
        RestaurantImage::where('restaurant_id',$restaurant_id)->delete();
        Restaurant::where('id',$restaurant_id)->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantRequest $request)
    {
        Restaurant::whereIn('id', request('ids'))->delete();
        RestaurantImage::whereIn('restaurant_id', request('ids'))->delete();
    }

}
