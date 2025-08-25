<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\User;
use App\Notifications\PropertyApprovedNotification;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    

     public function index()
    {
        $properties = Property::where('approved',true)
      ->with(['type', 'subtype', 'images' ,'documents'])->get();
        return response()->
        json(['data'=>$properties ],200);
        
    }




    public function show($id)
    {

        $property=Property::where('approved',true)
        ->with(['type', 'subtype', 'images','documents'])
        ->findOrFail($id);

        
        return response()->
        json(['data'=>$property ],200);
           
    }


     public function userProperty(Request $request)
    {
        $user=$request->user();
        $properties=Property::where('user_id',$user->id)->where('approved',true)->
        with(['type', 'subtype', 'images'])->get();

        return response()->
        json(['data'=>$properties],200);

    }





    public function createProperty(PropertyRequest $request)
    {   $validated = $request->validated();
        $property= Property::create([
                'user_id' => $request->user()->id,         
                'type_id'       => $validated['type_id'],
                'subtype_id'    => $validated['subtype_id'],
                'title'         => $validated['title'],
                'status'        => $validated['status'],
                'description'   => $validated['description'] ?? null,
                'price'         => $validated['price'],
                'area'          => $validated['area'],
                'floor'         => $validated['floor'] ?? null,
                'rooms_count'   => $validated['rooms_count'] ?? null,
                'latitude'      => $validated['latitude'] ?? null,
                'longitude'     => $validated['longitude'] ?? null, 
                'has_pool'      => $validated['has_pool'] ?? false,
                'has_garden'    => $validated['has_garden'] ?? false,
                'has_elevator'  => $validated['has_elevator'] ?? false,
                'solar_energy'  => $validated['solar_energy'] ?? false,
                'features'      => $validated['features'] ?? null,
                'nearby_services' => $validated['nearby_services'] ?? null,
                
            ]);
            

        
   
        return response()->json([
            'message'  => 'created successfully, please wait to approve by admin',
            'property' => $property->load('type','subtype'),
        ], 201);

    }





    public function updateProperty(PropertyRequest $request, $id)
    {
        $property=Property::findOrFail($id);

        $property->update($request->validated());

        return response()->json([
            'message'  => 'updated successfully',
            'property' => $property->load('type', 'subtype', 'images'),
        ]);
    }





    public function deleteProperty( $id)
    {  $property=Property::findOrFail($id);

        $property->delete();

        return response()->json(['message' => 'deleted successfully']);
    }




    public function filterProperty(Request $request)
{
    $query = Property::query()->with(['type', 'subtype', 'images']);

    if ($request->filled('user_id'))
    {
        $query->where('user_id',$request->user_id);
    }

    if ($request->filled('type_id')) {
        $query->where('type_id', $request->type_id);
    }

    if ($request->filled('subtype_id')) {
        $query->where('subtype_id', $request->subtype_id);
    }
    if($request->filled('title'))
    {
        $query->where('title',$request->title);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereBetween('price', [$request->min_price, $request->max_price]);
    }

    if ($request->filled('min_area') && $request->filled('max_area')) {
        $query->whereBetween('area', [$request->min_area, $request->max_area]);
    }
    if ($request->filled('min_floor') && $request->filled('max_floor')) {
        $query->whereBetween('floor', [$request->min_floor,$request->max_floor]);
    }
      if ($request->filled('min_count' ) && $request->filled(key: 'max_count' ) ) {
        $query->whereBetween('rooms_count', [$request->min_count,$request->max_count]);
    }

      if ($request->filled('has_pool')) {
        $query->where('has_pool', $request->boolean('has_pool'));
    } 
    
    if ($request->filled('has_garden')) {
        $query->where('has_garden', $request->boolean('has_garden'));
    }

      if ($request->filled('has_elevator')) {
        $query->where('has_elevator', $request->boolean('has_elevator'));
    }

      if ($request->filled('solar_energy')) {
        $query->where('solar_energy', $request->boolean('solar_energy'));
    }

    $query->where('approved', true);

    $properties = $query->latest()->paginate($request->get('per_page', 15));

    return response()->json(['data'=>$properties],200);


 }








  public function changeStatus(Request $request, $id)
    {
          $property=Property::where('id',$id)->get();
          
        $this->authorize('changestatus',$property);

         $validated = $request->validate([
        'status' => 'required|string|in:sale,rent,reserved', 
    ]);
    $property->status=$validated['status'];
    $property->save();

     return response()->json([
        'message' => 'Property status updated successfully',
        'property' => $property,
    ]);

    }

  


    public function approve(Request $request, $id)
    {
    
        $property=Property::find($id);
        //$this->authorize('approve', $property);  
        if(!$property)
        {
               return response()->json([
            'message'  => 'id is not found',
        ]);
        }
        $property->approved = true;
        $property->save();

        $user=User::where('id',$property->user_id);
        $user->notify(
            new PropertyApprovedNotification(
                $property->id, 'approved', 'عقارك صار ظاهر الآن'));


        return response()->json([
            'message'  => 'approved',
            'property' => $property,
        ]);

    }

    }
    


