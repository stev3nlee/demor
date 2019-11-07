<?php
Route::group(['middlewareGroups' => ['web']], function () {
	Route::get('/', 'IndexController@index');
	// Route::get('/phpinfo', function(){
	// 	phpinfo();
	// });
	Route::get('/index/', 'IndexController@index');
	Route::get('/login', 'LoginController@index');
	Route::get('/login/confirmpayment', 'LoginController@index');
	Route::post('/login/submit/{isconfirmpayment}', 'LoginController@doLogin');
	Route::get('/logout/', 'LoginController@doLogout');
	Route::get('/forgot/', 'LoginController@forgot');
	Route::post('/forgot/submit/', 'LoginController@submitForgot');
	Route::get('/forgot/new/{id}/{token}', 'LoginController@forgotNewPassword');
	Route::post('/forgot/submit/newpassword/', 'LoginController@submitForgotNewPassword');
	Route::post('/login/submit', 'LoginController@doLogin');

	Route::get('/register/', 'LoginController@register');
	Route::get('/register/activate/{id}/{token}', 'LoginController@activateRegister');
	Route::post('/register/submit/', 'LoginController@submitRegister');
	Route::post('/submitnewsletter/', 'IndexController@submitNewsletter');
	//rian
	Route::post('/submitnewsletter2/', 'IndexController@submitNewsletter2');
	Route::post('/deletenewsletter/', 'IndexController@deleteNewsletter');
	//endrian

	//product routes
	Route::get('/cart/', 'CheckoutController@cart');
	Route::get('/checkout/', 'CheckoutController@checkout');
	Route::post('/checkout/validatevoucher/', 'CheckoutController@validateVoucher');
	Route::post('/checkout/submitinfo/', 'CheckoutController@checkoutSubmitInfo');
	Route::post('/checkout/submitvoucher/', 'CheckoutController@addVoucher');
	Route::get('/checkout/payment/', 'CheckoutController@checkoutPayment');
	Route::get('/checkout/confirm/', 'CheckoutController@checkoutConfirm');
	Route::post('/checkout/transfer/submit/', 'CheckoutController@checkoutTransferSubmit');

	Route::get('/checkout/testing/{lastno}', 'CheckoutController@checkoutTransferSubmitTestingEmail');

	Route::get('/checkout/transfersuccess/{order}', 'CheckoutController@checkoutTransferSuccess');
	Route::get('/checkout/creditsuccess/{order}', 'CheckoutController@checkoutTransferSuccess');

	Route::get('/checkout/vtweb/', 'CheckoutController@checkoutVtWeb');
	Route::get('/checkout/vtweb/finish/', 'CheckoutController@checkoutVtWebSuccess');
	Route::post('/checkout/vtweb/notif/', 'CheckoutController@VtWebNotification');
	Route::get('/product/', 'ProductController@index');
	Route::post('/product/addtocart/', 'CheckoutController@addToCart');
	Route::get('/product/deletecart/{id}/{color}/{size}', 'CheckoutController@deleteCart');
	Route::post('/product/search/', 'ProductController@search');
	Route::get('/product/search/{page}', 'ProductController@searchEmptyPage');
	Route::get('/product/search/{search}/{page}', 'ProductController@searchPage');
	Route::get('/product/arrival/', 'ProductController@arrival');
	Route::get('/product/arrival/{page}', 'ProductController@arrivalPage');
	Route::get('/product/detail/{id}', 'ProductController@detailById');
	Route::get('/product/sale/', 'ProductController@sale');

	Route::get('/product/collection/', 'ProductController@collection');
	Route::get('/product/collection/{page}', 'ProductController@collectionPage');

	Route::get('/product/sale/{page}', 'ProductController@salePage');
	Route::get('/product/{page}', 'ProductController@indexPage');
	Route::get('/product/category/{category}', 'ProductController@saleByCategory');
	Route::get('/product/category/{category}/{page}', 'ProductController@saleByCategoryPage');

	Route::get('/product/categories/{productCategory}', 'ProductController@indexcategory');
	Route::get('/product/categories/{productCategory}/{page}', 'ProductController@indexcategoryPage');

	//pages route
	Route::get('/pages/contact/', 'PagesController@contact');
	Route::post('/pages/contact/addcontact/', 'PagesController@addContact');
	Route::get('/pages/about/', 'PagesController@about');
	Route::get('/pages/working/', 'PagesController@working');
	Route::get('/pages/termcondition/', 'PagesController@termConditions');
	Route::get('/pages/shippingexchange/', 'PagesController@shippingExchange');
	Route::post('/pages/shippingexchange/submit', 'PagesController@submitExchange');
	Route::get('/pages/privacypolicy/', 'PagesController@privacyPolicy');
	Route::get('/pages/blog/', 'PagesController@viewBlog');
	Route::get('/pages/blog/{id}', 'PagesController@viewBlogById');

	//member route
	Route::get('/member/', 'MemberController@index');
	Route::get('/member/state/{country}', 'MemberController@getState');
	Route::get('/member/city/{state}', 'MemberController@getCity');
	Route::get('/member/postcode/{city}', 'MemberController@getPostCode');
	Route::post('/member/personal/submit', 'MemberController@submitPersonal');
	Route::get('/member/changepassword/', 'MemberController@changePassword');
	Route::post('/member/changepassword/submit', 'MemberController@submitChangePassword');
	Route::get('/member/confirmpayment/', 'MemberController@confirmPayment');
	Route::get('/member/confirmpaymentshipping/', 'MemberController@confirmPaymentShipping');
	Route::post('/member/confirmpayment/submit/', 'MemberController@submitConfirmPayment');
	Route::post('/member/confirmexchange/submit/', 'MemberController@submitConfirmExchange');
	Route::post('/member/confirmpayment/validate/', 'MemberController@validateConfirmPayment');
	Route::get('/member/newsletter/', 'MemberController@newsletter');
	Route::get('/member/order/', 'MemberController@order');
	Route::get('/member/order/view/{id}', 'MemberController@viewOrder');
	Route::get('/member/orderhistorybanktransfer/', 'MemberController@orderHistoryBankTransfer');
	Route::get('/member/orderhistorycreditcard/', 'MemberController@orderHistoryCreditCard');
	Route::get('/member/exchangedetail/{id}',  'MemberController@exchangeDetail');

	Route::get('/popup', 'PagesController@showPopup');
});
	//admin route
	Route::get('/meisjejongetje/', 'Admin\AdminLoginController@index');
	Route::post('/meisjejongetje/login/', 'Admin\AdminLoginController@login');
	Route::get('/meisjejongetje/logout/', 'Admin\AdminLoginController@logout');
	Route::get('/meisjejongetje/forgot/', 'Admin\AdminLoginController@forgot');
	Route::get('/meisjejongetje/index/', 'Admin\AdminIndexController@index');
	Route::post('/meisjejongetje/index/topsales/', 'Admin\AdminIndexController@getTopSalesProduct');

	//admin pages route
	Route::get('/meisjejongetje/pages/', 'Admin\AdminPagesController@index');
	Route::get('/meisjejongetje/pages/editpages/{id}', 'Admin\AdminPagesController@editPages');
	Route::get('/meisjejongetje/pages/viewpages/{id}', 'Admin\AdminPagesController@viewPages');
	Route::post('/meisjejongetje/pages/submitpages/', 'Admin\AdminPagesController@submitPages');
	Route::get('/meisjejongetje/pages/blog/category/', 'Admin\AdminPagesController@blogCategory');
	Route::post('/meisjejongetje/pages/blog/addcategory/', 'Admin\AdminPagesController@addBlogCategory');
	Route::post('/meisjejongetje/pages/blog/editcategory/', 'Admin\AdminPagesController@editBlogCategory');
	Route::post('/meisjejongetje/pages/blog/deletecategory/', 'Admin\AdminPagesController@deleteBlogCategory');
	Route::get('/meisjejongetje/pages/blog/list/', 'Admin\AdminPagesController@blogList');
	Route::get('/meisjejongetje/pages/blog/addlist/', 'Admin\AdminPagesController@addBlogList');
	Route::get('/meisjejongetje/pages/blog/editlist/{id}', 'Admin\AdminPagesController@editBlogList');
	Route::post('/meisjejongetje/pages/blog/editlist/submit/', 'Admin\AdminPagesController@submitEditBlogList');
	Route::post('/meisjejongetje/pages/blog/addlist/submit/', 'Admin\AdminPagesController@submitBlogList');
	Route::post('/meisjejongetje/pages/blog/deletelist/submit/', 'Admin\AdminPagesController@deleteBlogList');
	Route::get('/meisjejongetje/pages/contact/', 'Admin\AdminPagesController@contact');
	Route::post('/meisjejongetje/pages/contact/submitcontact/', 'Admin\AdminPagesController@submitContact');
	Route::post('/meisjejongetje/pages/deletemessage/', 'Admin\AdminPagesController@deleteMessage');
	Route::get('/meisjejongetje/pages/career/', 'Admin\AdminPagesController@career');
	Route::post('/meisjejongetje/pages/career/postcareer/', 'Admin\AdminPagesController@postCareer');
	Route::get('/meisjejongetje/pages/career/viewcareer/{id}', 'Admin\AdminPagesController@viewCareer');
	Route::get('/meisjejongetje/pages/career/addcareer/', 'Admin\AdminPagesController@addCareer');
	Route::get('/meisjejongetje/pages/career/editcareer/{id}', 'Admin\AdminPagesController@editCareer');
	Route::post('/meisjejongetje/pages/career/deletecareer/', 'Admin\AdminPagesController@deleteCareer');
	Route::post('/meisjejongetje/pages/career/submitcareer/', 'Admin\AdminPagesController@submitCareer');
	//Anthony
	Route::get('/meisjejongetje/pages/popup', 'Admin\AdminPagesController@showPopup');
	Route::post('/meisjejongetje/pages/popup/submitpopup', 'Admin\AdminPagesController@submitPopup');
	Route::get('/meisjejongetje/pages/currency', 'Admin\AdminPagesController@showCurrency');
	Route::post('/meisjejongetje/pages/currency/submitcurrency', 'Admin\AdminPagesController@submitCurrency');
	//End Anthony
	Route::get('/meisjejongetje/pages/footer/', 'Admin\AdminPagesController@footer');
	Route::post('/meisjejongetje/pages/footer/submitfooter/', 'Admin\AdminPagesController@submitFooter');
	Route::get('/meisjejongetje/pages/slider/', 'Admin\AdminPagesController@slider');
	Route::post('/meisjejongetje/pages/slider/add', 'Admin\AdminPagesController@addSlider');
	Route::post('/meisjejongetje/pages/slider/edit', 'Admin\AdminPagesController@editSlider');
	Route::post('/meisjejongetje/pages/slider/delete', 'Admin\AdminPagesController@deleteSlider');
	Route::get('/meisjejongetje/pages/newsletter/', 'Admin\AdminPagesController@newsletter');
	Route::post('/meisjejongetje/pages/send/newsletter/', 'Admin\AdminPagesController@sendnewsletter');
	Route::post('/meisjejongetje/pages/newsletter/delete', 'Admin\AdminPagesController@deleteNewsletter');

	//admin setting route
	Route::get('/meisjejongetje/settings/socialmedia/', 'Admin\AdminSettingController@socialMedia');
	Route::get('/meisjejongetje/settings/useraccount/role/', 'Admin\AdminUserController@role');
	Route::get('/meisjejongetje/settings/useraccount/addrole/', 'Admin\AdminUserController@addRole');
	Route::get('/meisjejongetje/settings/useraccount/editrole/{roleId}', 'Admin\AdminUserController@editRole');
	Route::post('/meisjejongetje/settings/useraccount/submitrole/', 'Admin\AdminUserController@submitRole');
	Route::post('/meisjejongetje/settings/useraccount/deleterole/', 'Admin\AdminUserController@deleteRole');
	Route::get('/meisjejongetje/settings/useraccount/account/', 'Admin\AdminUserController@account');
	Route::post('/meisjejongetje/settings/useraccount/addaccount/', 'Admin\AdminUserController@addAccount');
	Route::post('/meisjejongetje/settings/useraccount/editaccount/', 'Admin\AdminUserController@editAccount');
	Route::post('/meisjejongetje/settings/useraccount/deleteaccount/', 'Admin\AdminUserController@deleteAccount');
	Route::get('/meisjejongetje/settings/changepassword/', 'Admin\AdminSettingController@changePassword');
	Route::post('/meisjejongetje/settings/changepassword/submitchangepassword', 'Admin\AdminSettingController@submitChangePassword');
	Route::get('/meisjejongetje/settings/general/', 'Admin\AdminSettingController@general');
	Route::get('/meisjejongetje/settings/tools/', 'Admin\AdminSettingController@tools');
	Route::post('/meisjejongetje/settings/submitheader/', 'Admin\AdminSettingController@submitHeader');

	//admin commerce route
	Route::get('/meisjejongetje/commerce/member/', 'Admin\AdminMemberController@index');
	Route::get('/meisjejongetje/commerce/member/view/{userId}', 'Admin\AdminMemberController@view');
	Route::post('/meisjejongetje/commerce/member/delete/', 'Admin\AdminMemberController@deleteById');
	Route::get('/meisjejongetje/commerce/product/', 'Admin\AdminProductController@product');
	Route::get('/meisjejongetje/commerce/view/{id}', 'Admin\AdminProductController@viewProduct');
	Route::get('/meisjejongetje/commerce/product/color/', 'Admin\AdminProductController@colorProduct');
	Route::post('/meisjejongetje/commerce/product/submitcolor/', 'Admin\AdminProductController@submitColor');
	Route::post('/meisjejongetje/commerce/product/deletecolor/', 'Admin\AdminProductController@deleteColor');
	Route::get('/meisjejongetje/commerce/product/image/', 'Admin\AdminProductController@imageProduct');
	Route::post('/meisjejongetje/commerce/product/submitimage/', 'Admin\AdminProductController@submitImageProduct');
	Route::post('/meisjejongetje/commerce/product/deleteimage/', 'Admin\AdminProductController@deleteImageProduct');
	Route::get('/meisjejongetje/commerce/product/addproduct/', 'Admin\AdminProductController@addProduct');
	Route::get('/meisjejongetje/commerce/product/editproduct/{id}', 'Admin\AdminProductController@editProduct');
	Route::post('/meisjejongetje/commerce/product/submitproduct/', 'Admin\AdminProductController@submitProduct');
	Route::post('/meisjejongetje/commerce/product/submiteditproduct/', 'Admin\AdminProductController@submitEditProduct');
	Route::post('/meisjejongetje/commerce/product/deleteproduct/', 'Admin\AdminProductController@deleteProduct');
	Route::get('/meisjejongetje/commerce/order/', 'Admin\AdminOrderController@order');
	Route::post('/meisjejongetje/commerce/order/ajaxdetail/', 'Admin\AdminOrderController@getOrderDetail');
	Route::post('/meisjejongetje/commerce/order/submitpermit/', 'Admin\AdminOrderController@submitPermit');
	Route::post('/meisjejongetje/commerce/order/submitnotpermit/', 'Admin\AdminOrderController@submitNotPermit');
	Route::post('/meisjejongetje/commerce/order/submitrefund/', 'Admin\AdminOrderController@submitRefund');
	Route::post('/meisjejongetje/commerce/order/confirmpaid/', 'Admin\AdminOrderController@submitConfirmPaid');
	Route::get('/meisjejongetje/commerce/order/confirmpaid/{orderNo}', 'Admin\AdminOrderController@submitConfirmPaidTesting');
	Route::post('/meisjejongetje/commerce/order/deleteorder/', 'Admin\AdminOrderController@deleteOrder');
	Route::post('/meisjejongetje/commerce/order/cancelorder/', 'Admin\AdminOrderController@cancelOrder');
	Route::get('/meisjejongetje/commerce/invoice/{orderno}', 'Admin\AdminOrderController@invoice');
	Route::post('/meisjejongetje/commerce/order/shippingtracking/', 'Admin\AdminOrderController@submitShippingTracking');
	Route::get('/meisjejongetje/commerce/order/view/{orderno}', 'Admin\AdminOrderController@viewOrder');
	Route::get('/meisjejongetje/commerce/productcategory/', 'Admin\AdminProductController@productCategory');
	Route::post('/meisjejongetje/commerce/productcategory/addCategory', 'Admin\AdminProductController@addProductCategory');
	Route::post('/meisjejongetje/commerce/productcategory/editCategory', 'Admin\AdminProductController@editProductCategory');
	Route::post('/meisjejongetje/commerce/productcategory/deleteCategory', 'Admin\AdminProductController@deleteProductCategory');
	Route::get('/meisjejongetje/commerce/shipping/', 'Admin\AdminMemberController@shipping');
	Route::get('/meisjejongetje/commerce/payment/', 'Admin\AdminMemberController@payment');
	Route::post('/meisjejongetje/commerce/payment/savepublish', 'Admin\AdminMemberController@savePublish');
	Route::get('/meisjejongetje/commerce/payment/viewcredit/', 'Admin\AdminMemberController@viewCredit');
	Route::get('/meisjejongetje/commerce/payment/viewtransfer/', 'Admin\AdminMemberController@viewTransfer');
	Route::post('/meisjejongetje/commerce/payment/addtransfer/', 'Admin\AdminMemberController@addTransfer');
	Route::post('/meisjejongetje/commerce/payment/edittransfer/', 'Admin\AdminMemberController@editTransfer');
	Route::post('/meisjejongetje/commerce/payment/deletetransfer/', 'Admin\AdminMemberController@deleteTransfer');
	Route::get('/meisjejongetje/commerce/voucher/', 'Admin\AdminMemberController@voucher');
	Route::get('/meisjejongetje/commerce/voucher/add/', 'Admin\AdminMemberController@addVoucher');
	Route::get('/meisjejongetje/commerce/voucher/view/{id}', 'Admin\AdminMemberController@viewVoucher');
	Route::post('/meisjejongetje/commerce/voucher/submit/', 'Admin\AdminMemberController@submitVoucher');
	Route::post('/meisjejongetje/commerce/voucher/delete/', 'Admin\AdminMemberController@deleteVoucher');
	Route::get('/meisjejongetje/commerce/exchange/', 'Admin\AdminMemberController@exchange');
	Route::post('/meisjejongetje/commerce/exchange/delete/', 'Admin\AdminMemberController@deleteExchange');
	Route::post('/meisjejongetje/commerce/exchange/submitreply/', 'Admin\AdminMemberController@submitExchangeReply');
	Route::get('/meisjejongetje/commerce/others/', 'Admin\AdminMemberController@others');
	Route::post('/meisjejongetje/commerce/others/submitothers/', 'Admin\AdminMemberController@submitOthers');
