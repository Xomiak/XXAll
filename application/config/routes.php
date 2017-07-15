<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['admin/login/logoff']    = "admin/login/logoff";
$route['admin/login/soc']           = "admin/login/soc";
$route['admin/login']           = "admin/login/index";

/////////////////
$route['admin/mailer/edit/(.*)']    = "admin/mailer/edit/$1";
$route['admin/mailer/view/(.*)']    = "admin/mailer/view/$1";
$route['admin/mailer/send/(.*)']    = "admin/mailer/send/$1";
$route['admin/mailer/add']          = "admin/mailer/add";
$route['admin/mailer']              = "admin/mailer/index";

///////////////// UPDATE
$route['admin/update/create']           = "admin/update/create";
$route['admin/update/clear']           = "admin/update/clear";
$route['admin/update/create_backup']           = "admin/update/createBackup";
$route['admin/update/check']            = "admin/update/check";
$route['admin/update/updating']         = "admin/update/updating";
$route['admin/update']                  = "admin/update";
/////////////////

/////////////////  CACHE
$route['admin/cache']                           = "admin/cache/index";

////////////////  TAGS
$route['admin/tags']                                = "admin/tags/index";

$route['admin/ajax/menus/(.*)']                     = "admin/ajax/menus/$1";
$route['admin/ajax/edit_adding_image/(.*)']                     = "admin/ajax/edit_adding_image/$1";
$route['admin/ajax/file/(.*)']                     = "admin/ajax/file/$1";
$route['admin/ajax/tags/(.*)']                     = "admin/ajax/tags/$1";
$route['admin/ajax/cache/(.*)']                     = "admin/ajax/cache/$1";
$route['admin/ajax/get_full_url/(.*)/(.*)']         = "admin/ajax/getFullUrl/$1/$2";
$route['admin/ajax/update/(.*)']                    = "admin/ajax/update/$1";
$route['admin/ajax/get_name_of/(.*)/(.*)/(.*)']     = "admin/ajax/getNameOf/$1/$2/$3";
$route['admin/ajax/get_name_of/(.*)/(.*)']          = "admin/ajax/getNameOf/$1/$2";
$route['admin/ajax/ping']                           = "admin/ajax/ping";
$route['admin/ajax/notification/(.*)']                     = "admin/ajax/notification/$1";
$route['admin/ajax/set_user_details']                  = "admin/ajax/set_user_details";
$route['admin/ajax/modules_action/(.*)']                  = "admin/ajax/modules_action/$1";
$route['admin/ajax/option/(.*)']                  = "admin/ajax/option/$1";
$route['admin/ajax/categories/(.*)']                  = "admin/ajax/categories/$1";
$route['admin/ajax/adresses/(.*)']                  = "admin/ajax/adresses/$1";
$route['admin/ajax/set_active/(.*)/(.*)/(.*)']      = "admin/ajax/set_active/$1/$2/$3";
$route['admin/ajax/delete/(.*)/(.*)']               = "admin/ajax/delete/$1/$2";
$route['admin/ajax/send_mail/(.*)']                 = "admin/ajax/send_mail/$1";
$route['admin/ajax/admin_save_price']               = "admin/ajax/admin_save_price";
$route['admin/ajax/upload_files/(.*)']              = "admin/ajax/upload_files/$1";
$route['admin/ajax/set_category_top']               = "admin/ajax/set_category_top";
$route['admin/ajax/action_image/(.*)']              = "admin/ajax/action_image/$1";
$route['admin/ajax/action_image']                   = "admin/ajax/action_image";
$route['admin/ajax/get_images']                     = "admin/ajax/get_images";
$route['admin/ajax/userdata/(.*)']                     = "admin/ajax/userdata/$1";
$route['admin/ajax/mailer/(.*)']                     = "admin/ajax/mailer/$1";
$route['admin/ajax/images_sort_save']               = "admin/ajax/images_sort_save";
$route['admin/ajax']                                = "admin/ajax";

////////////////

$route['admin/products/add']                            = "admin/products/add";
$route['admin/products/del/(.*)']                            = "admin/products/del/$1";
$route['admin/products/active/(.*)']                            = "admin/products/active/$1";
$route['admin/products/edit/(.*)']                            = "admin/products/edit/$1";
$route['admin/products/settings/del/(.*)']                    = "admin/products/settings_del/$1";
$route['admin/products/settings/up/(.*)']                    = "admin/products/settings_up/$1";
$route['admin/products/settings/down/(.*)']                    = "admin/products/settings_down/$1";
$route['admin/products/up/(.*)']            = "admin/products/up/$1";
$route['admin/products/down/(.*)']          = "admin/products/down/$1";
$route['admin/products/category/(.*)']      = "admin/products/category/$1";
$route['admin/products/category/(.*)']      = "admin/products/index/$1";
$route['admin/products/add_image']          = "admin/products/add_image";
$route['admin/products/edit_image']          = "admin/products/edit_image";
$route['admin/products/set_category']       = "admin/products/set_category";

$route['admin/products/settings']                    = "admin/products/settings";



$route['admin/products']                    = "admin/products";
$route['admin/products/(.*)']               = "admin/products/index/$1";

$route['admin/users/add']                   = "admin/users/add";
$route['admin/users/edit/(.*)']             = "admin/users/edit/$1";
$route['admin/users/del/(.*)']              = "admin/users/del/$1";
$route['admin/users/active/(.*)']           = "admin/users/active/$1";
$route['admin/users/sendmail/(.*)']         = "admin/users/sendmail/$1";
$route['admin/users']                       = "admin/users";

$route['admin/categories']              = "admin/categories";
$route['admin/categories/add']          = "admin/categories/add";
$route['admin/categories/up/(.*)']      = "admin/categories/up/$1";
$route['admin/categories/down/(.*)']    = "admin/categories/down/$1";
$route['admin/categories/del/(.*)']     = "admin/categories/del/$1";
$route['admin/categories/edit/(.*)']    = "admin/categories/edit/$1";
$route['admin/categories/active/(.*)']  = "admin/categories/active/$1";

$route['admin/filters']           = "admin/filters";
$route['admin/filters/add']       = "admin/filters/add";
$route['admin/filters/up']   = "admin/filters/up";
$route['admin/filters/down'] = "admin/filters/down";
$route['admin/filters/delete']  = "admin/filters/delete";
$route['admin/filters/edit'] = "admin/filters/edit";
$route['admin/filters/activate'] = "admin/filters/activate";
$route['admin/filters/deactivate'] = "admin/filters/deactivate";
$route['admin/filters/changeCat'] = "admin/filters/getFiltersByCategoryId";
$route['admin/filters/removeF_C'] = "admin/filters/unselectFilterInCategory";
$route['admin/filters/attachF_C'] = "admin/filters/selectFilterInCategory";
$route['admin/filters/removeV_P'] = "admin/filters/unselectValueInProduct";
$route['admin/filters/attachV_P'] = "admin/filters/selectValueInProduct";
$route['admin/filters/langs']       = "admin/filters/langs";

$route['admin/slider']           = "admin/main/slider";

$route['admin/currency']           = "admin/currency";
$route['admin/currency/add']       = "admin/currency/add";
$route['admin/currency/up/(.*)']   = "admin/currency/up/$1";
$route['admin/currency/down/(.*)'] = "admin/currency/down/$1";
$route['admin/currency/del/(.*)']  = "admin/currency/del/$1";
$route['admin/currency/edit/(.*)'] = "admin/currency/edit/$1";
$route['admin/currency/active/(.*)'] = "admin/currency/active/$1";

$route['admin/pages']           = "admin/pages";
$route['admin/pages/add']       = "admin/pages/add";
$route['admin/pages/up/(.*)']   = "admin/pages/up/$1";
$route['admin/pages/down/(.*)'] = "admin/pages/down/$1";
$route['admin/pages/del/(.*)']  = "admin/pages/del/$1";
$route['admin/pages/edit/(.*)'] = "admin/pages/edit/$1";
$route['admin/pages/active/(.*)'] = "admin/pages/active/$1";

$route['admin/languages']           = "admin/languages";
$route['admin/languages/add']       = "admin/languages/add";
$route['admin/languages/up/(.*)']   = "admin/languages/up/$1";
$route['admin/languages/down/(.*)'] = "admin/languages/down/$1";
$route['admin/languages/del/(.*)']  = "admin/languages/del/$1";
$route['admin/languages/edit/(.*)'] = "admin/languages/edit/$1";
$route['admin/languages/active/(.*)'] = "admin/languages/active/$1";

$route['admin/brands']           = "admin/brands";
$route['admin/brands/add']       = "admin/brands/add";
$route['admin/brands/up/(.*)']   = "admin/brands/up/$1";
$route['admin/brands/down/(.*)'] = "admin/brands/down/$1";
$route['admin/brands/del/(.*)']  = "admin/brands/del/$1";
$route['admin/brands/edit/(.*)'] = "admin/brands/edit/$1";
$route['admin/brands/active/(.*)'] = "admin/brands/active/$1";

$route['admin/menus']           = "admin/menus";
$route['admin/menus/create']       = "admin/menus/create";
$route['admin/menus/add']       = "admin/menus/add";
$route['admin/menus/up/(.*)']   = "admin/menus/up/$1";
$route['admin/menus/down/(.*)'] = "admin/menus/down/$1";
$route['admin/menus/del/(.*)']  = "admin/menus/del/$1";
$route['admin/menus/del-all']   = "admin/menus/del_all_post";
$route['admin/menus/edit/(.*)'] = "admin/menus/edit/$1";
$route['admin/menus/active/(.*)'] = "admin/menus/active/$1";

$route['admin/banners']             = "admin/banners/index";
$route['admin/banners/add']         = "admin/banners/add";
$route['admin/banners/del/(.*)']    = "admin/banners/del/$1";
$route['admin/banners/edit/(.*)']   = "admin/banners/edit/$1";
$route['admin/banners/up/(.*)']            = "admin/banners/up/$1";
$route['admin/banners/down/(.*)']          = "admin/banners/down/$1";

$route['admin/shop/import']             = "admin/shop/import";
$route['admin/shop/export']             = "admin/shop/export";
$route['admin/shop/category/(.*)']      = "admin/shop/category/$1";
$route['admin/shop/add']                = "admin/shop/add";
$route['admin/shop/add_image']          = "admin/shop/add_image";
$route['admin/shop/edit_image']         = "admin/shop/edit_image";
$route['admin/shop/edit/(.*)']          = "admin/shop/edit/$1";
$route['admin/shop/active/(.*)']        = "admin/shop/active/$1";
$route['admin/shop/always_first/(.*)']  = "admin/shop/always_first/$1";
$route['admin/shop/del/(.*)']           = "admin/shop/del/$1";
$route['admin/shop/up/(.*)']            = "admin/shop/up/$1";
$route['admin/shop/down/(.*)']          = "admin/shop/down/$1";
$route['admin/shop/set_category']       = "admin/shop/set_category";
$route['admin/shop/(.*)']               = "admin/shop/index/$1";
$route['admin/shop']                    = "admin/shop/index";

$route['admin/ploskost/up/(.*)']            = "admin/ploskost/up/$1";
$route['admin/ploskost/down/(.*)']          = "admin/ploskost/down/$1";
$route['admin/ploskost/edit/(.*)']          = "admin/ploskost/edit/$1";
$route['admin/ploskost/add']                = "admin/ploskost/add";
$route['admin/ploskost']                    = "admin/ploskost/index";

$route['admin/articles/tags']                            = "admin/articles/tags";
$route['admin/articles/backup']                            = "admin/articles/backup";
$route['admin/articles/add']                            = "admin/articles/add";
$route['admin/articles/del/(.*)']                            = "admin/articles/del/$1";
$route['admin/articles/active/(.*)']                            = "admin/articles/active/$1";
$route['admin/articles/edit/(.*)']                            = "admin/articles/edit/$1";
$route['admin/articles/settings/del/(.*)']                    = "admin/articles/settings_del/$1";
$route['admin/articles/settings/up/(.*)']                    = "admin/articles/settings_up/$1";
$route['admin/articles/settings/down/(.*)']                    = "admin/articles/settings_down/$1";
$route['admin/articles/up/(.*)']            = "admin/articles/up/$1";
$route['admin/articles/down/(.*)']          = "admin/articles/down/$1";
$route['admin/articles/category/(.*)']      = "admin/articles/category/$1";
$route['admin/articles/add_image']          = "admin/articles/add_image";
$route['admin/articles/edit_image']          = "admin/articles/edit_image";
$route['admin/articles/set_category']       = "admin/articles/set_category";
$route['admin/articles/adress_edit/(.*)']       = "admin/articles/adress_edit/$1";
$route['admin/articles/adresses']       = "admin/articles/adresses";
$route['admin/articles/adresses/(.*)']       = "admin/articles/adresses";

// Импорт ajax
$route['admin/articles/importnew']          = "admin/articles/importnew";
$route['admin/ajax/import']                 = "admin/ajax/import";


$route['admin/articles/import']          = "admin/articles/import";
$route['admin/articles/export']          = "admin/articles/export";

$route['admin/articles/settings']                    = "admin/articles/settings";
$route['admin/articles/:num']                    = "admin/articles";
$route['admin/articles']                    = "admin/articles";

$route['admin/schedule']                      = "admin/schedule/index";
$route['admin/schedule/add']                  = "admin/schedule/add";
$route['admin/schedule/edit/(.*)']            = "admin/schedule/edit/$1";
$route['admin/schedule/active/(.*)']          = "admin/schedule/active/$1";
$route['admin/schedule/del/(.*)']             = "admin/schedule/del/$1";

$route['admin/gallery/categories/add']          = "admin/gallery/categories_add";
$route['admin/gallery/categories/edit/(.*)']    = "admin/gallery/categoriesEdit/$1";
$route['admin/gallery/categories/up/(.*)']      = "admin/gallery/categoriesUp/$1";
$route['admin/gallery/categories/down/(.*)']    = "admin/gallery/categoriesDown/$1";
$route['admin/gallery/categories/del/(.*)']     = "admin/gallery/categoriesDel/$1";
$route['admin/gallery/categories/active/(.*)']  = "admin/gallery/categoriesActive/$1";
$route['admin/gallery/options/edit']            = "admin/gallery/optionsEdit";
$route['admin/gallery/options']                 = "admin/gallery/options";
$route['admin/gallery/categories']              = "admin/gallery/categories";



$route['admin/gallery/zip_import']              = "admin/gallery/zipImport";
$route['admin/gallery/add']                     = "admin/gallery/addFoto";
$route['admin/gallery/edit/(.*)']               = "admin/gallery/editFoto/$1";
$route['admin/gallery/up/(.*)']                 = "admin/gallery/up/$1";
$route['admin/gallery/down/(.*)']               = "admin/gallery/down/$1";
$route['admin/gallery/del/(.*)']                = "admin/gallery/delFoto/$1";
$route['admin/gallery/active/(.*)']             = "admin/gallery/activeFoto/$1";
$route['admin/gallery/set_category']            = "admin/gallery/set_category";
$route['admin/gallery/:num']                    = "admin/gallery/index";
$route['admin/gallery']                         = "admin/gallery/index";

$route['admin/images']                    = "admin/images/index";

$route['admin/comments/del/(.*)']           = "admin/comments/del/$1";
$route['admin/comments/(.*)']               = "admin/comments/index";
$route['admin/comments']                    = "admin/comments/index";


$route['admin/options/add']                 = "admin/options/add";
$route['admin/options/edit/(.*)']           = "admin/options/edit/$1";
$route['admin/options/set_module/(.*)']     = "admin/options/set_module/$1";
$route['admin/options/set_module']          = "admin/options/set_module";
$route['admin/options/del/(.*)']            = "admin/options/del/$1";
$route['admin/options']                     = "admin/options/index";
$route['admin/options/clear_breadcrumbs']   = "admin/options/clearBreadcrumbs";

$route['admin/quest/add']                 = "admin/quest/add";
$route['admin/quest/edit/(.*)']           = "admin/quest/edit/$1";
$route['admin/quest/set_module/(.*)']     = "admin/quest/set_module/$1";
$route['admin/quest/set_module']          = "admin/quest/set_module";
$route['admin/quest/del/(.*)']            = "admin/quest/del/$1";
$route['admin/quest']                     = "admin/quest/index";
//$route['(.*)/:num']

$route['admin/orders']           = "admin/orders";
$route['admin/orders/edit/(.*)'] = "admin/orders/edit/$1";
$route['admin/orders/del/(.*)']  = "admin/orders/del/$1";

$route['admin/main/clearcache']       = "admin/main/clearcache";

$route['admin']                 = "admin/main";
$route['admin/main/edit']       = "admin/main/edit";
$route['admin/banners/active/(.*)'] = "admin/banners/active/$1";

$route['admin/blogs/options/del/(.*)']          = "admin/blogs/blogOptionsDel/$1";
$route['admin/blogs/options/edit/(.*)']         = "admin/blogs/blogOptionsEdit/$1";
$route['admin/blogs/options/add']               = "admin/blogs/blogOptionsAdd";
$route['admin/blogs/options']                   = "admin/blogs/blogOptions";
$route['admin/blogs/invitation_code_add']       = "admin/blogs/invitation_code_add";
$route['admin/blogs/invitation_code_del/(.*)']  = "admin/blogs/invitation_code_del/$1";
$route['admin/blogs/invitation_codes']          = "admin/blogs/invitation_codes";
$route['admin/blogs/blog_content_edit/(.*)']    = "admin/blogs/blog_content_edit/$1";
$route['admin/blogs/blog/(.*)/:num']            = "admin/blogs/blog/$1"; // ���������
$route['admin/blogs/blog/(.*)']                 = "admin/blogs/blog/$1";
$route['admin/blogs/edit/(.*)']                 = "admin/blogs/edit/$1";
$route['admin/blogs/del/(.*)']                  = "admin/blogs/del/$1";
$route['admin/blogs/:num']                      = "admin/blogs/index"; // ���������
$route['admin/blogs']                           = "admin/blogs/index";
// �������� ����� �� active � del !!!!!!!!!!

// �����
$route['admin/forum/sections/add']              = "admin/forum/sections_add";
$route['admin/forum/sections/edit/(.*)']        = "admin/forum/sections_edit/$1";
$route['admin/forum/sections/del/(.*)']         = "admin/forum/sections_del/$1";
$route['admin/forum/sections/active/(.*)']      = "admin/forum/sections_active/$1";
$route['admin/forum/sections/up/(.*)']          = "admin/forum/sections_up/$1";
$route['admin/forum/sections/down/(.*)']        = "admin/forum/sections_down/$1";
$route['admin/forum/sections']                  = "admin/forum/sections";
$route['admin/forum/sections/:num']             = "admin/forum/sections"; // ���������

$route['admin/forum/topics/add']                        = "admin/forum/topics_add";
$route['admin/forum/topics/edit/(.*)']                  = "admin/forum/topics_edit/$1";
$route['admin/forum/topics/del/(.*)']                   = "admin/forum/topics_del/$1";
$route['admin/forum/topics/active/(.*)']                = "admin/forum/topics_active/$1";
//$route['admin/forum/topics/up/(.*)']                  = "admin/forum/topics_up/$1";
//$route['admin/forum/topics/down/(.*)']                = "admin/forum/topics_down/$1";
$route['admin/forum/topics/show_only_section_id/(.*)']  = "admin/forum/topics_show_only_section_id/$1";
$route['admin/forum/topics/show_only_section_id']       = "admin/forum/topics_show_only_section_id";
$route['admin/forum/topics/search']                     = "admin/forum/topics_search";
$route['admin/forum/topics/:num']                       = "admin/forum/topics"; // ���������
$route['admin/forum/topics']                            = "admin/forum/topics";

//$route['admin/forum/messages/add']              = "admin/forum/messages_add";
$route['admin/forum/messages/reserve_only']             = "admin/forum/reserve_only";
$route['admin/forum/messages/search']                   = "admin/forum/messages_search";
$route['admin/forum/messages/messages_search_user']     = "admin/forum/messages_search_user";
$route['admin/forum/messages/edit/(.*)']                = "admin/forum/messages_edit/$1";
$route['admin/forum/messages/del/(.*)']                 = "admin/forum/messages_del/$1";
$route['admin/forum/messages/active/(.*)']              = "admin/forum/messages_active/$1";
$route['admin/forum/messages/reserve/(.*)']             = "admin/forum/messages_reserve/$1";
$route['admin/forum/messages']                          = "admin/forum/messages";
//$route['admin/forum/messages/:num']             = "admin/forum/messages"; // ���������

$route['admin/forum/options/add']              = "admin/forum/options_add";
$route['admin/forum/options/edit/(.*)']        = "admin/forum/options_edit/$1";
$route['admin/forum/options/del/(.*)']         = "admin/forum/options_del/$1";
$route['admin/forum/options']                  = "admin/forum/options";

$route['admin/subscription']                          = "admin/subscription/index";


$route['admin/forum']                           = "admin/forum/sections";


$route['admin/interactive/questions'] = 'admin/interactive/questions';
$route['admin/interactive/edit_question/(.*)'] = 'admin/interactive/editQuestion/$1';
$route['admin/interactive/del_question/(.*)'] = 'admin/interactive/delQuestion/$1';

$route['admin/interactive/opinions'] = 'admin/interactive/opinions';
$route['admin/interactive/edit_opinion/(.*)'] = 'admin/interactive/editOpinion/$1';
$route['admin/interactive/del_opinion/(.*)'] = 'admin/interactive/delOpinion/$1';
// -- //

$route['admin/translations'] = 'admin/translations';
$route['admin/translations/(.*)'] = 'admin/translations/index/$1';


$route['questions/add'] = 'interactive/addQuestion';
$route['questions/(.*)'] = 'interactive/questions/$1';
$route['opinions/add'] = 'interactive/addOpinion';
$route['opinions/(.*)'] = 'interactive/opinions/$1';

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$route['lang'] = "language";
$route['lang/(.*)'] = "language/setLang/$1";
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$route['share'] = "language";
$route['lang/(.*)'] = "language/setLang/$1";
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$route['parser/goroskop']               = "parser/goroskop";
$route['parser/recipes']               = "parser/recipes";
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

// ЗАГРУЗКА ФАЙЛА ЧЕРЕЗ CKEDITOR
$route['ckupload'] = "ckupload/upload_file";

////   AJAX
$route['ajax/comment/(.*)']           = "ajax/comment/$1";
$route['ajax/login']           = "ajax/login";
$route['ajax/get_block/(.*)']           = "ajax/getBlock/$1";
$route['ajax/send_mail']           = "ajax/send_mail";
$route['ajax/setka/(.*)']           = "ajax/setka/$1";
$route['ajax/cities/(.*)']           = "ajax/cities/$1";
$route['ajax/getnextrows/(.*)']           = "ajax/getNextRows/$1";
$route['ajax/umnog/(.*)/(.*)']           = "ajax/umnog/$1/$2";
$route['ajax/cart_save']           = "ajax/cart_save";
$route['ajax/to_cart']           = "ajax/to_cart";
$route['ajax/form']           = "ajax/form";
$route['ajax/like']             = "ajax/like";
$route['ajax/dislike']           = "ajax/dislike";
$route['ajax/rate/(.*)']             = "ajax/rate/$1";
$route['ajax/get_subcategories/(.*)']    = "ajax/getSubcategories/$1";
$route['ajax/adresses/(.*)']           = "ajax/adresses/$1";
$route['ajax/get_ajax_block/(.*)/(.*)']           = "ajax/getAjaxBlock/$1/$2";



//////////////////////////////////////////////////////////////////////////
//// CRON //////////////////////

$route['cron/set_adresses/(.*)'] = "cron/setAdresses/$1";
$route['cron/set_adresses'] = "cron/setAdresses";

/////// КЛИЕНТСКАЯ ЧАСТЬ
$route['payment/privat24/(.*)']     = 'shop/privat/$1';
$route['payed/privat24/(.*)']       = 'shop/privat_payed/$1';

$route['payment/liqpay/(.*)']       = 'shop/liqpay/$1';
$route['payed/liqpay/(.*)']         = 'shop/liqpay_payed/$1';
////////////////////////////////////////////////////////////
$route['add_to_cart/(.*)']      = "shop/add_to_cart/$1";
$route['add_to_cart']      = "shop/add_to_cart";
$route['my_cart/sended']   = "shop/sended";
$route['my_cart']          = "shop/my_cart";
$route['my_cart/del_products/(.*)'] = "shop/del_products/$1";
$route['order']            = "shop/order";
$route['set-brand/(.*)']   = "shop/set_brand/$1";
$route['unset-brand']      = "shop/unset_brand";

$route['set-filter']            = "shop/set_filter";

$route['mailer']                = "mailer/index";

$route['tags/(.*)/page-:num']          = 'tags/showByTag/$1';
$route['tags/(.*)']             = 'tags/showByTag/$1';
$route['tags']          = 'tags/index';

/*
$route['gallery/(.*)/image/(.*)']            = "gallery/image/$2/$1";
$route['gallery/(.*)/(.*)/image/(.*)']            = "gallery/image/$3/$2/$1";

$route['gallery/add']                   = "gallery/add";

$route['gallery/(.*)/(.*)/page-:num']         = "gallery/category/$2/$1";
$route['gallery/(.*)/page-:num']             = "gallery/category/$1";
$route['gallery/(.*)/(.*)']             = "gallery/category/$2/$1";
$route['gallery/page-:num']                  = "gallery";
$route['gallery/(.*)']                  = "gallery/category/$1";
$route['gallery']                       = "gallery";
*/

$route['comments/add']              = "comments/add";
$route['comments/answer/(.*)']      = "comments/answer/$1";

$route['search/(.*)']            = "categories/search";
$route['search']            = "categories/search";
$route['archive']           = "categories/archive";

$route['banner/(.*)']       = "categories/banner/$1";

$route['rss']                       = "rss/index";
$route['ukrnetrss']                       = "rss/ukrnetrss";

$route['subscription']              = "main/subscription";

$route['login/iframe_login']     = "login/iframeLogin";
$route['login/logout']     = "login/logout";
$route['login']     = "login/index";

$route['register/activation/(.*)/(.*)']         = "register/activation/$1/$2";
$route['register/send-activation-code/(.*)']    = "register/send_activation_code/$1";
$route['register/forgot']                       = "register/forgot";
$route['register/set_password/(.*)/(.*)']       = "register/set_password/$1/$2";
$route['register/(.*)']                         = "register/index";
$route['register']                              = "register/index";


// ����������
$route['add/article']           = "add/addArticle";
//

$route['user/add-organization']             = "user/addOrganization";
$route['user/mypage']                       = "user/mypage";
$route['user/adresses/(.*)']                       = "user/adresses/$1";
$route['user/add-adress/(.*)']                       = "user/addAdress/$1";
$route['user/edit-adress/(.*)']                       = "user/editAdress/$1";
$route['user/del-adress/(.*)']                       = "user/delAdress/$1";
$route['user/edit-organization/(.*)']                       = "user/editOrganization/$1";
$route['user/del-organization/(.*)']                       = "user/delOrganization/$1";
$route['user/edit-mypage']                  = "user/edit_mypage";
$route['user/set-type/(.*)']                  = "user/set_type/$1";
$route['user/buy-type/(.*)']                  = "user/buy_type/$1";
$route['user/upload/foto']                  = "register/fotoUpload";
$route['rating/(.*)']                       = "user/rating/$1";
$route['users/(.*)']                         = "user/showUserPage/$1";
$route['users']                             = "user/users";

// FORUM
$route['forum']                             = "forum/index";

// ����

$route['blog/add-blog-content/(.*)']        = "blog/add_blog_content/$1";
$route['blog/edit-blog-content/(.*)']       = "blog/edit_blog_content/$1";
$route['blog/del-blog-content/(.*)']        = "blog/del_blog_content/$1";

$route['blog/user/(.*)/page-:num']              = "blog/showBlog/$1";
$route['blog/user/(.*)/(.*)']               = "blog/showContent/$1/$2";
$route['blog/user/(.*)']                    = "blog/showBlog/$1";
$route['blog/edit/(.*)']                    = "blog/edit_blog_content/$1";
$route['blog/create/(.*)']                  = "blog/createBlog";
$route['blog/create']                       = "blog/createBlog";
$route['blog']                              = "blog/index";
//


//$route['order']             = "main/order";

$route['sitemap_xml']           = "sitemap/xml";

$route['sitemap/gallery/(.*)']  = "sitemap/gallery_category/$1";
$route['sitemap/gallery']       = "sitemap/gallery";
$route['sitemap/(.*)/page-:num']    = "sitemap/category/$1";
$route['sitemap/(.*)']          = "sitemap/category/$1";
$route['sitemap']               = "sitemap/index";

$route['banner_redirect/(.*)']   = "main/banner_redirect/$1";


$route['brand/(.*)/page-:num']     = "categories/brands/$1";
$route['brand/(.*)']           = "categories/brands/$1";

$route['brands/page-:num']          = "categories/all_brands";
$route['brands']                = "categories/all_brands";

$route['map']                   = "main/map";

//compare
$route['compare/add/(.*)'] = 'filters/addToCompare/$1';
$route['compare/del/(.*)'] = 'filters/deleteFromCompare/$1';
$route['compare/clear'] = 'filters/clearCompare';
$route['compare'] = 'filters/compare';
//end compare

$route['payment'] = "shop/payment";

$route['set_currency/(.*)'] = "shop/set_currency/$1";

$route['test']          = "main/test";
/*
$route['novinki']        = "categories/novinki";
$route['novinki/page-:num']        = "categories/novinki/$1";
*/
$route['page-:num']              = "main";

$route['(.*)/(.*)/(.*)/page-:num']    = "categories/subcategory/$3/$2";
$route['(.*)/(.*)/page-:num']    = "categories/subcategory/$2/$1";

$route['(.*)/(.*)/(.*)']    = "categories/subcategory/$3/$2";
$route['(.*)/page-:num']        = "categories/category/$1";
$route['(.*)/(.*)']         = "categories/subcategory/$2/$1";
$route['(.*)']              = "categories/category/$1";


$route['default_controller'] = "main";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */