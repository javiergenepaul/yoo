// To parse this JSON data, do
//
//     final orderModel = orderModelFromJson(jsonString);

import 'dart:convert';

OrderModel orderModelFromJson(String str) =>
    OrderModel.fromJson(json.decode(str));

String orderModelToJson(OrderModel data) => json.encode(data.toJson());

class OrderModel {
  OrderModel({
    required this.message,
    required this.orders,
  });

  String message;
  List<Order> orders;

  factory OrderModel.fromJson(Map<String, dynamic> json) => OrderModel(
        message: json["message"],
        orders: List<Order>.from(json["orders"].map((x) => Order.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "orders": List<dynamic>.from(orders.map((x) => x.toJson())),
      };
}

class Order {
  Order({
    required this.id,
    required this.userId,
    this.driverId,
    this.completedDatetime,
    required this.orderStatusId,
    required this.totalMileage,
    this.instruction,
    required this.paymentMethodId,
    required this.totalAmount,
    required this.totalPaid,
    required this.totalDue,
    required this.holiday,
    required this.highDemand,
    required this.createdAt,
    required this.updatedAt,
    required this.orderProvinceId,
    required this.pickupInfo,
    required this.dropoffLocations,
  });

  int id;
  int userId;
  dynamic driverId;
  dynamic completedDatetime;
  int orderStatusId;
  int totalMileage;
  dynamic instruction;
  int paymentMethodId;
  int totalAmount;
  int totalPaid;
  int totalDue;
  int holiday;
  int highDemand;
  DateTime createdAt;
  DateTime updatedAt;
  int orderProvinceId;
  PickupInfo pickupInfo;
  List<DropoffLocation> dropoffLocations;

  factory Order.fromJson(Map<String, dynamic> json) => Order(
        id: json["id"],
        userId: json["user_id"],
        driverId: json["driver_id"],
        completedDatetime: json["completed_datetime"],
        orderStatusId: json["order_status_id"],
        totalMileage: json["total_mileage"],
        instruction: json["instruction"],
        paymentMethodId: json["payment_method_id"],
        totalAmount: json["total_amount"],
        totalPaid: json["total_paid"],
        totalDue: json["total_due"],
        holiday: json["holiday"],
        highDemand: json["high_demand"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        orderProvinceId: json["order_province_id"],
        pickupInfo: PickupInfo.fromJson(json["pickup_info"]),
        dropoffLocations: List<DropoffLocation>.from(
            json["dropoff_locations"].map((x) => DropoffLocation.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "user_id": userId,
        "driver_id": driverId,
        "completed_datetime": completedDatetime,
        "order_status_id": orderStatusId,
        "total_mileage": totalMileage,
        "instruction": instruction,
        "payment_method_id": paymentMethodId,
        "total_amount": totalAmount,
        "total_paid": totalPaid,
        "total_due": totalDue,
        "holiday": holiday,
        "high_demand": highDemand,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "order_province_id": orderProvinceId,
        "pickup_info": pickupInfo.toJson(),
        "dropoff_locations":
            List<dynamic>.from(dropoffLocations.map((x) => x.toJson())),
      };
}

class DropoffLocation {
  DropoffLocation({
    required this.id,
    required this.orderId,
    required this.longitude,
    required this.latitude,
    required this.name,
    required this.contact,
    required this.address,
    required this.instruction,
    required this.itemTypeId,
    required this.createdAt,
    required this.updatedAt,
    required this.mileage,
    required this.landmark,
  });

  int id;
  int orderId;
  String longitude;
  String latitude;
  String name;
  String contact;
  String address;
  String instruction;
  int itemTypeId;
  DateTime createdAt;
  DateTime updatedAt;
  int mileage;
  String landmark;

  factory DropoffLocation.fromJson(Map<String, dynamic> json) =>
      DropoffLocation(
        id: json["id"],
        orderId: json["order_id"],
        longitude: json["longitude"],
        latitude: json["latitude"],
        name: json["name"],
        contact: json["contact"],
        address: json["address"],
        instruction: json["instruction"],
        itemTypeId: json["item_type_id"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        mileage: json["mileage"],
        landmark: json["landmark"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "order_id": orderId,
        "longitude": longitude,
        "latitude": latitude,
        "name": name,
        "contact": contact,
        "address": address,
        "instruction": instruction,
        "item_type_id": itemTypeId,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "mileage": mileage,
        "landmark": landmark,
      };
}

class PickupInfo {
  PickupInfo({
    required this.id,
    required this.orderId,
    required this.address,
    required this.longitude,
    required this.latitude,
    required this.time,
    required this.date,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  int orderId;
  String address;
  String longitude;
  String latitude;
  String time;
  DateTime date;
  DateTime createdAt;
  DateTime updatedAt;

  factory PickupInfo.fromJson(Map<String, dynamic> json) => PickupInfo(
        id: json["id"],
        orderId: json["order_id"],
        address: json["address"],
        longitude: json["longitude"],
        latitude: json["latitude"],
        time: json["time"],
        date: DateTime.parse(json["date"]),
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "order_id": orderId,
        "address": address,
        "longitude": longitude,
        "latitude": latitude,
        "time": time,
        "date":
            "${date.year.toString().padLeft(4, '0')}-${date.month.toString().padLeft(2, '0')}-${date.day.toString().padLeft(2, '0')}",
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
