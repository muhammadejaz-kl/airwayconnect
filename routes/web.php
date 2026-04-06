<?php

use App\Http\Controllers\Admin\AirlinesDirectoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ForumController as AdminForumController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\InterviewController as AdminInterviewController;
use App\Http\Controllers\Admin\LegalsController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\ResumeSkillController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TestimonyController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\User\AirlineDirectory;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Users\AirlineDirectory as UsersAirlineDirectory;
use App\Http\Controllers\Users\AirlineDirectoryController;
use App\Http\Controllers\Users\EventController;
use App\Http\Controllers\Users\ExtractResumeController;
use App\Http\Controllers\Users\ForumController;
use App\Http\Controllers\Users\InterviewController;
use App\Http\Controllers\Users\JobsController;
use App\Http\Controllers\Users\PremiumController;
use App\Http\Controllers\Users\ProfileController as UsersProfileController;
use App\Http\Controllers\Users\ResourceController as UsersResourceController;
use App\Http\Controllers\Users\ResumeController;
use App\Http\Controllers\Users\UserController;
use App\Models\FAQ;
use App\Models\Testimony;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $faqs = FAQ::where('status', 1)->orderBy('id')->get();
    $testimonials = Testimony::where('status', '1')->orderBy('created_at', 'desc')->get();
    return view('welcome', compact('faqs', 'testimonials'));
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        // Admin Dashboard
        Route::get('dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [IndexController::class, 'profile'])->name('profile');

        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
            Route::get('edit/{id}', [TransactionController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [TransactionController::class, 'show'])->name('show');
            Route::post('update/{id}', [TransactionController::class, 'update'])->name('update');
            Route::post('/status/{id}', [TransactionController::class, 'updateStatus'])->name('status');
            Route::delete('destroy/{id}', [TransactionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdminUserController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [AdminUserController::class, 'show'])->name('show');
            Route::post('update/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::post('/status/{id}', [AdminUserController::class, 'updateStatus'])->name('status');
            Route::delete('destroy/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('organizations')->name('organizations.')->group(function () {
            Route::get('/', [OrganizationController::class, 'index'])->name('index');
            Route::post('store', [OrganizationController::class, 'store'])->name('store');
            Route::post('update/{id}', [OrganizationController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [OrganizationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/', [JobPostController::class, 'index'])->name('index');
            Route::post('store', [JobPostController::class, 'store'])->name('store');
            Route::get('show/{id}', [JobPostController::class, 'show'])->name('show');
            Route::post('update/{id}', [JobPostController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [JobPostController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('airlines-directory')->name('airlinesDirectory.')->group(function () {
            Route::get('/', [AirlinesDirectoryController::class, 'index'])->name('index');
            Route::post('store', [AirlinesDirectoryController::class, 'store'])->name('store');
            Route::get('show/{id}', [AirlinesDirectoryController::class, 'show'])->name('show');
            Route::post('update/{id}', [AirlinesDirectoryController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [AirlinesDirectoryController::class, 'destroy'])->name('destroy');

            Route::post('storeDetails', [AirlinesDirectoryController::class, 'storeDetails'])->name('storeDetails');
            Route::post('updateDetails/{id}', [AirlinesDirectoryController::class, 'updateDetails'])->name('updateDetails');
            Route::delete('destroyDetails/{id}', [AirlinesDirectoryController::class, 'destroyDetails'])->name('destroyDetails');
        });

        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [EventsController::class, 'index'])->name('index');
            Route::get('show/{id}', [EventsController::class, 'show'])->name('show');
            Route::post('store', [EventsController::class, 'store'])->name('store');
            Route::post('update/{id}', [EventsController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [EventsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('resources')->name('resources.')->group(function () {
            Route::get('category', [ResourceController::class, 'index'])->name('index');
            Route::post('category/store', [ResourceController::class, 'categoryStore'])->name('category.store');
            Route::post('category/update/{id}', [ResourceController::class, 'categoryUpdate'])->name('category.update');
            Route::delete('category/destroy/{id}', [ResourceController::class, 'categoryDestroy'])->name('category.destroy');

            Route::get('resource', [ResourceController::class, 'resourceIndex'])->name('resourceIndex');
            Route::post('resource/store', [ResourceController::class, 'resourceStore'])->name('resourceStore');
            Route::post('resource/update/{id}', [ResourceController::class, 'resourceUpdate'])->name('resourceUpdate');
            Route::delete('resource/destroy/{id}', [ResourceController::class, 'resourceDestroy'])->name('resourceDestroy');
        });

        Route::prefix('forum')->name('forum.')->group(function () {
            Route::get('topic', [AdminForumController::class, 'index'])->name('index');
            Route::post('topic/store', [AdminForumController::class, 'topicStore'])->name('topic.store');
            Route::post('topic/update/{id}', [AdminForumController::class, 'topicUpdate'])->name('topic.update');
            Route::delete('topic/destroy/{id}', [AdminForumController::class, 'topicDestroy'])->name('topic.destroy');

            Route::get('/', [AdminForumController::class, 'forumIndex'])->name('forumIndex');
            Route::post('store', [AdminForumController::class, 'store'])->name('store');
            Route::get('show/{id}}', [AdminForumController::class, 'show'])->name('show');
            Route::post('actionForum', [AdminForumController::class, 'actionForum'])->name('actionForum');
            Route::post('forum/update/{id}', [AdminForumController::class, 'forumUpdate'])->name('forumUpdate');
            Route::delete('forum/destroy/{id}', [AdminForumController::class, 'forumDestroy'])->name('forumDestroy');
        });

        Route::prefix('interview')->name('interview.')->group(function () {
            Route::get('topics', [AdminInterviewController::class, 'index'])->name('index');
            Route::post('topics/store', [AdminInterviewController::class, 'topicStore'])->name('topic.store');
            Route::post('topics/update/{id}', [AdminInterviewController::class, 'topicUpdate'])->name('topic.update');
            Route::delete('topics/destroy/{id}', [AdminInterviewController::class, 'topicDestroy'])->name('topic.destroy');

            Route::get('/', [AdminInterviewController::class, 'interviewIndex'])->name('interviewIndex');
            Route::post('store', [AdminInterviewController::class, 'store'])->name('store');
            Route::post('update/{id}', [AdminInterviewController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [AdminInterviewController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('resume-skills')->name('resumeSkill.')->group(function () {
            Route::get('category', [ResumeSkillController::class, 'index'])->name('index');
            Route::post('category/store', [ResumeSkillController::class, 'categoryStore'])->name('category.store');
            Route::post('category/update/{id}', [ResumeSkillController::class, 'categoryUpdate'])->name('category.update');
            Route::delete('category/destroy/{id}', [ResumeSkillController::class, 'categoryDestroy'])->name('category.destroy');

            Route::get('category/{id}/skills', [ResumeSkillController::class, 'skillIndex'])->name('skillIndex');
            Route::post('store', [ResumeSkillController::class, 'store'])->name('store');
            Route::post('update/{id}', [ResumeSkillController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [ResumeSkillController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('faqs')->name('faqs.')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('index');
            Route::post('store', [FaqController::class, 'store'])->name('store');
            Route::post('update/{id}', [FaqController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [FaqController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('testimony')->name('testimony.')->group(function () {
            Route::get('/', [TestimonyController::class, 'index'])->name('index');
            Route::post('store', [TestimonyController::class, 'store'])->name('store');
            Route::post('update/{id}', [TestimonyController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [TestimonyController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
            Route::get('/', [SubscriptionController::class, 'index'])->name('index');
            Route::post('store', [SubscriptionController::class, 'store'])->name('store');
            Route::post('update/{id}', [SubscriptionController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [SubscriptionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('coupons')->name('coupons.')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('index');
            Route::post('store', [CouponController::class, 'store'])->name('store');
            Route::post('update/{id}', [CouponController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [CouponController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('legals')->name('legals.')->group(function () {
            Route::get('/', [LegalsController::class, 'index'])->name('index');
            Route::post('store', [LegalsController::class, 'store'])->name('store');
            Route::post('update/{id}', [LegalsController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [LegalsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::post('send', [NotificationController::class, 'send'])->name('send');
        });
    });

    // User Routes
    Route::name('user.')->middleware(['role:user', 'check.user.status'])->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        Route::prefix('profiles')->name('profile.')->group(function () {
            Route::get('/', [UsersProfileController::class, 'index'])->name('index');
            Route::post('/check-password', [UsersProfileController::class, 'checkPassword'])->name('check-password');
            Route::post('update', [UsersProfileController::class, 'update'])->name('update');
        });

        Route::prefix('resume')->name('resume.')->group(function () {
            Route::get('/', [ResumeController::class, 'index'])->name('index');

            Route::post('save-template-session', [ResumeController::class, 'saveTemplateSession'])->name('saveTemplateSession');

            //Drag and drop section
            Route::post('parse', [ExtractResumeController::class, 'parseResume'])->name('parse');

            Route::get('get-template-preview', [ResumeController::class, 'getTemplatePreview'])->name('getTemplatePreview');

            Route::post('save-job', [ResumeController::class, 'saveJob'])->name('saveJob');
            Route::get('get-jobs', [ResumeController::class, 'getJobs'])->name('getJobs');
            Route::post('update-job', [ResumeController::class, 'updateJob'])->name('updateJob');
            Route::post('delete-job', [ResumeController::class, 'deleteJob'])->name('deleteJob');

            Route::post('save-experience-level-session', [ResumeController::class, 'saveExperienceLevelSession'])->name('saveExperienceLevelSession');
            Route::post('save-best-match-session', [ResumeController::class, 'saveBestMatchEducationSession'])->name('saveBestMatchEducationSession');
            Route::post('save-education-session', [ResumeController::class, 'saveEducationSession'])->name('saveEducationSession');
            Route::get('get-educations', [ResumeController::class, 'getEducations'])->name('getEducations');
            Route::post('update-education', [ResumeController::class, 'updateEducation'])->name('updateEducation');
            Route::post('delete-education', [ResumeController::class, 'deleteEducation'])->name('deleteEducation');

            Route::post('store', [ResumeController::class, 'store'])->name('store');
            Route::delete('delete/{id}', [ResumeController::class, 'delete'])->name('delete');
            Route::get('search', [ResumeController::class, 'searchSkills'])->name('searchSkills');

            Route::get('/finalize/template', [ResumeController::class, 'fetchFinalizeTemplate'])->name('finalize.template');

            Route::post('save-image', [ResumeController::class, 'saveResumeImage'])->name('save.image');
            Route::post('convert-to-pdf', [ResumeController::class, 'convertToPdf'])->name('convert.pdf');
            Route::get('view-pdf', [ResumeController::class, 'viewResumePdf'])->name('view.pdf');
            Route::get('download-pdf', [ResumeController::class, 'downloadResumePdf'])->name('download.pdf');
            Route::post('clear-session', [ResumeController::class, 'clearSession'])->name('clearSession');
        });

        Route::prefix('forum')->name('forum.')->group(function () {
            Route::get('/', [ForumController::class, 'index'])->name('index');
            Route::post('store', [ForumController::class, 'store'])->name('store');
            Route::get('show/{id}', [ForumController::class, 'show'])->name('show');

            Route::post('/forum/action', [ForumController::class, 'forumAction'])->name('action');

            Route::delete('destroy/{id}', [ForumController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('organizations')->name('organizations.')->group(function () {
            Route::get('/', [OrgController::class, 'index'])->name('index');
            Route::get('/show', [OrgController::class, 'show'])->name('show');
            Route::get('/show/{id}/details', [OrgController::class, 'details'])->name('details');
        });

        Route::prefix('job')->name('job.')->group(function () {
            Route::get('/', [JobsController::class, 'index'])->name('index');
            Route::get('show', [JobsController::class, 'show'])->name('show');
        });

        Route::prefix('interview')->name('interview.')->group(function () {
            Route::get('/', [InterviewController::class, 'index'])->name('index');
            Route::get('show/{id}', [InterviewController::class, 'show'])->name('show');
        });

        Route::prefix('resource')->name('resource.')->group(function () {
            Route::get('/', [UsersResourceController::class, 'index'])->name('index');
            Route::get('show', [UsersResourceController::class, 'show'])->name('show');
            Route::get('resource-details/{id}', [UsersResourceController::class, 'showdetails'])->name('details');
        });

        Route::prefix('events')->name('event.')->group(function () {
            Route::get('show', [EventController::class, 'show'])->name('show');
            Route::get('event-details/{id}', [EventController::class, 'showdetails'])->name('details');
        });

        Route::prefix('airlines-directory')->name('airlineDirectory.')->group(function () {
            Route::get('/', [AirlineDirectoryController::class, 'index'])->name('index');
            Route::get('show/{id}', [AirlineDirectoryController::class, 'show'])->name('show');
        });

        Route::prefix('premium-plan')->name('premium.')->group(function () {
            Route::get('/', [PremiumController::class, 'index'])->name('index');
            Route::get('show/{id}', [PremiumController::class, 'show'])->name('show');

            Route::post('/apply-coupon', [PremiumController::class, 'applyCoupon'])->name('applyCoupon');
            Route::post('/create-checkout', [PremiumController::class, 'createCheckout'])->name('createCheckout');
            Route::post('/catch-transaction', [PremiumController::class, 'catchTransaction'])->name('catchTransaction');

        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('my-notifications', [NotificationController::class, 'myNotifications'])->name('myNotifications');
            Route::post('mark-all-seen', [NotificationController::class, 'markAllSeen'])->name('markAllSeen');
            Route::delete('destroy/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });

        Route::post('update-premium-status', [PremiumController::class, 'updatePremiumStatus'])->name('updatePremiumStatus');

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('terms-services', [UserController::class, 'termsServices'])->name('termsServices');
Route::get('privacy-policies', [UserController::class, 'privacyPolicies'])->name('privacyPolicies');
Route::get('cookies-policies', [UserController::class, 'cookiesPolicies'])->name('cookiesPolicies');
require __DIR__ . '/auth.php';
