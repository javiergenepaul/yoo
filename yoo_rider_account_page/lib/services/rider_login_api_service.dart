import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';

class APIService {
  Future<LoginResponseModel> login(LoginRequestModel requestModel) async {
    String url = "https://yoo.ph/api/driver/login";
    final response = await http.post(
      Uri.parse(url),
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
}
