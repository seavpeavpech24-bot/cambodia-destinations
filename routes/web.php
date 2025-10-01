<?php

use Illuminate\Support\Facades\Route;
use App\Data\DestinationsData;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ContactInquiryController;
use App\Http\Controllers\Admin\WebInfoController;
use App\Http\Controllers\Admin\DestinationCategoryController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\TravelTipController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroPagesController;
use App\Http\Controllers\Admin\YouTubeVideoController;
use App\Http\Controllers\Admin\AdvertisingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\BestVisitingTimeController;
use App\Http\Controllers\Admin\CultureEtiquetteController;
use App\Http\Controllers\Admin\GettingAroundController;
use App\Http\Controllers\Admin\MapCoordinatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataManagementController;
use App\Http\Controllers\Admin\DatabaseBackupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\DestinationController as PublicDestinationController;
use App\Http\Controllers\Public\TourController;
use App\Http\Controllers\Public\TravelTipController as PublicTravelTipController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\AiAssistantController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Add this route
Route::get('/destination/{id}', [PublicDestinationController::class, 'show'])->name('destinations.show');

Route::get('/destinations', [PublicDestinationController::class, 'index'])->name('destinations.index');

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');

Route::get('/about', [App\Http\Controllers\Public\AboutController::class, 'index'])->name('about.index');

Route::get('/contact', [App\Http\Controllers\Public\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/submit', [App\Http\Controllers\Public\ContactController::class, 'submit'])->name('contact.submit');

Route::get('/travel-tips', [PublicTravelTipController::class, 'index'])->name('travel-tips.index');




Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Content Management Module
    // Route::prefix('hero-pages')->name('hero-pages.')->group(function () {
    //     Route::get('/', function () { return view('admin.content.hero-pages.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.content.hero-pages.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.content.hero-pages.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.content.hero-pages.show'); })->name('show');
    // });

    Route::resource('hero-pages', HeroPagesController::class);

    // Route::prefix('destinations')->name('destinations.')->group(function () {
    //     Route::get('/', function () { return view('admin.content.destinations.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.content.destinations.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.content.destinations.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.content.destinations.show'); })->name('show');
    // });

    Route::resource('destinations', DestinationController::class);

    // Route::prefix('destination-categories')->name('destination-categories.')->group(function () {
    //     Route::get('/', function () { return view('admin.content.destination-categories.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.content.destination-categories.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.content.destination-categories.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.content.destination-categories.show'); })->name('show');
    // });

    Route::resource('destination-categories', DestinationCategoryController::class);

    // Route::prefix('travel-tips')->name('travel-tips.')->group(function () {
    //     Route::get('/', function () { return view('admin.content.travel-tips.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.content.travel-tips.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.content.travel-tips.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.content.travel-tips.show'); })->name('show');
    // });

    Route::resource('travel-tips', TravelTipController::class);

    // Correctly placed gallery resource route
    Route::resource('gallery', GalleryController::class);

    // Route::prefix('youtube-videos')->name('youtube-videos.')->group(function () {
    //     Route::get('/', function () { return view('admin.content.youtube-videos.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.content.youtube-videos.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.content.youtube-videos.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.content.youtube-videos.show'); })->name('show');
    // });

    Route::resource('youtube-videos', YouTubeVideoController::class);

    // Marketing Module
    // Route::prefix('advertising')->name('advertising.')->group(function () {
    //     Route::get('/', function () { return view('admin.marketing.advertising.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.marketing.advertising.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.marketing.advertising.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.marketing.advertising.show'); })->name('show');
    //     Route::put('/{id}/toggle-visibility', function () { /* Handle toggle visibility */ })->name('toggle-visibility'); // Placeholder for toggle visibility
    // });

    Route::resource('advertising', AdvertisingController::class);

    // Route::prefix('testimonials')->name('testimonials.')->group(function () {
    //     Route::get('/', function () { return view('admin.marketing.testimonials.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.marketing.testimonials.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.marketing.testimonials.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.marketing.testimonials.show'); })->name('show');
    //     Route::put('/{id}/approve', function () { /* Handle approve testimonial */ })->name('approve'); // Placeholder for approve
    //     Route::put('/{id}/reject', function () { /* Handle reject testimonial */ })->name('reject'); // Placeholder for reject
    // });

    Route::resource('testimonials', TestimonialController::class);

    // Route::prefix('subscribers')->name('subscribers.')->group(function () {
    //     Route::get('/', function () { return view('admin.marketing.subscribers.index'); })->name('index');
    //     Route::get('/export', function () { /* Handle export */ })->name('export'); // Placeholder for export
    //     Route::delete('/{id}', function () { /* Handle delete */ })->name('destroy'); // Placeholder for delete
    //     Route::get('/import', function () { return view('admin.marketing.subscribers.import'); })->name('import.form'); // Placeholder for import form
    //     Route::post('/import', function () { /* Handle import upload */ })->name('import.upload'); // Placeholder for import upload
    //     Route::get('/{id}', function () { return view('admin.marketing.subscribers.show'); })->name('show');
    //     Route::get('/import', function () { return view('admin.marketing.subscribers.import'); })->name('import');
    // });

    // Information Module
    // Route::prefix('best-visiting-times')->name('best-visiting-times.')->group(function () {
    //     Route::get('/', function () { return view('admin.information.best-visiting-times.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.information.best-visiting-times.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.information.best-visiting-times.edit'); })->name('edit');
    //     Route::delete('/{id}', function () { /* Handle delete */ })->name('destroy'); // Placeholder for delete
    // });

    Route::resource('best-visiting-times', BestVisitingTimeController::class);

    // Information Module (adding Culture & Etiquette)
    // Route::prefix('culture-etiquette')->name('culture-etiquette.')->group(function () {
    //     Route::get('/', function () { return view('admin.information.culture-etiquette.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.information.culture-etiquette.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.information.culture-etiquette.edit'); })->name('edit');
    //     Route::get('/{id}', function () { return view('admin.information.culture-etiquette.show'); })->name('show');
    //     Route::delete('/{id}', function () { /* Handle delete */ })->name('destroy'); // Placeholder for delete
    // });

    Route::resource('culture-etiquette', CultureEtiquetteController::class);

    // Route::prefix('getting-around')->name('getting-around.')->group(function () {
    //     Route::get('/', function () { return view('admin.information.getting-around.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.information.getting-around.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.information.getting-around.edit'); })->name('edit');
    //     Route::delete('/{id}', function () { /* Handle delete */ })->name('destroy'); // Placeholder for delete
    //     Route::get('/{id}', function () { return view('admin.information.getting-around.show'); })->name('show'); // Assuming a view route for this based on structure
    // });

    Route::resource('getting-around', GettingAroundController::class);

    // Route::prefix('map-coordinates')->name('map-coordinates.')->group(function () {
    //     Route::get('/', function () { return view('admin.information.map-coordinates.index'); })->name('index');
    //     Route::get('/create', function () { return view('admin.information.map-coordinates.create'); })->name('create');
    //     Route::get('/{id}/edit', function () { return view('admin.information.map-coordinates.edit'); })->name('edit');
    //     Route::delete('/{id}', function () { /* Handle delete */ })->name('destroy'); // Placeholder for delete
    //     Route::get('/{id}', function () { return view('admin.information.map-coordinates.show'); })->name('show'); // Assuming a view route for this based on structure
    // });

    Route::resource('map-coordinators', MapCoordinatorController::class);

    // Communication Module
    Route::resource('contact-inquiries', ContactInquiryController::class)->except(['create', 'store', 'edit']);
    Route::put('contact-inquiries/{contact_inquiry}/respond', [ContactInquiryController::class, 'respond'])->name('contact-inquiries.respond');
    Route::put('contact-inquiries/{contact_inquiry}/close', [ContactInquiryController::class, 'close'])->name('contact-inquiries.close');
    Route::get('contact-inquiries/export', [ContactInquiryController::class, 'export'])->name('contact-inquiries.export');

    Route::get('/web-info/settings', [WebInfoController::class, 'settings'])->name('web-info.settings');
    Route::put('/web-info/settings', [WebInfoController::class, 'updateWebInfo'])->name('web-info.update');

    // User Management Module
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::get('/{user}/reset-password', [UserController::class, 'showResetPasswordForm'])->name('reset-password');
        Route::put('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password.update');
    });

    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/import', [SubscriberController::class, 'import'])->name('subscribers.import');
    Route::post('subscribers/import', [SubscriberController::class, 'storeImport'])->name('subscribers.store-import');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
    Route::get('subscribers/{subscriber}', [SubscriberController::class, 'show'])->name('subscribers.show');
    Route::patch('subscribers/{subscriber}/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('subscribers.unsubscribe');
    Route::patch('subscribers/{subscriber}/resubscribe', [SubscriberController::class, 'resubscribe'])->name('subscribers.resubscribe');

    // Data Management Routes
    Route::prefix('data-management')->name('data-management.')->group(function () {
        Route::get('/', [DataManagementController::class, 'index'])->name('index');
        Route::post('/restore/{table}/{id}', [DataManagementController::class, 'restore'])->name('restore');
        Route::delete('/permanent-delete/{table}/{id}', [DataManagementController::class, 'permanentDelete'])->name('permanent-delete');
    });

    // Database Backup Routes
    Route::prefix('database-backup')->name('database-backup.')->group(function () {
        Route::get('/', [DatabaseBackupController::class, 'index'])->name('index');
        Route::post('/create', [DatabaseBackupController::class, 'create'])->name('create');
        Route::get('/download/{filename}', [DatabaseBackupController::class, 'download'])->name('download');
        Route::post('/restore', [DatabaseBackupController::class, 'restore'])->name('restore');
        Route::delete('/{filename}', [DatabaseBackupController::class, 'delete'])->name('delete');
    });
}); // Ends the admin middleware group

// Manually defined authentication routes
Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/gallery', [PublicGalleryController::class, 'index'])->name('gallery.index');

// AI Assistant Routes
Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai-assistant');
Route::post('/ai-assistant/chat', [AiAssistantController::class, 'chat'])->name('ai-assistant.chat');
