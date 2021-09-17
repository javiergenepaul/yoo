import 'dart:convert';

// To parse this JSON data, do
//
//     final loginResponseModel = loginResponseModelFromJson(jsonString);

LoginResponseModel loginResponseModelFromJson(String str) =>
    LoginResponseModel.fromJson(json.decode(str));

String loginResponseModelToJson(LoginResponseModel data) =>
    json.encode(data.toJson());

class LoginResponseModel {
  LoginResponseModel({
    required this.message,
    required this.driver,
    required this.token,
  });

  String message;
  Driver driver;
  String token;

  factory LoginResponseModel.fromJson(Map<String, dynamic> json) =>
      LoginResponseModel(
        message: json["message"],
        driver: Driver.fromJson(json["driver"]),
        token: json["token"],
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "driver": driver.toJson(),
        "token": token,
      };
}

class Driver {
  Driver({
    required this.id,
    required this.name,
    required this.mobileNumber,
    this.email,
    this.emailVerifiedAt,
    required this.city,
    required this.vehicleType,
    this.dateOfBirth,
    this.drivingLicenseNumber,
    this.drivingLicenseExpiry,
    this.driverLicenseImage,
    this.vehicleBrand,
    this.vehicleModel,
    this.vehicleManufactureYear,
    this.licensePlateNumber,
    this.trainingCompleted,
    this.nbiClearance,
    this.portrait,
    this.deedOfSale,
    this.vehicleRegistration,
    this.vehicleFront,
    this.vehicleSide,
    this.vehicleBack,
    required this.password,
    this.status,
    this.orderStatus,
    this.orderGoalsPerDay,
    this.incomeGoalsPerDay,
    this.promptForTarget,
    this.rating,
    this.numberOfFans,
    required this.createdAt,
    required this.updatedAt,
    required this.verificationStatusId,
  });

  int id;
  String name;
  String mobileNumber;
  dynamic email;
  dynamic emailVerifiedAt;
  String city;
  String vehicleType;
  dynamic dateOfBirth;
  dynamic drivingLicenseNumber;
  dynamic drivingLicenseExpiry;
  dynamic driverLicenseImage;
  dynamic vehicleBrand;
  dynamic vehicleModel;
  dynamic vehicleManufactureYear;
  dynamic licensePlateNumber;
  dynamic trainingCompleted;
  dynamic nbiClearance;
  dynamic portrait;
  dynamic deedOfSale;
  dynamic vehicleRegistration;
  dynamic vehicleFront;
  dynamic vehicleSide;
  dynamic vehicleBack;
  String password;
  dynamic status;
  dynamic orderStatus;
  dynamic orderGoalsPerDay;
  dynamic incomeGoalsPerDay;
  dynamic promptForTarget;
  dynamic rating;
  dynamic numberOfFans;
  DateTime createdAt;
  DateTime updatedAt;
  int verificationStatusId;

  factory Driver.fromJson(Map<String, dynamic> json) => Driver(
        id: json["id"],
        name: json["name"],
        mobileNumber: json["mobile_number"],
        email: json["email"],
        emailVerifiedAt: json["email_verified_at"],
        city: json["city"],
        vehicleType: json["vehicle_type"],
        dateOfBirth: json["date_of_birth"],
        drivingLicenseNumber: json["driving_license_number"],
        drivingLicenseExpiry: json["driving_license_expiry"],
        driverLicenseImage: json["driver_license_image"],
        vehicleBrand: json["vehicle_brand"],
        vehicleModel: json["vehicle_model"],
        vehicleManufactureYear: json["vehicle_manufacture_year"],
        licensePlateNumber: json["license_plate_number"],
        trainingCompleted: json["training_completed"],
        nbiClearance: json["nbi_clearance"],
        portrait: json["portrait"],
        deedOfSale: json["deed_of_sale"],
        vehicleRegistration: json["vehicle_registration"],
        vehicleFront: json["vehicle_front"],
        vehicleSide: json["vehicle_side"],
        vehicleBack: json["vehicle_back"],
        password: json["password"],
        status: json["status"],
        orderStatus: json["order_status"],
        orderGoalsPerDay: json["order_goals_per_day"],
        incomeGoalsPerDay: json["income_goals_per_day"],
        promptForTarget: json["prompt_for_target"],
        rating: json["rating"],
        numberOfFans: json["number_of_fans"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        verificationStatusId: json["verification_status_id"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "mobile_number": mobileNumber,
        "email": email,
        "email_verified_at": emailVerifiedAt,
        "city": city,
        "vehicle_type": vehicleType,
        "date_of_birth": dateOfBirth,
        "driving_license_number": drivingLicenseNumber,
        "driving_license_expiry": drivingLicenseExpiry,
        "driver_license_image": driverLicenseImage,
        "vehicle_brand": vehicleBrand,
        "vehicle_model": vehicleModel,
        "vehicle_manufacture_year": vehicleManufactureYear,
        "license_plate_number": licensePlateNumber,
        "training_completed": trainingCompleted,
        "nbi_clearance": nbiClearance,
        "portrait": portrait,
        "deed_of_sale": deedOfSale,
        "vehicle_registration": vehicleRegistration,
        "vehicle_front": vehicleFront,
        "vehicle_side": vehicleSide,
        "vehicle_back": vehicleBack,
        "password": password,
        "status": status,
        "order_status": orderStatus,
        "order_goals_per_day": orderGoalsPerDay,
        "income_goals_per_day": incomeGoalsPerDay,
        "prompt_for_target": promptForTarget,
        "rating": rating,
        "number_of_fans": numberOfFans,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "verification_status_id": verificationStatusId,
      };
}

// class LoginResponseModel {
//   final String token;
//   final String error;

//   LoginResponseModel({required this.token, required this.error});

//   factory LoginResponseModel.fromJson(Map<String, dynamic> json) {
//     return LoginResponseModel(
//         token: json['token'] != null ? json['token'] : '',
//         error: json['error'] != null ? json['error'] : '');
//   }
// }

LoginRequestModel loginRequestModelFromJson(String str) =>
    LoginRequestModel.fromJson(json.decode(str));

String loginRequestModelToJson(LoginRequestModel data) =>
    json.encode(data.toJson());

class LoginRequestModel {
  LoginRequestModel({
    required this.mobileNumber,
    required this.password,
  });

  String mobileNumber;
  String password;

  factory LoginRequestModel.fromJson(Map<String, dynamic> json) =>
      LoginRequestModel(
        mobileNumber: json["mobile_number"],
        password: json["password"],
      );

  Map<String, dynamic> toJson() => {
        "mobile_number": mobileNumber,
        "password": password,
      };
}



// class LoginRequestModel {
//   String mobileNumber;
//   String password;

//   LoginRequestModel({required this.mobileNumber, required this.password});

//   Map<String, dynamic> toJson() {
//     Map<String, dynamic> map = {
//       'mobile_bumber': mobileNumber.trim(),
//       'password': password.trim()
//     };
//     return map;
//   }
// }
