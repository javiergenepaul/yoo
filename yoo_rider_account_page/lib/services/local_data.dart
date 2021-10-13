import 'dart:convert';

import 'package:shared_preferences/shared_preferences.dart';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/services/api_service.dart';

const RiderData = "RiderData";
const DriverToken = "DriverToken";
String? cachedData;
String? cachedToken;

class LocalDataResources {
  Future<void> cacheUserAndToken() async {
    // final RiderCache =
    //     LoginResponseModel(message: '', user: user, token: token);
    final SharedPreferences prefs = await SharedPreferences.getInstance();

    // prefs.setString(RiderData, json.encode(RiderCache.token));
    // prefs.setString(RiderData, json.encode(RiderCache.user));
    // prefs.setString(DriverToken, json.encode(RiderCache.token));
  }

  Future<String> getCache() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    // cachedData = prefs.getString(RiderData);
    cachedData = prefs.getString(RiderData);
    cachedToken = prefs.getString(DriverToken);
    return cachedToken.toString();
  }
}
