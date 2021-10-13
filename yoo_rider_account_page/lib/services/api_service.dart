import 'package:http/http.dart' as http;
import 'package:yoo_rider_account_page/models/active_order_model.dart';
import 'package:yoo_rider_account_page/models/get_profile_model.dart';
import 'package:yoo_rider_account_page/models/profile_update_model.dart';
import 'dart:convert';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/services/api_constants.dart';

class APIService {
  Future<LoginResponseModel> login(LoginRequestModel requestModel) async {
    String url = base_url + login_rider;
    final response = await http.post(
      Uri.parse(url),
      headers: requestHeaders,
      body: requestModel.toJson(),
    );

    if (response.statusCode == 200 || response.statusCode == 400) {
      return LoginResponseModel.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load Data');
    }
  }

  Future<OrderModel> getOrders() async {
    String url = base_url + get_order;
    final response = await http.get(Uri.parse(url), headers: driverHeaders);
    if (response.statusCode == 200) {
      var jsonData = jsonDecode(response.body);
      print(response.statusCode);
      return orderModelFromJson(response.body);
    } else {
      print(response.statusCode);
      throw Exception('Failed to load data!');
    }
  }

  Future<GetProfileModel> getProfile() async {
    String url = base_url + get_profile;
    final response = await http.get(Uri.parse(url), headers: driverHeaders);
    if (response.statusCode == 200) {
      var jsonData = jsonDecode(response.body);
      print(response.statusCode);
      return getProfileFromJson(response.body);
    } else {
      print(response.statusCode);
      throw Exception('Failed to load data!');
    }
  }

  Future<ProfileUpdateResponse> updateProfile(
      ProfileUpdateRequest profileUpdateRequest) async {
    String url = base_url + update_profile;
    final response = await http.post(
      Uri.parse(url),
      headers: driverHeaders,
      body: profileUpdateRequest.toJson(),
    );
    if (response.statusCode == 200) {
      var jsonData = jsonDecode(response.body);
      print(response.statusCode);
      return ProfileUpdateResponse.fromJson(jsonDecode(response.body));
    } else {
      print(response.statusCode);
      throw Exception('Failed to load data!');
    }
  }
}
