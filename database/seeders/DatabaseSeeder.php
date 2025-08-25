<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
                $this->call(WorkshopsSeeder::class);

        $this->call(Governorate_City_District_Seeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

}



/*// Models

// app/Models/Country.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Country extends Model {
    protected $fillable = ['name'];
    public function cities() { return $this->hasMany(City::class); }
}

// app/Models/City.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class City extends Model {
    protected $fillable = ['name', 'country_id'];
    public function country() { return $this->belongsTo(Country::class); }
    public function districts() { return $this->hasMany(District::class); }
}

// app/Models/District.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class District extends Model {
    protected $fillable = ['name', 'city_id'];
    public function city() { return $this->belongsTo(City::class); }
}

// app/Models/Property.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Property extends Model {
    protected $fillable = [
        'title', 'description', 'country_id', 'city_id', 'district_id', 'user_id', 'status'
    ];
    public function country() { return $this->belongsTo(Country::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function district() { return $this->belongsTo(District::class); }
}


// Migrations

// database/migrations/xxxx_create_countries_table.php
Schema::create('countries', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

// database/migrations/xxxx_create_cities_table.php
Schema::create('cities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('country_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// database/migrations/xxxx_create_districts_table.php
Schema::create('districts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('city_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// database/migrations/xxxx_create_properties_table.php
Schema::create('properties', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->foreignId('country_id')->constrained()->onDelete('cascade');
    $table->foreignId('city_id')->constrained()->onDelete('cascade');
    $table->foreignId('district_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
});


// Seeders

// database/seeders/CountryCityDistrictSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;
use App\Models\District;

class CountryCityDistrictSeeder extends Seeder {
    public function run() {
        $egypt = Country::create(['name' => 'Egypt']);
        $cairo = City::create(['name' => 'Cairo', 'country_id' => $egypt->id]);
        District::create(['name' => 'Nasr City', 'city_id' => $cairo->id]);
        District::create(['name' => 'Heliopolis', 'city_id' => $cairo->id]);

        $ksa = Country::create(['name' => 'Saudi Arabia']);
        $riyadh = City::create(['name' => 'Riyadh', 'country_id' => $ksa->id]);
        District::create(['name' => 'Al Malaz', 'city_id' => $riyadh->id]);
        District::create(['name' => 'Al Olaya', 'city_id' => $riyadh->id]);
    }
}

// Register seeder in DatabaseSeeder.php
$this->call(CountryCityDistrictSeeder::class);
*/
/*// PropertyController.php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        return Property::with(['country', 'city', 'district'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        $property = Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json($property, 201);
    }

    public function show($id)
    {
        return Property::with(['country', 'city', 'district'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $this->authorize('update', $property); // Optional: for policies

        $property->update($request->only(['title', 'description']));

        return response()->json($property);
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $this->authorize('delete', $property); // Optional
        $property->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function approve($id)
    {
        $property = Property::findOrFail($id);
        $property->status = 'approved';
        $property->save();
        return response()->json(['message' => 'Property approved']);
    }

    public function reject($id)
    {
        $property = Property::findOrFail($id);
        $property->status = 'rejected';
        $property->save();
        return response()->json(['message' => 'Property rejected']);
    }
}


// PropertyLocationController.php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\City;
use App\Models\District;

class PropertyLocationController extends Controller
{
    public function countries()
    {
        return Country::all();
    }

    public function cities($country_id)
    {
        return City::where('country_id', $country_id)->get();
    }

    public function districts($city_id)
    {
        return District::where('city_id', $city_id)->get();
    }
}*/
/*// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyLocationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // إدارة العقارات
    Route::apiResource('properties', PropertyController::class);
    Route::post('/properties/{id}/approve', [PropertyController::class, 'approve']);
    Route::post('/properties/{id}/reject', [PropertyController::class, 'reject']);

    // المواقع الجغرافية
    Route::get('/countries', [PropertyLocationController::class, 'countries']);
    Route::get('/countries/{id}/cities', [PropertyLocationController::class, 'cities']);
    Route::get('/cities/{id}/districts', [PropertyLocationController::class, 'districts']);

    // للمشرف العام فقط
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
    });
});
*/













/* new 
// Models

// app/Models/Governorate.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Governorate extends Model {
    protected $fillable = ['name'];
    public function cities() { return $this->hasMany(City::class); }
}

// app/Models/City.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class City extends Model {
    protected $fillable = ['name', 'governorate_id'];
    public function governorate() { return $this->belongsTo(Governorate::class); }
    public function districts() { return $this->hasMany(District::class); }
}

// app/Models/District.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class District extends Model {
    protected $fillable = ['name', 'city_id'];
    public function city() { return $this->belongsTo(City::class); }
}

// app/Models/Property.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Property extends Model {
    protected $fillable = [
        'title', 'description', 'governorate_id', 'city_id', 'district_id', 'user_id', 'status'
    ];
    public function governorate() { return $this->belongsTo(Governorate::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function district() { return $this->belongsTo(District::class); }
}


// Controllers

// app/Http/Controllers/Api/PropertyController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['governorate', 'city', 'district']);

        if ($request->governorate_id) {
            $query->where('governorate_id', $request->governorate_id);
        }
        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->district_id) {
            $query->where('district_id', $request->district_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $property = Property::create($data);

        return response()->json($property, 201);
    }

    public function show(Property $property)
    {
        return response()->json($property->load(['governorate', 'city', 'district']));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'governorate_id' => 'sometimes|required|exists:governorates,id',
            'city_id' => 'sometimes|required|exists:cities,id',
            'district_id' => 'sometimes|required|exists:districts,id',
        ]);

        $property->update($data);

        return response()->json($property);
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        $property->delete();

        return response()->json(['message' => 'Property deleted']);
    }
}


// Routes

// routes/api.php
use App\Http\Controllers\Api\PropertyController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('properties', PropertyController::class);
});


// Migrations

// database/migrations/xxxx_create_governorates_table.php
Schema::create('governorates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

// database/migrations/xxxx_create_cities_table.php
Schema::create('cities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('governorate_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// database/migrations/xxxx_create_districts_table.php
Schema::create('districts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('city_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// database/migrations/xxxx_create_properties_table.php
Schema::create('properties', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->foreignId('governorate_id')->constrained()->onDelete('cascade');
    $table->foreignId('city_id')->constrained()->onDelete('cascade');
    $table->foreignId('district_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
});


// Seeders

// database/seeders/GovernorateCityDistrictSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Governorate;
use App\Models\City;
use App\Models\District;

class GovernorateCityDistrictSeeder extends Seeder {
    public function run() {
        $damascusGov = Governorate::create(['name' => 'Damascus']);
        $damascus = City::create(['name' => 'Damascus City', 'governorate_id' => $damascusGov->id]);
        District::create(['name' => 'Mazzeh', 'city_id' => $damascus->id]);
        District::create(['name' => 'Kafr Souseh', 'city_id' => $damascus->id]);

        $aleppoGov = Governorate::create(['name' => 'Aleppo']);
        $aleppo = City::create(['name' => 'Aleppo City', 'governorate_id' => $aleppoGov->id]);
        District::create(['name' => 'Al-Sabil', 'city_id' => $aleppo->id]);
        District::create(['name' => 'New Aleppo', 'city_id' => $aleppo->id]);

        $homsGov = Governorate::create(['name' => 'Homs']);
        $homs = City::create(['name' => 'Homs City', 'governorate_id' => $homsGov->id]);
        District::create(['name' => 'Inshaat', 'city_id' => $homs->id]);
        District::create(['name' => 'Karam Al-Shami', 'city_id' => $homs->id]);
    }
}

// Register seeder in DatabaseSeeder.php
$this->call(GovernorateCityDistrictSeeder::class);
*/










/*للصور 

use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;

public function addImage(Request $request, $propertyId)
{
    $request->validate([
        'image' => 'required|image|max:2048',
    ]);

    $path = $request->file('image')->store('property_images', 'public');

    $image = PropertyImage::create([
        'property_id' => $propertyId,
        'image_path' => $path,
    ]);

    return response()->json($image, 201);
}
    */