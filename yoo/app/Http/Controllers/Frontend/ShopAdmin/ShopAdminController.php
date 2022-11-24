<?php

namespace App\Http\Controllers\Frontend\shopadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopInfo;
use App\Models\ItemCategory;
use App\Models\ItemComboCategory;
use App\Models\ItemCombo;
use App\Models\ItemTag;
use App\Models\ItemVariant;
use App\Models\Item;
use App\Models\ShopType;
use App\Models\ShopHour;
use App\Models\ShopDay;
use App\Models\ShopNote;
use App\Models\ShopHistoryLog;
use App\Models\WalletMethod;
use App\Models\WalletInfo;
use App\Models\OtpRegister;
use Illuminate\Support\Facades\Http;

class ShopAdminController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('shopadmin')->logout();
        return redirect()->route('login');
    }

    public function profile(Request $request)
    {
        $user = auth()->user()->management;
        return view('frontend.shopadmin.shopadmin_profile')->with([
            'profile' => $user,
            'user_type' => 'management'
        ]);
    }

    public function settings(Request $request)
    {
        $user = auth()->user();
        $management = auth()->user()->management;
        $type = ['cash', 'gcash', 'bpi', 'bdo', 'paymaya', 'unionbank'];
        $wm_available = [];

        foreach ($type as $key => $t) {
            $wallet_methods = WalletInfo::where([
                ['user_id', auth()->user()->id],
                ['wallet_method_id', $key+1]
            ])->first();

            if (!$wallet_methods) {
                $wallet_methods = null;
            }
            $wm_available[] = $wallet_methods;
        }

        return view('frontend.shopadmin.shopadmin_settinges')->with([
            'user' => $user,
            'management' => $management,
            'wm_available' => $wm_available,
        ]);
    }

    public function settingsUpdateProfile(Request $request)
    {
        $request->validate([
            'email' => "required",
            'date_of_birth' => 'date_format:Y-m-d',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'province_code' => 'required',
            'city_municipality' => 'required',
            'citymun_code' => 'required',
            'barangay' => 'required',
            'brgy_code' => 'required',
            'postal_code' => 'required',
        ]);

        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/profile_picture', $profile_picture);
        }

        $user = auth()->user();
        $user->email = $request->email;
        $user->save();

        $user->userInfo->first_name = $request->first_name;
        $user->userInfo->last_name = $request->last_name;
        $user->userInfo->middle_name = $request->middle_name;
        $user->userInfo->date_of_birth = $request->date_of_birth;
        $user->userInfo->address = $request->address;
        $user->userInfo->country = $request->country;
        $user->userInfo->province = $request->province;
        $user->userInfo->province_code = $request->province_code;
        $user->userInfo->city_municipality = $request->city_municipality;
        $user->userInfo->citymun_code = $request->citymun_code;
        $user->userInfo->barangay = $request->barangay;
        $user->userInfo->brgy_code = $request->brgy_code;
        $user->userInfo->postal_code = $request->postal_code;
        $user->userInfo->fb_link = $request->fb_link;

        if ($request->hasFile('profile_picture')) {
            $user->userInfo->profile_picture = $profile_picture;
        }
        $user->userInfo->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Succesfully',
            'text' => 'You have updated your profile',
            'user' => $user->load('userInfo')
        ];

        return response($response, 200);

        return redirect()->route('shopadmin.settings')->with([
            'profile' => $user,
            'status' => 'success',
            'title' => 'Updated Complete',
            'text' => 'Profile has Successfully Updated'
        ]);
    }

    public function settingsWalletFetch(Request $request, $id)
    {
        $wallet_info = WalletInfo::find($id);

        $response = [
            'message' => 'wallet info found',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsWalletUpdate(Request $request)
    {
        $request->validate([
            'wallet_info_id' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $wallet_info = WalletInfo::find($request->wallet_info_id);
        $wallet_info->acc_name = $request->acc_name;
        $wallet_info->acc_no = $request->acc_no;
        $wallet_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Succesfully',
            'text' => $wallet_info->name . ' wallet information has been updated',
            'wallet_info' => $wallet_info
        ];

        return response($response, 200);
    }

    public function settingsWalletDisconnect(Request $request)
    {
        $request->validate([
            'wallet_info_id' => 'required',
        ]);

        $wallet_info = WalletInfo::find($request->wallet_info_id);
        $wallet_info->user_id = null;
        $wallet_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Disconnected Succesfully',
            'text' => $wallet_info->name . ' wallet information has been disconnected',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsWalletConnect(Request $request)
    {
        $request->validate([
            'wallet_method_id' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $user = auth()->user();
        $wallet_info = new WalletInfo;
        $wallet_info->user_id = $user->id;
        $wallet_info->tx_user_type_id = 1;
        $wallet_info->wallet_method_id = $request->wallet_method_id;
        $wallet_info->acc_name = $request->acc_name;
        $wallet_info->acc_no = $request->acc_no;
        $wallet_info->save();


        $response = [
            'icon' => 'success',
            'title' => 'Created Succesfully',
            'text' => 'You have created a new wallet information',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsChangePassSendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999'
        ]);

        $otp = mt_rand(1000, 9999);

        $url = 'https://mach95.com/sms/send_sms';

        $sms_response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=1234'
        ])->post($url, [
            'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
            'data' => [
                'sender' => 'Yoo',
                'recipient' => $request->mobile_number,
                'message' => 'YooPh OTP verification code: ' . $otp
            ]
        ]);

        // save otp
        $otp_register = new OtpRegister;
        $otp_register->otp = $otp;
        $otp_register->mobile_number = $request->mobile_number;
        $otp_register->smsid = $sms_response->object()->smsid;
        $otp_register->save();
        $response = [
            'message' => 'Otp Successfully Sent',
            'otp_register' => $otp_register,
            'mobile_number' => $request->mobile_number,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ];

        return response($response, 200);
    }

    public function settingsChangePassConfirmOtp(Request $request)
    {

        $request->validate([
            'otp_id' => 'required',
            'otp_code' => 'required',
            'password' => 'required'
        ]);

        $user = auth()->user();
        $find_otp = OtpRegister::find($request->otp_id);
        if ($find_otp) {
            if ($find_otp->mobile_number == $user->mobile_number && $find_otp->otp == $request->otp_code) {
                // otp exist
                $user->password = bcrypt($request->password);
                $user->save();
                $response = [
                    'icon' => 'success',
                    'title' => 'Change Password Succesfully',
                    'text' => 'You have successfully change your password',
                    'otp_verified' => 1
                ];
                return response($response, 200);
            } else {
                // otp mistake
                $response = [
                    'icon' => 'warning',
                    'title' => 'Change Password Unsuccessfull',
                    'text' => 'You have entered a wrong OTP',
                    'otp_verified' => 0
                ];
                return response($response, 200);
                // return back()->with('error', 'The Otp Code is Incorrect');
            }
        } else {
            // otp not exist
            $response = [
                'icon' => 'warning',
                'title' => 'Change Password Unsuccessfull',
                'text' => 'Otp does not exist',
                'otp_verified' => 0
            ];
            return response($response, 200);
            // return back()->with('error', 'The Otp Code not does not exist');
        }
    }

    public function shop(Request $request, $type, $view)
    {
        $shop_type = ShopType::all();
        $shop_day = ShopDay::all();

        switch ($type) {
            case 'my':
                return view('frontend.shopadmin.shopadmin_my_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            case 'publish':
                return view('frontend.shopadmin.shopadmin_publish_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            case 'pending':
                return view('frontend.shopadmin.shopadmin_pending_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            default:
                return 'my-shops';
                break;
        }
    }

    public function shopFetchGrid(Request $request, $type, $shop_type_id)
    {
        $shop_type = ShopType::find($shop_type_id);

        switch ($type) {
            case 'my':
                $shop_info = ShopInfo::where([
                    ['shop_type_id', $shop_type_id],
                    ['user_id', auth()->user()->id]
                ])->get();
                break;
            case 'publish':
                $shop_info = ShopInfo::where('shop_type_id', $shop_type_id)->whereIn('shop_status_id', [3,4])->get();
                break;
            case 'pending':
                $shop_info = ShopInfo::where('shop_type_id', $shop_type_id)->whereIn('shop_status_id', [1,2,5])->get();
                break;
            default:
                return 'my-shops';
                break;
        }
        $response = [
            'shop_type' => $shop_type,
            'shop_list' => $shop_info->load(
                'shopStatus',
                'shopReview'
            )
        ];
        return response($response, 200);
    }

    public function addShop(Request $request)
    {
        if ($request->place_id == null) {
            $response = [
                'icon' => 'warning',
                'title' => 'Add Shop Failed',
                'text' => 'Invalid address Field Please try again',
                'place_id_null' => true,
            ];
            return response($response, 200);
        }

        $request->validate([
            'place_id' => "required",
            'lat' => "required",
            'lng' => "required",
            'address' => "required",
            'shop_code' => "required",
            'name' => "required",
            'shop_type_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        $shop_info = new ShopInfo;
        $shop_info->user_id = auth()->user()->id;
        $shop_info->name = $request->name;
        $shop_info->shop_type_id = $request->shop_type_id;
        $shop_info->place_id = $request->place_id;
        $shop_info->lat = $request->lat;
        $shop_info->lng = $request->lng;
        $shop_info->shop_code = $request->shop_code;
        $shop_info->address = $request->address;
        $shop_info->shop_status_id = 1; //draft

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop_image', $image);
        } else {
            $image = null;
        }

        $shop_info->image = $image;
        $shop_info->save();

        $shop_day = ShopDay::get();

        switch ($request->shop_days) {
            case 1:
                for ($i=1; $i <= 7; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 2:
                for ($i=1; $i <= 5; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 3:
                if ($request->monday_opening != null && $request->monday_closing != null) {
                    $mon_sh =  new ShopHour;
                    $mon_sh->shop_info_id = $shop_info->id;
                    $mon_sh->weekday = $shop_day->find(1)->day;
                    $mon_sh->opening = $request->monday_opening;
                    $mon_sh->closing = $request->monday_closing;
                    $mon_sh->shop_days_id = 1;
                    $mon_sh->save();
                }
                if ($request->tuesday_opening != null && $request->tuesday_closing != null) {
                    $tue_sh =  new ShopHour;
                    $tue_sh->shop_info_id = $shop_info->id;
                    $tue_sh->weekday = $shop_day->find(2)->day;
                    $tue_sh->opening = $request->tuesday_opening;
                    $tue_sh->closing = $request->tuesday_closing;
                    $tue_sh->shop_days_id = 2;
                    $tue_sh->save();
                }
                if ($request->wednesday_opening != null && $request->wednesday_closing != null) {
                    $wed_sh =  new ShopHour;
                    $wed_sh->shop_info_id = $shop_info->id;
                    $wed_sh->weekday = $shop_day->find(3)->day;
                    $wed_sh->opening = $request->wednesday_opening;
                    $wed_sh->closing = $request->wednesday_closing;
                    $wed_sh->shop_days_id = 3;
                    $wed_sh->save();
                }
                if ($request->thursday_opening != null && $request->thursday_closing != null) {
                    $thu_sh =  new ShopHour;
                    $thu_sh->shop_info_id = $shop_info->id;
                    $thu_sh->weekday = $shop_day->find(4)->day;
                    $thu_sh->opening = $request->thursday_opening;
                    $thu_sh->closing = $request->thursday_closing;
                    $thu_sh->shop_days_id = 4;
                    $thu_sh->save();
                }
                if ($request->friday_opening != null && $request->friday_closing != null) {
                    $fri_sh =  new ShopHour;
                    $fri_sh->shop_info_id = $shop_info->id;
                    $fri_sh->weekday = $shop_day->find(5)->day;
                    $fri_sh->opening = $request->friday_opening;
                    $fri_sh->closing = $request->friday_closing;
                    $fri_sh->shop_days_id = 5;
                    $fri_sh->save();
                }
                if ($request->saturday_opening != null && $request->saturday_closing != null) {
                    $sat_sh =  new ShopHour;
                    $sat_sh->shop_info_id = $shop_info->id;
                    $sat_sh->weekday = $shop_day->find(6)->day;
                    $sat_sh->opening = $request->saturday_opening;
                    $sat_sh->closing = $request->saturday_closing;
                    $sat_sh->shop_days_id = 6;
                    $sat_sh->save();
                }
                if ($request->sunday_opening != null && $request->sunday_closing != null) {
                    $sun_sh =  new ShopHour;
                    $sun_sh->shop_info_id = $shop_info->id;
                    $sun_sh->weekday = $shop_day->find(7)->day;
                    $sun_sh->opening = $request->sunday_opening;
                    $sun_sh->closing = $request->sunday_closing;
                    $sun_sh->shop_days_id = 7;
                    $sun_sh->save();
                }
                break;

            default:
                # code...
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop_info->id;
        $shop_history_log->remarks = 'shop ' . $shop_info->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop_info->created_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully DRAFTED a new shop',
            'place_id_null' => false,
            'shop_info' => $shop_info->load(
                'shopHour',
                'shopStatus'
            ),
        ];
        return response($response, 200);
    }

    public function shopInfo(Request $request, $type, $id)
    {
        $shop = ShopInfo::find($id);
        $categories = ItemCategory::where('shop_info_id', $shop->id)->orderBy('id', 'DESC')->get();
        $tags = ItemTag::all();
        $items = Item::where('shop_info_id', $shop->id)->orderBy('id', 'DESC')->get();
        $shop_day = ShopDay::all();

        return view('frontend.shopadmin.shopadmin_shop_info')->with([
            'type' => $type,
            'shop' => $shop,
            'tags' => $tags,
            'shop_day' => $shop_day,
            'categories' => $categories->load('items'),
            'items' => $items
        ]);
    }

    public function shopInfoItemInfoFetch(Request $request, $id)
    {
        $item = Item::find($id);

        $response = [
            'item' => $item->load(
                'itemVariants',
                'itemCategory',
                'itemComboCategories.itemCombo',
            )
        ];
        return response($response, 200);
    }

    public function shopInfoItemToggleFetchItem(Request $request, $id)
    {
        $item = Item::find($id);

        $response = [
            'item' => $item,
        ];
        return response($response, 200);
    }

    public function shopInfoToggleStatusUpdate(Request $request)
    {
        $shop = ShopInfo::find($request->shop_info_id);
        $shop->shop_status_id = $request->status;
        $shop->save();

        switch ($request->status) {
            case 3:
                $icon = 'success';
                $title = 'Published Successfully';
                $text = 'You have successfully published the shop';
                break;
            case 4:
                $icon = 'warning';
                $title = 'Deactivate Successfully';
                $text = 'You have succesfully deactivate this shop';
                break;
            default:
                # code...
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop->id;
        $shop_history_log->remarks = 'shop ' . $shop->id . ' updated to ' . $shop->shopStatus->id . '(' . $shop->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop->updated_at));
        $shop_history_log->save();

        $response = [
            'shop' => $shop,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        return response($response, 200);
    }

    public function shopInfoItemToggleStatusUpdate(Request $request)
    {
        $item = Item::find($request->item_id);

        $item->status = $request->status;
        $item->save();

        switch ($request->status) {
            case 1:
                $icon = 'success';
                $title = 'Published Successfully';
                $text = 'You have successfully enabled this shop';
                break;
            case 0:
                $icon = 'warning';
                $title = 'Deactivated Successfully';
                $text = 'You have succesfully disabled this shop';
                break;
            default:
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        if ($item->status == 1) {
            $shop_history_log->remarks = 'item ' . $item->id . ' updated to 1(active) by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->updated_at));
        } else {
            $shop_history_log->remarks = 'item ' . $item->id . ' updated to 0(inactive) by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->updated_at));
        }
        $shop_history_log->save();

        $response = [
            'item' => $item,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        return response($response, 200);
    }

    public function shopInfoCategoryFetch(Request $request, $id)
    {
        $item_categories = ItemCategory::where('shop_info_id', $id)->get();

        $response = [
            'item_categories' => $item_categories->load('items'),
        ];

        return response($response, 200);
    }

    public function shopInfoAddItem(Request $request)
    {
        $request->validate([
            'shop_id' => "required",
            'name' => "required",
            'cost' => "required",
            'markup' => "required",
            'item_markup_type' => "required",
            'item_category_id' => "required"
        ]);

        $item = new Item;
        $item->item_category_id = $request->item_category_id;
        if ($request->item_tag_id == 0) {
            $item->item_tag_id = null;
        } else {
            $item->item_tag_id = $request->item_tag_id;
        }
        $item->cost = (float)$request->cost;
        switch ($request->item_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $item->markup = $markup;
        $item->shop_info_id = $request->shop_id;
        $item->name = $request->name;

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/item_image', $image);
        } else {
            $image = null;
        }
        $item->image = $image;
        $item->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->shop_info_id = $item->shop_info_id;
        $shop_history_log->remarks = 'item ' . $item->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->created_at));
        $shop_history_log->save();

        $response = [
            'item' => $item->load('shopInfo'),
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new item on this category',
        ];

        return response($response, 200);
    }

    public function shopInfoAddCategory(Request $request)
    {
        $request->validate([
            'shop_id' => "required",
            'category' => "required",
        ]);

        $item_category = new ItemCategory;
        $item_category->shop_info_id = $request->shop_id;
        $item_category->category = $request->category;
        $item_category->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item_category->shop_info_id;
        $shop_history_log->remarks = 'category ' . $item_category->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item_category->created_at));
        $shop_history_log->save();

        $response = [
            'item_category' => $item_category->load('items')
        ];

        return response($response, 200);
    }

    public function shopInfoAddNote(Request $request)
    {
        $request->validate([
            'shop_id' => 'required',
            'notes' => 'required'
        ]);

        $note = new ShopNote;
        $note->shop_info_id = $request->shop_id;
        $note->note = $request->notes;
        $note->save();

        $response = [
            'message' => 'added successfully',
            'icon' => 'success',
            'title' => 'Note Added Successfully',
            'text' => 'You have successfully added a note to this shop',
            'shop' => $note,

        ];
        return response($response, 200);
    }

    public function shopInfoPublish(Request $request, $id)
    {
        $shop = ShopInfo::find($id);
        $shop->shop_status_id = 3; //verified
        $shop->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop->id;
        $shop_history_log->remarks = 'Shop ' . $shop->id . ' updated to ' . $shop->shopStatus->id . '(' . $shop->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop->updated_at));
        $shop_history_log->save();

        $response = [
            'shop' => $shop,
            'icon' => 'success',
            'title' => 'Published Successfully',
            'text' => 'You have successfully published the shop',
        ];

        return response($response, 200);
    }

    public function shopInfoAddItemCombo(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'combo' => "required",
            'cost' => "required",
            'markup' => "required",
            'item_combo_category_id' => "required"
        ]);

        switch ($request->combo_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $item_combo = new ItemCombo;
        $item_combo->item_id = $request->item_id;
        $item_combo->item_combo_category_id = $request->item_combo_category_id;
        $item_combo->combo = $request->combo;
        $item_combo->cost = (float)$request->cost;
        $item_combo->markup = (float)$markup;
        $item_combo->save();

        if ($item_combo->save()) {
            $item = Item::find($request->item_id);
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item combo ' . $item_combo->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item_combo->updated_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new item on this combo category',
            'item' => $item->load(
                'itemVariants',
                'itemComboCategories.itemCombo'
            ),
            'item_combo' => $item_combo
        ];

        return response($response, 200);
    }

    public function shopInfoAddItemComboCategory(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'combo_category' => "required",
            'is_required' => "required"
        ]);

        $combo_category = new ItemComboCategory;
        $combo_category->item_id = $request->item_id;
        $combo_category->category = $request->combo_category;
        $combo_category->is_required = $request->is_required;
        $combo_category->save();

        if ($combo_category->save()) {
            $item = Item::find($request->item_id);
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item combo category ' . $combo_category->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($combo_category->updated_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new combo category on this item',
            'item' => $item->load(
                'itemVariants',
                'itemComboCategories.itemCombo'
            ),
        ];

        return response($response, 200);
    }

    public function shopInfoApproveDecline(Request $request, $id, $status)
    {
        $shop = ShopInfo::find($id);
        switch ($status) {
            case 'approve':
                $shop->shop_status_id = 3;
                break;
            case 'decline':
                $shop->shop_status_id = 5;
                break;
            default:
                break;
        }
        $shop->save();

        $response = [
            'shop' => $shop,
            'icon' => 'success',
            'title' => 'Published Successfully',
            'text' => 'You have successfully published the shop',
        ];

        return response($response, 200);
    }

    public function shopInfoAddItemVariant(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'variant' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item = Item::find($request->item_id);

        switch ($request->variant_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $variant = new ItemVariant;
        $variant->item_id = $request->item_id;
        $variant->variant = $request->variant;
        $variant->cost = $request->cost;
        $variant->markup = $markup;
        $variant->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item variant ' . $variant->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($variant->updated_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new variant on this item',
            'item' => $item->load(
                'itemComboCategories.itemCombo',
                'itemVariants'
            ),
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItemVariant(Request $request)
    {
        $request->validate([
            'item_variant_id' => "required",
        ]);
        $item_variant = ItemVariant::find($request->item_variant_id);
        $item_variant->delete();

        $response = [
            'item_variant' => $item_variant,
            'icon' => 'warning',
            'title' => 'Deleted Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoToggleFetch(Request $request, $id)
    {
        $shop = ShopInfo::find($id);

        $response = [
            'shop' => $shop,
        ];
        return response($response, 200);
    }

    public function shopInfoAddShopHour(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
        ]);

        $shop_day = ShopDay::get();
        $shop_info = ShopInfo::find($request->shop_info_id);
        switch ($request->shop_days) {
            case 1:
                if ($request->opening == null && $request->closing == null) {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }

                for ($i=1; $i <= 7; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $request->shop_info_id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 2:
                if ($request->opening == null && $request->closing == null) {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }

                for ($i=1; $i <= 5; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $request->shop_info_id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 3:
                if ($request->monday_opening != null && $request->monday_closing != null) {
                    $mon_sh =  new ShopHour;
                    $mon_sh->shop_info_id = $request->shop_info_id;
                    $mon_sh->weekday = $shop_day->find(1)->day;
                    $mon_sh->opening = $request->monday_opening;
                    $mon_sh->closing = $request->monday_closing;
                    $mon_sh->shop_days_id = 1;
                    $mon_sh->save();
                }else if ($request->tuesday_opening != null && $request->tuesday_closing != null) {
                    $tue_sh =  new ShopHour;
                    $tue_sh->shop_info_id = $request->shop_info_id;
                    $tue_sh->weekday = $shop_day->find(2)->day;
                    $tue_sh->opening = $request->tuesday_opening;
                    $tue_sh->closing = $request->tuesday_closing;
                    $tue_sh->shop_days_id = 2;
                    $tue_sh->save();
                } else if ($request->wednesday_opening != null && $request->wednesday_closing != null) {
                    $wed_sh =  new ShopHour;
                    $wed_sh->shop_info_id = $request->shop_info_id;
                    $wed_sh->weekday = $shop_day->find(3)->day;
                    $wed_sh->opening = $request->wednesday_opening;
                    $wed_sh->closing = $request->wednesday_closing;
                    $wed_sh->shop_days_id = 3;
                    $wed_sh->save();
                }else if ($request->thursday_opening != null && $request->thursday_closing != null) {
                    $thu_sh =  new ShopHour;
                    $thu_sh->shop_info_id = $request->shop_info_id;
                    $thu_sh->weekday = $shop_day->find(4)->day;
                    $thu_sh->opening = $request->thursday_opening;
                    $thu_sh->closing = $request->thursday_closing;
                    $thu_sh->shop_days_id = 4;
                    $thu_sh->save();
                } else if ($request->friday_opening != null && $request->friday_closing != null) {
                    $fri_sh =  new ShopHour;
                    $fri_sh->shop_info_id = $request->shop_info_id;
                    $fri_sh->weekday = $shop_day->find(5)->day;
                    $fri_sh->opening = $request->friday_opening;
                    $fri_sh->closing = $request->friday_closing;
                    $fri_sh->shop_days_id = 5;
                    $fri_sh->save();
                } else if ($request->saturday_opening != null && $request->saturday_closing != null) {
                    $sat_sh =  new ShopHour;
                    $sat_sh->shop_info_id = $request->shop_info_id;
                    $sat_sh->weekday = $shop_day->find(6)->day;
                    $sat_sh->opening = $request->saturday_opening;
                    $sat_sh->closing = $request->saturday_closing;
                    $sat_sh->shop_days_id = 6;
                    $sat_sh->save();
                } else if ($request->sunday_opening != null && $request->sunday_closing != null) {
                    $sun_sh =  new ShopHour;
                    $sun_sh->shop_info_id = $request->shop_info_id;
                    $sun_sh->weekday = $shop_day->find(7)->day;
                    $sun_sh->opening = $request->sunday_opening;
                    $sun_sh->closing = $request->sunday_closing;
                    $sun_sh->shop_days_id = 7;
                    $sun_sh->save();
                } else {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }
                break;
            default:
                break;
        }

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added shop hour',
            'shop_info' => $shop_info->load('shopHour')
        ];

        return response($response, 200);
    }

    public function editShopFetch(Request $request, $id)
    {
        $shop_info = ShopInfo::find($id);
        $response = [
            'shop_info' => $shop_info
        ];
        return response($response);
    }

    public function editShop(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
            'name' => "required",
            'image' => "mimes:jpeg,jpg,png|max:1999",
            'shop_code' => "required",
        ]);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop_image', $image);
        } else {
            $image = null;
        }

        $shop_info = ShopInfo::find($request->shop_info_id);
        $shop_info->name = $request->name;
        if ($request->hasFile('image')) {
            $shop_info->image = $image;
        }
        $shop_info->shop_code = $request->shop_code;
        $shop_info->save();

        $response = [
            'shop_info' => $shop_info,
            'icon' => 'success',
            'title' => 'Updated Successfully',
            'text' => 'You have successfully updated this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemComboFetch(Request $request, $id)
    {
        $item_combo = ItemCombo::find($id);
        $response = [
            'item_combo' => $item_combo
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemCombo(Request $request)
    {
        $request->validate([
            'item_combo_id' => "required",
            'combo' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item_combo = ItemCombo::find($request->item_combo_id);
        $item_combo->combo = $request->combo;
        $item_combo->cost = $request->cost;
        $item_combo->markup = $request->markup;
        $item_combo->save();

        $response = [
            'item_combo' => $item_combo,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItemCombo(Request $request)
    {
        $request->validate([
            'item_combo_id' => "required",
        ]);
        $item_combo = ItemCombo::find($request->item_combo_id);
        $item_combo->delete();

        $response = [
            'item_combo' => $item_combo,
            'icon' => 'warning',
            'title' => 'Deleted Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemFetch(Request $request, $id)
    {
        $item = Item::find($id);
        $response = [
            'item' => $item
        ];

        return response($response);
    }

    public function shopInfoEditItem(Request $request)
    {
        $request->validate([
            'name' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item = Item::find($request->item_id);
        $item->name = $request->name;
        $item->cost = $request->cost;
        $item->markup = $request->markup;
        $item->save();

        $response = [
            'item' => $item,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItem(Request $request)
    {
        $request->validate([
            'item_id' => "required",
        ]);

        $item = Item::find($request->item_id);
        $item->delete();

        $response = [
            'item' => $item,
            'icon' => 'warning',
            'title' => 'Delete Successfully',
            'text' => 'You have successfully delete this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemVariantFetch(Request $request, $id)
    {
        $item_variant = itemVariant::find($id);

        $response = [
            'item_variant' => $item_variant
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemVariant(Request $request)
    {
        $request->validate([
            'item_variant_id' => "required",
            'variant' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item_variant = ItemVariant::find($request->item_variant_id);
        $item_variant->variant = $request->variant;
        $item_variant->cost = $request->cost;
        $item_variant->markup = $request->markup;
        $item_variant->save();

        $response = [
            'item_variant' => $item_variant,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this item variant',
        ];

        return response($response, 200);
    }

    public function shopInfoEditShopImage(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        $shop_info = ShopInfo::find($request->shop_info_id);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop_image', $image);
        } else {
            $image = null;
        }

        $shop_info->image = $image;
        $shop_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Successfully',
            'text' => 'You have successfully updated the shop image',
            'shop_info' => $shop_info
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemImage(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        $item = Item::find($request->item_id);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/item_image', $image);
        } else {
            $image = null;
        }

        $item->image = $image;
        $item->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Successfully',
            'text' => 'You have successfully updated the shop image',
            'item' => $item
        ];

        return response($response, 200);
    }
}
