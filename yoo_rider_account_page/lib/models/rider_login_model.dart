import 'dart:convert';

// To parse this JSON data, do
//
//     final loginResponseModel = loginResponseModelFromJson(jsonString);

import 'dart:convert';

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
    required this.mobileNumber,
    required this.password,
    required this.createdAt,
    required this.updatedAt,
    required this.verificationStatusId,
    required this.driverInfo,
    required this.verificationStatus,
  });

  int id;
  String mobileNumber;
  String password;
  DateTime createdAt;
  DateTime updatedAt;
  int verificationStatusId;
  DriverInfo driverInfo;
  VerificationStatus verificationStatus;

  factory Driver.fromJson(Map<String, dynamic> json) => Driver(
        id: json["id"],
        mobileNumber: json["mobile_number"],
        password: json["password"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        verificationStatusId: json["verification_status_id"],
        driverInfo: DriverInfo.fromJson(json["driver_info"]),
        verificationStatus:
            VerificationStatus.fromJson(json["verification_status"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "mobile_number": mobileNumber,
        "password": password,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "verification_status_id": verificationStatusId,
        "driver_info": driverInfo.toJson(),
        "verification_status": verificationStatus.toJson(),
      };
}

class DriverInfo {
  DriverInfo({
    required this.id,
    required this.driverId,
    required this.firstName,
    required this.lastName,
    this.email,
    required this.city,
    required this.drivingLicenseNumber,
    required this.drivingLicenseExpiry,
    this.driverLicenseImage,
    required this.dateOfBirth,
    this.vehicleId,
    required this.vehicleBrand,
    required this.vehicleModel,
    required this.vehicleManufactureYear,
    required this.licensePlateNumber,
    this.nbiClearance,
    this.portrait,
    this.deedOfSale,
    this.vehicleRegistration,
    this.vehicleFront,
    this.vehicleSide,
    this.vehicleBack,
    required this.status,
    this.orderGoalsPerDay,
    this.incomeGoalsPerDay,
    this.promptForTarget,
    this.numberOfFans,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  int driverId;
  String firstName;
  String lastName;
  dynamic email;
  String city;
  String drivingLicenseNumber;
  DateTime drivingLicenseExpiry;
  dynamic driverLicenseImage;
  DateTime dateOfBirth;
  dynamic vehicleId;
  String vehicleBrand;
  String vehicleModel;
  String vehicleManufactureYear;
  String licensePlateNumber;
  dynamic nbiClearance;
  dynamic portrait;
  dynamic deedOfSale;
  dynamic vehicleRegistration;
  dynamic vehicleFront;
  dynamic vehicleSide;
  dynamic vehicleBack;
  int status;
  dynamic orderGoalsPerDay;
  dynamic incomeGoalsPerDay;
  dynamic promptForTarget;
  dynamic numberOfFans;
  DateTime createdAt;
  DateTime updatedAt;

  factory DriverInfo.fromJson(Map<String, dynamic> json) => DriverInfo(
        id: json["id"],
        driverId: json["driver_id"],
        firstName: json["first_name"],
        lastName: json["last_name"],
        email: json["email"],
        city: json["city"],
        drivingLicenseNumber: json["driving_license_number"],
        drivingLicenseExpiry: DateTime.parse(json["driving_license_expiry"]),
        driverLicenseImage: json["driver_license_image"],
        dateOfBirth: DateTime.parse(json["date_of_birth"]),
        vehicleId: json["vehicle_id"],
        vehicleBrand: json["vehicle_brand"],
        vehicleModel: json["vehicle_model"],
        vehicleManufactureYear: json["vehicle_manufacture_year"],
        licensePlateNumber: json["license_plate_number"],
        nbiClearance: json["nbi_clearance"],
        portrait: json["portrait"],
        deedOfSale: json["deed_of_sale"],
        vehicleRegistration: json["vehicle_registration"],
        vehicleFront: json["vehicle_front"],
        vehicleSide: json["vehicle_side"],
        vehicleBack: json["vehicle_back"],
        status: json["status"],
        orderGoalsPerDay: json["order_goals_per_day"],
        incomeGoalsPerDay: json["income_goals_per_day"],
        promptForTarget: json["prompt_for_target"],
        numberOfFans: json["number_of_fans"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "driver_id": driverId,
        "first_name": firstName,
        "last_name": lastName,
        "email": email,
        "city": city,
        "driving_license_number": drivingLicenseNumber,
        "driving_license_expiry":
            "${drivingLicenseExpiry.year.toString().padLeft(4, '0')}-${drivingLicenseExpiry.month.toString().padLeft(2, '0')}-${drivingLicenseExpiry.day.toString().padLeft(2, '0')}",
        "driver_license_image": driverLicenseImage,
        "date_of_birth":
            "${dateOfBirth.year.toString().padLeft(4, '0')}-${dateOfBirth.month.toString().padLeft(2, '0')}-${dateOfBirth.day.toString().padLeft(2, '0')}",
        "vehicle_id": vehicleId,
        "vehicle_brand": vehicleBrand,
        "vehicle_model": vehicleModel,
        "vehicle_manufacture_year": vehicleManufactureYear,
        "license_plate_number": licensePlateNumber,
        "nbi_clearance": nbiClearance,
        "portrait": portrait,
        "deed_of_sale": deedOfSale,
        "vehicle_registration": vehicleRegistration,
        "vehicle_front": vehicleFront,
        "vehicle_side": vehicleSide,
        "vehicle_back": vehicleBack,
        "status": status,
        "order_goals_per_day": orderGoalsPerDay,
        "income_goals_per_day": incomeGoalsPerDay,
        "prompt_for_target": promptForTarget,
        "number_of_fans": numberOfFans,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}

class VerificationStatus {
  VerificationStatus({
    required this.id,
    required this.status,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  String status;
  DateTime createdAt;
  DateTime updatedAt;

  factory VerificationStatus.fromJson(Map<String, dynamic> json) =>
      VerificationStatus(
        id: json["id"],
        status: json["status"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "status": status,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
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
