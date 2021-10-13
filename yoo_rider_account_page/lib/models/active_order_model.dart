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
    required this.totalOrders,
    required this.orders,
  });

  String message;
  int totalOrders;
  List<Order> orders;

  factory OrderModel.fromJson(Map<String, dynamic> json) => OrderModel(
        message: json["message"],
        totalOrders: json["total_orders"],
        orders: List<Order>.from(json["orders"].map((x) => Order.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "total_orders": totalOrders,
        "orders": List<dynamic>.from(orders.map((x) => x.toJson())),
      };
}

class Order {
  Order({
    required this.id,
    this.driverId,
    required this.completedDatetime,
    required this.orderStatusId,
    required this.totalMileage,
    required this.instruction,
    required this.paymentMethodId,
    required this.totalAmount,
    required this.totalPaid,
    required this.totalDue,
    required this.holiday,
    required this.highDemand,
    required this.createdAt,
    required this.updatedAt,
    required this.areaId,
    required this.customerId,
    required this.vehicleId,
    required this.orderStatus,
    required this.vehicle,
    required this.area,
    required this.pickupInfo,
    required this.dropoffLocations,
  });

  int id;
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
  int areaId;
  int customerId;
  int vehicleId;
  Area orderStatus;
  Vehicle vehicle;
  Area area;
  PickupInfo pickupInfo;
  List<DropoffLocation> dropoffLocations;

  factory Order.fromJson(Map<String, dynamic> json) => Order(
        id: json["id"],
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
        areaId: json["area_id"],
        customerId: json["customer_id"],
        vehicleId: json["vehicle_id"],
        orderStatus: Area.fromJson(json["order_status"]),
        vehicle: Vehicle.fromJson(json["vehicle"]),
        area: Area.fromJson(json["area"]),
        pickupInfo: PickupInfo.fromJson(json["pickup_info"]),
        dropoffLocations: List<DropoffLocation>.from(
            json["dropoff_locations"].map((x) => DropoffLocation.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
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
        "area_id": areaId,
        "customer_id": customerId,
        "vehicle_id": vehicleId,
        "order_status": orderStatus.toJson(),
        "vehicle": vehicle.toJson(),
        "area": area.toJson(),
        "pickup_info": pickupInfo.toJson(),
        "dropoff_locations":
            List<dynamic>.from(dropoffLocations.map((x) => x.toJson())),
      };
}

class Area {
  Area({
    required this.id,
    required this.description,
    required this.createdAt,
    required this.updatedAt,
    required this.type,
    required this.status,
  });

  int id;
  String description;
  DateTime createdAt;
  DateTime updatedAt;
  String type;
  String status;

  factory Area.fromJson(Map<String, dynamic> json) => Area(
        id: json["id"],
        description: json["description"] == null ? '' : json["description"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        type: json["type"] == null ? '' : json["type"],
        status: json["status"] == null ? '' : json["status"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "description": description == null ? '' : description,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "type": type == null ? '' : type,
        "status": status == null ? '' : status,
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
    required this.itemType,
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
  Area itemType;

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
        itemType: Area.fromJson(json["item_type"]),
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
        "item_type": itemType.toJson(),
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

class Vehicle {
  Vehicle({
    required this.id,
    required this.type,
    required this.maxWeightKg,
    required this.createdAt,
    required this.updatedAt,
    required this.vehicleDimension,
  });

  int id;
  String type;
  int maxWeightKg;
  DateTime createdAt;
  DateTime updatedAt;
  VehicleDimension vehicleDimension;

  factory Vehicle.fromJson(Map<String, dynamic> json) => Vehicle(
        id: json["id"],
        type: json["type"],
        maxWeightKg: json["max_weight_kg"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        vehicleDimension: VehicleDimension.fromJson(json["vehicle_dimension"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "type": type,
        "max_weight_kg": maxWeightKg,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "vehicle_dimension": vehicleDimension.toJson(),
      };
}

class VehicleDimension {
  VehicleDimension({
    required this.id,
    required this.vehicleId,
    required this.lengthFt,
    required this.widthFt,
    required this.heightFt,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  int vehicleId;
  double lengthFt;
  double widthFt;
  double heightFt;
  DateTime createdAt;
  DateTime updatedAt;

  factory VehicleDimension.fromJson(Map<String, dynamic> json) =>
      VehicleDimension(
        id: json["id"],
        vehicleId: json["vehicle_id"],
        lengthFt: json["length_ft"].toDouble(),
        widthFt: json["width_ft"].toDouble(),
        heightFt: json["height_ft"].toDouble(),
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "vehicle_id": vehicleId,
        "length_ft": lengthFt,
        "width_ft": widthFt,
        "height_ft": heightFt,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
