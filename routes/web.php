<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/change-language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('change-language');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'overview'])->name('dashboard');
    Route::get('/dashboard/overview', [DashboardController::class, 'overview'])->name('dashboard.overview');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Blog Routes
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/posts', [BlogController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [BlogController::class, 'create'])->name('posts.create');
        Route::post('/posts', [BlogController::class, 'store'])->name('posts.store');
        Route::get('/categories', [BlogController::class, 'categories'])->name('categories');
        Route::post('/categories', [BlogController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [BlogController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [BlogController::class, 'destroyCategory'])->name('categories.destroy');
        Route::get('/sub-categories', [BlogController::class, 'subCategories'])->name('sub-categories');
        Route::post('/sub-categories', [BlogController::class, 'storeSubCategory'])->name('sub-categories.store');
        Route::get('/comments', [BlogController::class, 'comments'])->name('comments');
    });

    // Events Routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('/events/past', [EventController::class, 'past'])->name('events.past');
    Route::get('/events/categories', [EventController::class, 'categories'])->name('events.categories');
    Route::get('/events/results', [EventController::class, 'results'])->name('events.results');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::get('/events/{event}/participants/pdf', [EventController::class, 'participantsPdf'])->name('events.participants.pdf');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Participants Routes
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/registered', [ParticipantController::class, 'registered'])->name('participants.registered');
    Route::get('/participants/pending', [ParticipantController::class, 'pending'])->name('participants.pending');
    Route::get('/participants/blacklist', [ParticipantController::class, 'blacklist'])->name('participants.blacklist');
    Route::post('/participants/{id}/blacklist', [ParticipantController::class, 'blacklistRider'])->name('participants.blacklist.action');
    Route::post('/participants/{id}/restore', [ParticipantController::class, 'restoreRider'])->name('participants.restore.action');
    Route::get('/participants/{id}/history-data', [ParticipantController::class, 'getHistory'])->name('participants.history.data');
    Route::get('/participants/{id}/profile', [ParticipantController::class, 'profile'])->name('participants.profile');
    Route::get('/participants/export', [ParticipantController::class, 'export'])->name('participants.export');

    // Registrations Routes
    Route::get('/registrations/new', [RegistrationController::class, 'new'])->name('registrations.new');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::post('/registrations/{id}/confirm', [RegistrationController::class, 'confirmPayment'])->name('registrations.confirm');
    Route::post('/registrations/{id}/toggle-checkin', [RegistrationController::class, 'toggleCheckin'])->name('registrations.toggle-checkin');
    Route::post('/registrations/{id}/status', [RegistrationController::class, 'updateStatus'])->name('registrations.update-status');
    Route::get('/registrations/confirmed', [RegistrationController::class, 'confirmed'])->name('registrations.confirmed');
    Route::get('/registrations/pending', [RegistrationController::class, 'pending'])->name('registrations.pending');
    Route::get('/registrations/cancelled', [RegistrationController::class, 'cancelled'])->name('registrations.cancelled');
    Route::get('/registrations/check-in', [RegistrationController::class, 'checkin'])->name('registrations.check-in');

    // Payments Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/pending', [PaymentController::class, 'pending'])->name('payments.pending');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/payments/completed', [PaymentController::class, 'completed'])->name('payments.completed');
    Route::get('/payments/failed', [PaymentController::class, 'failed'])->name('payments.failed');
    Route::get('/payments/refunds', [PaymentController::class, 'refunds'])->name('payments.refunds');
    Route::get('/payments/methods', [PaymentController::class, 'methods'])->name('payments.methods');
    Route::post('/payments/methods', [PaymentController::class, 'updateMethods'])->name('payments.methods.update');
    Route::get('/payments/methods/{method}', [PaymentController::class, 'methodDetails'])->name('payments.methods.details');

    // Sponsors Routes
    Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');
    Route::get('/sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
    Route::post('/sponsors', [SponsorController::class, 'store'])->name('sponsors.store');
    Route::get('/sponsors/packages', [SponsorController::class, 'packages'])->name('sponsors.packages');
    Route::get('/sponsors/payments', [SponsorController::class, 'payments'])->name('sponsors.payments');
    Route::get('/sponsors/contracts', [SponsorController::class, 'contracts'])->name('sponsors.contracts');
    Route::get('/sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
    Route::put('/sponsors/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
    Route::delete('/sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');

    // Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/profile/{id?}', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/users/profile/update', [UserController::class, 'updateProfile'])->name('users.profile.update');
    Route::get('/users/admins', [UserController::class, 'admins'])->name('users.admins');
    Route::get('/users/staff', [UserController::class, 'staff'])->name('users.staff');
    Route::get('/users/participants', [UserController::class, 'participants'])->name('users.participants');
    Route::get('/users/roles', [UserController::class, 'roles'])->name('users.roles');
    Route::get('/riders/search', [UserController::class, 'searchRider'])->name('riders.search');
    Route::get('/riders/{id}', [UserController::class, 'showRider'])->name('participants.profile');

    // Content Pages Routes
    Route::get('/content/pages', [ContentController::class, 'pages'])->name('content.pages');
    Route::get('/content/pages/edit/{id}', [ContentController::class, 'editPage'])->name('content.pages.edit');
    Route::post('/content/pages/update/{id}', [ContentController::class, 'updatePage'])->name('content.pages.update');

    // Special Deals Routes
    Route::get('/content/deals', [ContentController::class, 'deals'])->name('content.deals');
    Route::get('/content/deals/create', [ContentController::class, 'createDeal'])->name('content.deals.create');
    Route::post('/content/deals', [ContentController::class, 'storeDeal'])->name('content.deals.store');
    Route::get('/content/deals/edit/{id}', [ContentController::class, 'editDeal'])->name('content.deals.edit');
    Route::post('/content/deals/update/{id}', [ContentController::class, 'updateDeal'])->name('content.deals.update');
    Route::delete('/content/deals/{id}', [ContentController::class, 'destroyDeal'])->name('content.deals.destroy');

    // Media Library Routes
    Route::get('/content/media', [ContentController::class, 'media'])->name('content.media');
    Route::post('/content/media/upload', [ContentController::class, 'uploadMedia'])->name('content.media.upload');
    Route::delete('/content/media/{id}', [ContentController::class, 'destroyMedia'])->name('content.media.destroy');

    // Gallery Routes
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/categories', [GalleryController::class, 'categories'])->name('categories.index');
        Route::post('/categories', [GalleryController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [GalleryController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [GalleryController::class, 'destroyCategory'])->name('categories.destroy');

        Route::get('/images', [GalleryController::class, 'images'])->name('images.index');
        Route::post('/images/upload', [GalleryController::class, 'uploadImage'])->name('images.upload');
        Route::delete('/images/{image}', [GalleryController::class, 'destroyImage'])->name('images.destroy');
    });
    
    // Testimonials Routes
    Route::get('/content/testimonials', [ContentController::class, 'testimonials'])->name('content.testimonials');
    Route::get('/content/testimonials/create', [ContentController::class, 'createTestimonial'])->name('content.testimonials.create');
    Route::post('/content/testimonials', [ContentController::class, 'storeTestimonial'])->name('content.testimonials.store');
    Route::get('/content/testimonials/edit/{id}', [ContentController::class, 'editTestimonial'])->name('content.testimonials.edit');
    Route::post('/content/testimonials/update/{id}', [ContentController::class, 'updateTestimonial'])->name('content.testimonials.update');
    Route::delete('/content/testimonials/{id}', [ContentController::class, 'destroyTestimonial'])->name('content.testimonials.destroy');

    // FAQs Routes
    Route::get('/content/faqs', [ContentController::class, 'faqs'])->name('content.faqs');
    Route::get('/content/faqs/create', [ContentController::class, 'createFaq'])->name('content.faqs.create');
    Route::post('/content/faqs', [ContentController::class, 'storeFaq'])->name('content.faqs.store');
    Route::get('/content/faqs/edit/{id}', [ContentController::class, 'editFaq'])->name('content.faqs.edit');
    Route::post('/content/faqs/update/{id}', [ContentController::class, 'updateFaq'])->name('content.faqs.update');
    Route::delete('/content/faqs/{id}', [ContentController::class, 'destroyFaq'])->name('content.faqs.destroy');

    // Notifications Routes
    Route::get('/notifications/email', [NotificationController::class, 'email'])->name('notifications.email');
    Route::get('/notifications/sms', [NotificationController::class, 'sms'])->name('notifications.sms');
    Route::get('/notifications/templates', [NotificationController::class, 'templates'])->name('notifications.templates');
    Route::get('/notifications/broadcast', [NotificationController::class, 'broadcast'])->name('notifications.broadcast');
    Route::get('/notifications/history', [NotificationController::class, 'history'])->name('notifications.history');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');

    // Reports Routes
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/registrations', [ReportController::class, 'registrations'])->name('reports.registrations');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/participants', [ReportController::class, 'participants'])->name('reports.participants');
    Route::get('/reports/events', [ReportController::class, 'events'])->name('reports.events');
    Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');

    // Settings Routes
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::get('/settings/payments', [SettingController::class, 'payments'])->name('settings.payments');
    Route::get('/settings/email', [SettingController::class, 'email'])->name('settings.email');
    Route::get('/settings/sms', [SettingController::class, 'sms'])->name('settings.sms');
    Route::get('/settings/language', [SettingController::class, 'language'])->name('settings.language');
    Route::get('/settings/backup', [SettingController::class, 'backup'])->name('settings.backup');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');

    // Support Routes
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/help', [SupportController::class, 'help'])->name('help');
        Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');
        Route::get('/faqs', [SupportController::class, 'faqs'])->name('faqs');
        Route::get('/docs', [SupportController::class, 'docs'])->name('docs');
        Route::get('/contact', [SupportController::class, 'contact'])->name('contact');
        Route::get('/feedback', [SupportController::class, 'feedback'])->name('feedback');
    });
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
