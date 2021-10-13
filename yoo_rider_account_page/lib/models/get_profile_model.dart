// To parse this JSON data, do
//
//     final getProfile = getProfileFromJson(jsonString);

import 'dart:convert';

GetProfileModel getProfileFromJson(String str) =>
    GetProfileModel.fromJson(json.decode(str));

String getProfileToJson(GetProfileModel data) => json.encode(data.toJson());

class GetProfileModel {
  GetProfileModel({
    required this.message,
    required this.user,
  });

  String message;
  User user;

  factory GetProfileModel.fromJson(Map<String, dynamic> json) =>
      GetProfileModel(
        message: json["message"],
        user: User.fromJson(json["user"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "user": user.toJson(),
      };
}

class User {
  User({
    required this.id,
    required this.email,
    required this.mobileNumber,
    this.emailVerifiedAt,
    required this.createdAt,
    required this.updatedAt,
    required this.userInfo,
    required this.driver,
  });

  int id;
  String email;
  String mobileNumber;
  dynamic emailVerifiedAt;
  DateTime createdAt;
  DateTime updatedAt;
  UserInfo userInfo;
  Driver driver;

  factory User.fromJson(Map<String, dynamic> json) => User(
        id: json["id"],
        email: json["email"],
        mobileNumber: json["mobile_number"],
        emailVerifiedAt: json["email_verified_at"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        userInfo: UserInfo.fromJson(json["user_info"]),
        driver: Driver.fromJson(json["driver"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "email": email,
        "mobile_number": mobileNumber,
        "email_verified_at": emailVerifiedAt,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "user_info": userInfo.toJson(),
        "driver": driver.toJson(),
      };
}

class Driver {
  Driver({
    required this.id,
    required this.userId,
    this.city,
    this.drivingLicenseNumber,
    this.drivingLicenseExpiry,
    this.driverLicenseImage,
    this.vehicleBrand,
    this.vehicleModel,
    this.vehicleManufactureYear,
    this.licensePlateNumber,
    this.nbiClearance,
    this.deedOfSale,
    this.vehicleRegistration,
    this.vehicleFront,
    this.vehicleSide,
    this.vehicleBack,
    this.driverRating,
    required this.status,
    this.numberOfFans,
    this.vaxCertificate,
    required this.createdAt,
    required this.updatedAt,
    required this.verificationStatusId,
    this.vehicleId,
    required this.verificationStatus,
  });

  int id;
  int userId;
  dynamic city;
  dynamic drivingLicenseNumber;
  dynamic drivingLicenseExpiry;
  dynamic driverLicenseImage;
  dynamic vehicleBrand;
  dynamic vehicleModel;
  dynamic vehicleManufactureYear;
  dynamic licensePlateNumber;
  dynamic nbiClearance;
  dynamic deedOfSale;
  dynamic vehicleRegistration;
  dynamic vehicleFront;
  dynamic vehicleSide;
  dynamic vehicleBack;
  dynamic driverRating;
  int status;
  dynamic numberOfFans;
  dynamic vaxCertificate;
  DateTime createdAt;
  DateTime updatedAt;
  int verificationStatusId;
  dynamic vehicleId;
  VerificationStatus verificationStatus;

  factory Driver.fromJson(Map<String, dynamic> json) => Driver(
        id: json["id"],
        userId: json["user_id"],
        city: json["city"] == null ? '' : json["city"],
        drivingLicenseNumber: json["driving_license_number"],
        drivingLicenseExpiry: json["driving_license_expiry"],
        driverLicenseImage: json["driver_license_image"],
        vehicleBrand: json["vehicle_brand"],
        vehicleModel: json["vehicle_model"],
        vehicleManufactureYear: json["vehicle_manufacture_year"],
        licensePlateNumber: json["license_plate_number"],
        nbiClearance: json["nbi_clearance"],
        deedOfSale: json["deed_of_sale"],
        vehicleRegistration: json["vehicle_registration"],
        vehicleFront: json["vehicle_front"],
        vehicleSide: json["vehicle_side"],
        vehicleBack: json["vehicle_back"],
        driverRating: json["driver_rating"],
        status: json["status"],
        numberOfFans:
            json["number_of_fans"] == null ? 0 : json["number_of_fans"],
        vaxCertificate: json["vax_certificate"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        verificationStatusId: json["verification_status_id"],
        vehicleId: json["vehicle_id"],
        verificationStatus:
            VerificationStatus.fromJson(json["verification_status"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "user_id": userId,
        "city": city == null ? "" : city,
        "driving_license_number": drivingLicenseNumber,
        "driving_license_expiry": drivingLicenseExpiry,
        "driver_license_image": driverLicenseImage,
        "vehicle_brand": vehicleBrand,
        "vehicle_model": vehicleModel,
        "vehicle_manufacture_year": vehicleManufactureYear,
        "license_plate_number": licensePlateNumber,
        "nbi_clearance": nbiClearance,
        "deed_of_sale": deedOfSale,
        "vehicle_registration": vehicleRegistration,
        "vehicle_front": vehicleFront,
        "vehicle_side": vehicleSide,
        "vehicle_back": vehicleBack,
        "driver_rating": driverRating,
        "status": status,
        "number_of_fans": numberOfFans == null ? 0 : numberOfFans,
        "vax_certificate": vaxCertificate,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "verification_status_id": verificationStatusId,
        "vehicle_id": vehicleId,
        "verification_status": verificationStatus.toJson(),
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

class UserInfo {
  UserInfo({
    required this.id,
    required this.userId,
    required this.firstName,
    required this.lastName,
    required this.dateOfBirth,
    this.profilePicture,
    required this.createdAt,
    required this.updatedAt,
    this.middleName,
    this.country,
    this.province,
    this.cityMunicipality,
    this.postalCode,
    this.barangay,
    this.address,
  });

  int id;
  int userId;
  String firstName;
  String lastName;
  DateTime dateOfBirth;
  dynamic profilePicture;
  DateTime createdAt;
  DateTime updatedAt;
  dynamic middleName;
  dynamic country;
  dynamic province;
  dynamic cityMunicipality;
  dynamic postalCode;
  dynamic barangay;
  dynamic address;

  factory UserInfo.fromJson(Map<String, dynamic> json) => UserInfo(
        id: json["id"],
        userId: json["user_id"],
        firstName: json["first_name"],
        lastName: json["last_name"],
        dateOfBirth: DateTime.parse(json["date_of_birth"]),
        profilePicture: json["profile_picture"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        middleName: json["middle_name"],
        country: json["country"],
        province: json["province"],
        cityMunicipality: json["city_municipality"],
        postalCode: json["postal_code"],
        barangay: json["barangay"],
        address: json["address"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "user_id": userId,
        "first_name": firstName,
        "last_name": lastName,
        "date_of_birth":
            "${dateOfBirth.year.toString().padLeft(4, '0')}-${dateOfBirth.month.toString().padLeft(2, '0')}-${dateOfBirth.day.toString().padLeft(2, '0')}",
        "profile_picture": profilePicture,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "middle_name": middleName,
        "country": country,
        "province": province,
        "city_municipality": cityMunicipality,
        "postal_code": postalCode,
        "barangay": barangay,
        "address": address,
      };
}
