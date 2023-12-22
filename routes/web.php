<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MessagesKHController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GoogleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Facades\Auth; 

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

Route::prefix('auth')->group(function () {
    Route::controller(auth\LoginController::class)->group(function () {
        //login
        Route::get('/view_login', 'viewLogin')->name('view-login');
        Route::post('/login', 'login')->name('login');
        //logout
        Route::post('logout', 'logout')->name('logout');
    });
    route::controller(auth\ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'ViewForgotPasswordForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });
    route::controller(auth\ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });

    route::controller(auth\RegisterAdminController::class)->group(function () {
        route::get('view_register', 'viewRegister')->name('view-register');
        route::post('register', 'registerAdmin')->name('register');
    });

    // route::controller(auth\ChangePassword::class)->group(function () {
    //     //change password
    //     Route::get('/view_change_password', 'viewChangePassword')->name('view-change-password');
    //     Route::post('/change_password', 'changePassword')->name('change-password');
    // });
});

    Route::prefix('admin')->group(function () {
        route::controller(auth\ChangePassword::class)->middleware('checkLogin.role')->group(function () {
            //change password
            Route::get('/view_change_password', 'viewChangePassword')->name('view-change-password');
            Route::post('/change_password', 'changePassword')->name('change-password');
        });
        Route::controller(HomeAdminController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/home', 'index')->name('home');
            route::get('/admin-profile', 'profile')->name('admin.profile');
            route::put('/admin-profile/{id}', 'updateProfile')->name('admin.update.profile');
        });
        Route::controller(UserController::class)->middleware('checkLogin.role')->group(function () {
            Route::get('/user', 'index')->name('users');
            Route::get('/user-create', 'create')->name('users.create');
            route::post('/user-store', 'store')->name('users.store');
            Route::get('/user-edit/{id}', 'edit')->name('users.edit');
            route::put('/user-update/{id}', 'update')->name('users.update');
            route::delete('/user-delete/{id}', 'delete')->name('users.delete');
            route::get('/list-user-delete', 'getAllUserDelete')->name('users.listDelete');
            route::delete('/user-forcedelete/{id}', 'forceDelete')->name('users.forcedelete');
            Route::patch('users/{id}/restore', 'restore')->name('users.restore');
            Route::post('/user/search', 'searchUser')->name('users.search');
        });
        Route::controller(BannerController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/banner', 'index')->name('banner');
            Route::get('/banner-create', 'create')->name('banner.create');
            route::post('/banner-store', 'store')->name('banner.store');
            Route::get('/banner-edit/{id}', 'edit')->name('banner.edit');
            route::put('/banner-update/{id}', 'update')->name('banner.update');
            route::delete('/banner-delete/{id}', 'delete')->name('banner.delete');
        });
        Route::controller(CategoryController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/category', 'index')->name('category');
            Route::get('/category-create', 'create')->name('category.create');
            route::post('/category-store', 'store')->name('category.store');
            Route::get('/category-edit/{id}', 'edit')->name('category.edit');
            route::put('/category-update/{id}', 'update')->name('category.update');
            route::delete('/category-delete/{id}', 'delete')->name('category.delete');
        });
        Route::controller(SubCategoryController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/subcategory', 'index')->name('subcategory');
            Route::get('/subcategory-create', 'create')->name('subcategory.create');
            route::post('/subcategory-store', 'store')->name('subcategory.store');
            Route::get('/subcategory-edit/{id}', 'edit')->name('subcategory.edit');
            route::put('/subcategory-update/{id}', 'update')->name('subcategory.update');
            route::delete('/subcategory-delete/{id}', 'delete')->name('subcategory.delete');
        });
        Route::controller(ProductsController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/products', 'index')->name('products');
            Route::get('/products-create', 'create')->name('products.create');
            route::post('/products-store', 'store')->name('products.store');
            Route::get('/products-edit/{id}', 'edit')->name('products.edit');
            route::put('/products-update/{id}', 'update')->name('products.update');
            route::delete('/products-delete/{id}', 'delete')->name('products.delete');
            route::delete('/products-multiple', 'deleteSelected')->name('products.deleteMultiple');
            route::get('/product-expired', 'getProductsexpired')->name('products.expired');
            route::get('/product-out-of-stock', 'getProductOutOfStock')->name('products.outofstock');
            route::get('/product-survive', 'getProductSurvive')->name('products.survive');
            Route::post('/product/search', 'searchProduct')->name('products.search');
        });
        Route::controller(BlogController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/blog', 'index')->name('blog');
            Route::get('/blog-create', 'create')->name('blog.create');
            route::post('/blog-store', 'store')->name('blog.store');
            Route::get('/blog-edit/{id}', 'edit')->name('blog.edit');
            route::put('/blog-update/{id}', 'update')->name('blog.update');
            route::delete('/blog-delete/{id}', 'delete')->name('blog.delete');
        });
        Route::controller(OrderController::class)->middleware('checkLogin.role')->group(function () {
            route::get('order', 'index')->name('order.index');
            route::get('/order-show/{id}', 'show')->name('order.show');
            route::get('order/pdf/{id}', 'pdf')->name('order.pdf');
            route::get('/order-edit/{id}', 'edit')->name('order.edit');
            route::put('/order-update/{id}', 'update')->name('order.update');
            route::delete('/order/{id}', 'delete')->name('order.delete');
            route::get('/income', 'incomeChart')->name('product.order.income'); 
        });
        Route::controller(ProductReviewController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/reviews', 'index')->name('products.review');
            route::get('/review-edit/{id}', 'edit')->name('review.edit');
            route::put('/review-update/{id}', 'update')->name('review.update');
            route::delete('/review-delete{id}', 'delete')->name('review.delete');
        });
        Route::controller(CouponController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/coupon', 'index')->name('coupon.index');
            route::get('/coupon-create', 'create')->name('coupon.create');
            route::post('/coupon-store', 'store')->name('coupon.store');
            route::get('/coupon/edit/{id}', 'edit')->name('coupon.edit');
            route::put('/coupon-update/{id}', 'update')->name('coupon.update');
            route::delete('/coupon-delete/{id}', 'delete')->name('coupon.delete');
        });
        Route::controller(CommentController::class)->middleware('checkLogin.role')->group(function () {
            route::get('comment', 'index')->name('comment.index');
            route::get('/comment/{id}', 'edit')->name('comment.edit');
            route::put('/comment-update/{id}', 'update')->name('comment.update');
            route::delete('/comment-delete{id}', 'delete')->name('comment.delete');
        });
        Route::controller(MessagesController::class)->middleware('checkLogin.role')->group(function () {
            route::get('/message', 'index')->name('message.index');
            Route::post('/message/search', 'searchUser')->name('message.search');
            Route::get('/message/{id}', 'viewMessage')->name('message.view');
            Route::post('/chat/send', 'sendMessage')->name('message.sendMessage');

            Route::get('/chat', 'showChat')->name('message.index');
            Route::post('/chat/send', 'sendMessage')->name('message.sendMessage');
        });
        Route::controller(MessagesKHController::class)->middleware('checkLogin.role')->group(function () {
            // route::get('/messagekh', 'index')->name('messagekh.index');
            // Route::get('/message/view/id', 'viewMessage')->name('message.view');
            // route::post('message', function (Request $request) {
            //     return $request->input('message');
            // });
            // route::post('/message', 'store')->name('message');
            // route::get('/message/{id}', 'show')->name('message.show');
            // route::delete('/message-delete/{id}', 'delete')->name('message.delete');
            // routes/web.php
            Route::get('/chat', 'index')->name('chat.index');
            Route::post('/chat', 'store')->name('chat.store');
            Route::post('/chat/kh', 'storeKh')->name('chat.storeKh');

        });
    });
// });

// Route::prefix('auth')->group(function () {
Route::prefix('user')->group(function () {
    // Route::middleware(['user'])->group(function () {
        //khách hàng
        Route::controller(FrontendController::class)->group(function () {
            route::get('user-view_login', 'viewLogin')->name('user.view-login');
            route::post('user-login', 'login')->name('user.login');
            route::get('user-logout', 'logout')->name('user.logout');
            route::get('user-view_register', 'viewRegister')->name('user.view-register');
            route::post('user-register', 'register')->name('user.register');
        
            route::get('view_home', 'index')->name('home-user');

            route::get('/product_list', 'productList')->name('product-lists');
            route::get('/product_grids', 'productGrid')->name('product-grids');

            route::get('/product_category/{id}', 'productCate')->name('product-category');
            route::get('/product_sub_category/{id}', 'productSubCate')->name('product-sub-category');

            route::get('/product_detail/{id}', 'productDetail')->name('product-detail');

            Route::match(['get', 'post'], '/filter', 'productFilter')->name('shop.filter');

            Route::post('/product/search', 'productSearch')->name('product.search');

            route::get('/user-order', 'orderIndex')->name('user.order');

            route::get('/blog-list', 'blog')->name('blog.list');
            route::get('/blog-detail/{id}', 'blogDetail')->name('blog.detail');

            route::get('contact', 'contact')->name('contact');

            route::get('about-us', 'aboutUs')->name('aboutUs');

            route::get('/order-update/{id}', 'cancleOrder')->name('order.cancle');

            route::get('/user-profile', 'profile')->name('user.profile');
            route::put('/user-profile/{id}', 'updateProfile')->name('user.update.profile');
            Route::get('/user_form_change_password', 'userChangePassword')->name('user-form-change-password');
            Route::post('/user_change_password', 'changePassword')->name('user-change-password');

            Route::post('/cart/apply-coupon', 'couponStore')->name('cart.applyCoupon');
            Route::post('/mail/sendcode', 'sendCoupon')->name('mail.sendCoupon');

            route::get('history-order', 'historyOrder')->name('historyOrder');
            route::get('/view-order/{id}', 'viewOrder')->name('viewOrder');
        });
        Route::controller(cartController::class)->middleware('user')->group(function () {
            route::get('cart', 'index')->name('cart');
            route::get('/add-to-cart/{id}', 'addToCart')->name('add-to-cart');
            Route::post('cart-update', 'cartUpdate')->name('cart.update');
            Route::get('/cart-delete/{id}', 'cartdelete')->name('cart.delete');
            route::get('checkout', 'checkout')->name('checkout');
        });
        Route::controller(OrderController::class)->middleware('user')->group(function () {
            Route::post('cart/order', 'store')->name('cart.order');
            route::post('checkout/momo/', 'momo')->name('user.checkout.momo');
        });
        Route::controller(ProductReviewController::class)->middleware('user')->group(function () {
            Route::post('product/{id}/review', 'store')->name('review.store');
        });
        Route::controller(WishlistController::class)->middleware('user')->group(function () {
            route::get('/wishlist', 'index')->name('wishlist');
            route::get('/wishlist/{id}', 'addWishlist')->name('add-to-wishlist');
            route::get('/wishlist-delete/{id}', 'wishlistDelete')->name('wishlist.delete');
        });
        route::controller(messageController::class)->middleware('user')->group(function () {
            route::post('/message', 'store')->name('message');
        });
        route::controller(CommentController::class)->middleware([config('user')])->group(function () {
            route::post('/comment/{id}', 'store')->name('comment');
        });
        route::controller(PaymentController::class)->middleware([config('user')])->group(function (){
            route::get('/payment/checkout', 'getCheckout')->name('payment.checkout');
            Route::post('/paypal/checkout', 'postPayWithPayPal')->name('paypal.checkout');
            Route::get('/paypal/status', 'status')->name('paypal.status');
        });
    // });
});


route::controller(FrontendController::class)->group(function () {
    //socailite
    route::get('/googleLogin', 'googleLogin')->name('google.login');
    route::get('/auth/google/callback', 'googleHandle');
});
