import 'dart:convert';

import 'package:shared_preferences/shared_preferences.dart';
import 'package:yoo_rider_account_page/models/notification_model.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';

var ordermodel = [
  OrderModel(
    ongoing: sampleOngoingOrder,
    completed: sampleCompletedOrder,
    cancelled: sampleCancelledOrder,
  )
];

var sampleOrder = [
  Cancelled(
      TransactionID: "1234-56789",
      Schedule: "07/07/21 ",
      Time: "2:12 PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Motorcycle",
      Rate: 160.50,
      DateCancelled: '08/07/2021',
      TimeCancelled: '1:36 PM',
      Reason: 'Wrong Location'),
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/07/21 ",
      Time: "2:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Motorcycle",
      Rate: 141.50),
];

final List<Cancelled> sampleCancelledOrder = [
  Cancelled(
    TransactionID: "1234-56789",
    Schedule: "07/07/21 ",
    Time: "2:12 PM",
    Pickup: "Pickup",
    DropOff: "Drop Off",
    Vehicle: "Motorcycle",
    Rate: 160.50,
    DateCancelled: '08/07/2021',
    TimeCancelled: '1:36 PM',
    Reason: 'Wrong Location',
  ),
  Cancelled(
    TransactionID: "1234-56789",
    Schedule: "07/07/21 ",
    Time: "2:12 PM",
    Pickup: "Pickup",
    DropOff: "Drop Off",
    Vehicle: "Motorcycle",
    Rate: 160.50,
    DateCancelled: '08/07/2021',
    TimeCancelled: '1:36 PM',
    Reason: 'Wrong Location',
  ),
];

final List<Completed> sampleCompletedOrder = [
  Completed(
      TransactionID: "1234-56789",
      Schedule: "07/07/21 ",
      Time: "2:12 PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Motorcycle",
      Rate: 170.50,
      DateCompleted: "08/07/21",
      TimeCompleted: "1:36 PM"),
];

final List<Ongoing> sampleOngoingOrder = [
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/07/21 ",
      Time: "2:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Motorcycle",
      Rate: 141.50),
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/08/21 ",
      Time: "3:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Car",
      Rate: 101.50),
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/09/21 ",
      Time: "4:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Bus",
      Rate: 102.50),
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/09/21 ",
      Time: "4:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Bus",
      Rate: 102.50),
  Ongoing(
      TransactionID: "1234-56789",
      Schedule: "07/09/21 ",
      Time: "4:12PM",
      Pickup: "Pickup",
      DropOff: "Drop Off",
      Vehicle: "Bus",
      Rate: 102.50),
];

final List<NotificationModel> sampleNotif = [
  NotificationModel(
      title: 'Notification',
      subtitle: 'Notification Subject',
      message: 'Notification Message'),
  NotificationModel(
      title: 'Notification',
      subtitle: 'Notification Subject',
      message: 'Notification Message'),
  NotificationModel(
      title: 'Notification',
      subtitle: 'Notification Subject',
      message: 'Notification Message'),
  NotificationModel(
      title: 'Notification',
      subtitle: 'Notification Subject',
      message: 'Notification Message'),
];

class UserPreferences {
  static const _keyUser = 'user';
  static late SharedPreferences _preferences;
  static get myUser => User(
        defaultImage: 'assets/user_picture.png',
        userName: 'Rider Juan',
        number: "09329761234",
        email: 'pedro@gmail.com',
      );
  static Future init() async {
    _preferences = await SharedPreferences.getInstance();
  }

  static Future setUser(User user) async {
    final json = jsonEncode(user.toJson());

    await _preferences.setString(_keyUser, json);
  }

  static User getUser() {
    final json = _preferences.getString(_keyUser);
    return json == null ? myUser : User.fromJson(jsonDecode(json));
  }
}
