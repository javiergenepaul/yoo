import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:yoo_rider_account_page/models/notification_model.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/models/wallet_models.dart';

var ordermodel = [
  OrderModel(
    ongoing: sampleOngoingOrder,
    completed: sampleCompletedOrder,
    cancelled: sampleCancelledOrder,
  )
];

// var sampleOrder = [
//   Cancelled(
//       TransactionID: "1234-56789",
//       Schedule: "07/07/21 ",
//       Time: "2:12 PM",
//       Pickup: "Pickup",
//       DropOff: "Drop Off",
//       Vehicle: "Motorcycle",
//       Rate: 160.50,
//       DateCancelled: '08/07/2021',
//       TimeCancelled: '1:36 PM',
//       Reason: 'Wrong Location'),
//   Ongoing(
//       TransactionID: "1234-56789",
//       Schedule: "07/07/21 ",
//       Time: "2:12PM",
//       Pickup: "Pickup",
//       DropOff: "Drop Off",
//       Vehicle: "Motorcycle",
//       Rate: 141.50),
// ];

final List<Active> sampleActiveOrder = [
  Active(
      SenderName: 'Lorenz Pepito',
      ReceiverName: 'Pedro Penduko',
      SenderNumber: '+639321721859',
      ReceiverNumber: '+639396266482',
      TransactionID: "123-456789",
      Schedule: "07/21/21",
      Time: "2:30",
      Pickup: "Tungkop Minglanilla, Cebu",
      DropOff: "Colon Naga City, Cebu",
      Vehicle: "Motorcycle",
      Rate: 320.00,
      State: true,
      ItemType: 'Tshirt',
      AddOns: 'Queueing Service',
      Remarks:
          "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat"),
  Active(
      SenderName: 'Lorenz Pepito',
      ReceiverName: 'Pedro Penduko',
      SenderNumber: '+639321721859',
      ReceiverNumber: '+639396266482',
      TransactionID: "123-456789",
      Schedule: "07/07/21",
      Time: "2:30",
      Pickup: "PickUp",
      DropOff: "DropOff",
      Vehicle: "Vehicle",
      Rate: 170.00,
      State: true,
      ItemType: 'Tshirt',
      AddOns: 'Insulated Box',
      Remarks: "This is a remark message From User"),
  Active(
      SenderName: 'Lorenz Pepito',
      ReceiverName: 'Pedro Penduko',
      SenderNumber: '+639321721859',
      ReceiverNumber: '+639396266482',
      TransactionID: "123-456789",
      Schedule: "07/07/21",
      Time: "2:30",
      Pickup: "PickUp",
      DropOff: "DropOff",
      Vehicle: "Vehicle",
      Rate: 170.00,
      State: true,
      ItemType: 'Tshirt',
      AddOns: 'Queueing Service',
      Remarks: "This is a remark message From User"),
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

final List<WalletModel> sampleWallet = [
  WalletModel(
    title: 'Cash out',
    subtitle: 'To BPI',
    trailing: 'Php 1000.00',
  ),
  WalletModel(
    title: 'Delivery',
    subtitle: 'Transaction ID',
    trailing: 'Php 1000.00',
  ),
  WalletModel(
    title: 'Cash in',
    subtitle: 'Gcash',
    trailing: 'Php 500.00',
  ),
  WalletModel(
    title: 'Cash out',
    subtitle: 'To BPI',
    trailing: 'Php 700.00',
  ),
  WalletModel(
    title: 'Cash out',
    subtitle: 'To BPI',
    trailing: 'Php 300.00',
  ),
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
