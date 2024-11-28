<?php

use App\Http\middleware\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Agent\MyslotController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\ReviewRatingController;
use App\Http\Controllers\Agent\MyExpartController;
use App\Http\Controllers\PromotionBannerController;
use App\Http\Controllers\Backend\BodyPartController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\UsercomonprofileController;
use App\Http\Controllers\Agent\CertificateController;
use App\Http\Controllers\Backend\BannerAdsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Agent\StoreprofileController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Agent\ServiceProductController;
use App\Http\Controllers\Agent\AppointmentslotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//admin routes
Route::post('editor/image/upload', [DashboardController::class, 'imageUpload'])->name('editor.file.upload');



// Common Auth routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {

    Route::get('/', function () {

        /**
         * @var User $user
         */
        $user = auth()->user();
        if ($user) {
            if ($user->isAdmin()) {
                return view('admin.dashboard');
            }

           else if ($user->isAgent()) {
                return view('agent.dashboard');
            }
            else{
                return route('user.dashboard');
            }

        }


    })->name('dashboard');


    Route::get('user/profile', [UsercomonprofileController::class, 'index'])->name('usercommonprofile.index');

    Route::get('user/profile/create', [UsercomonprofileController::class, 'create'])->name('usercommonprofile.create');

    Route::post('user/profile/store', [UsercomonprofileController::class, 'store'])->name('usercommonprofile.store');


    Route::get('user/profile/edit', [UsercomonprofileController::class, 'edit'])->name('usercommonprofile.edit');

    Route::put('user/profile/update', [UsercomonprofileController::class, 'update'])->name('usercommonprofile.update');

});


// Only Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubcategoryController::class);
    Route::resource('bodypart', BodyPartController::class);
    Route::resource('promotion_banners', PromotionBannerController::class);
    Route::resource('cities', CityController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('users', UserController::class);
    // Route::resource('usercommonprofile', UsercomonprofileController::class);

});


// only agent routes
Route::prefix('agent')->middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/get-locations/{city}', [StoreprofileController::class, 'getLocations']);

  Route::resource('storeprofile', StoreprofileController::class);
  Route::resource('myexparts', MyExpartController::class);
  Route::resource('certificates', CertificateController::class);
// Routes for Myslot CRUD
Route::resource('myslots', MyslotController::class);

// Routes for Appointmentslot CRUD
Route::resource('appointmentslots', AppointmentslotController::class);
Route::resource('serviceproducts', ServiceProductController::class);

});
Route::middleware(['auth', 'role:agent'])->prefix('agents')->name('agents.')->group(function () {
    // Route::resource('serviceproducts', ServiceProductController::class);
    Route::get('subcategories', [ServiceProductController::class, 'getSubcategories'])->name('subcategories');
    Route::get('bodyparts', [ServiceProductController::class, 'getBodyParts'])->name('bodyparts');
    Route::get('locations', [ServiceProductController::class, 'getLocations'])->name('locations');
    Route::get('appointmentslots', [ServiceProductController::class, 'getAppointmentSlots'])->name('appointmentslots');
});
Route::middleware('auth')->group(function () {
    Route::get('/userdashboard',[DashboardController::class,'index'])->name(('user.dashboard'));
    Route::get('/userorder',[DashboardController::class,'create'])->name(('user.create'));
    Route::resource('orders', OrderController::class);
    Route::get('/agent/reviews', [ReviewRatingController::class, 'showAgentReviews'])->name('agent.reviews');
    Route::post('/reviewratings', [ReviewRatingController::class, 'store'])->name('reviewratings.store');
    Route::delete('/reviewratings/{reviewRating}', [ReviewRatingController::class, 'destroy'])->name('reviewratings.destroy');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';





// public function index()
// {
//     $banners = Bannerads::all();
//     return view('banner.index', compact('banners'));
// }

// public function create()
// {
//     return view('banner.create');
// }

// public function store(Request $request)
// {
//     $data = $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'image' => 'nullable|image|max:2048',
//         'link' => 'nullable|url',
//     ]);

//     if ($request->hasFile('image')) {
//         $data['image'] = $request->file('image')->store('banners', 'public');
//     }

//     Bannerads::create($data);
//     return redirect()->route('banner.index')->with('success', 'Banner created successfully.');
// }

// public function edit(Bannerads $banner)
// {
//     return view('banner.edit', compact('banner'));
// }

// public function update(Request $request, Bannerads $banner)
// {
//     $data = $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'image' => 'nullable|image|max:2048',
//         'link' => 'nullable|url',
//     ]);

//     // if ($request->hasFile('image')) {
//     //     // Delete the old image
//     //     if ($banner->image) {
//     //         Storage::disk('public')->delete($banner->image);
//     //     }
//     //     $data['image'] = $request->file('image')->store('banners', 'public');
//     // }

//     $banner->update($data);
//     return redirect()->route('banner.index')->with('success', 'Banner updated successfully.');
// }

// public function destroy(Bannerads $banner)
// {

//     $banner->delete();
//     return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
// }
// }
