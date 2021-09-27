import 'package:http/http.dart' as http;
import 'package:yoo_rider_account_page/models/active_order_model.dart';
import 'dart:convert';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/services/api_constants.dart';

class APIService {
  Future<LoginResponseModel> login(LoginRequestModel requestModel) async {
    String url = base_url + login_rider;
    final response = await http.post(
      Uri.parse(url),
      headers: requestHeaders,
      // headers: {
      //   "Content-Type": "application/json",
      //   "Accept": "application/json"
      // },
      body: requestModel.toJson(),
    );

    if (response.statusCode == 200 || response.statusCode == 400) {
      return LoginResponseModel.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load Data');
    }
  }

  Future<OrderModel> getOrders() async {
    String url = base_url + create_order;

    final response = await http.get(Uri.parse(url), headers: requestHeaders);
    if (response.statusCode == 200 || response.statusCode == 400) {
      return OrderModel.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load data!');
    }
  }

  Future<Order> getOrderDetails() async {
    String url = base_url + create_order;

    final response = await http.get(Uri.parse(url), headers: requestHeaders);
    if (response.statusCode == 200 || response.statusCode == 400) {
      return Order.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load data!');
    }
  }

  Future<DropoffLocation> getDropOff() async {
    String url = base_url + create_order;

    final response = await http.get(Uri.parse(url), headers: requestHeaders);
    if (response.statusCode == 200 || response.statusCode == 400) {
      return DropoffLocation.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load data!');
    }
  }

  Future<PickupInfo> getPickUp() async {
    String url = base_url + create_order;

    final response = await http.get(Uri.parse(url), headers: requestHeaders);
    if (response.statusCode == 200 || response.statusCode == 400) {
      return PickupInfo.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load data!');
    }
  }
}
