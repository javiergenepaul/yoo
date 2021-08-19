import 'package:yoo_rider_account_page/models/order_model.dart';

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
      Reason: 'Wrong Location'),
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
      DateCompleted: "08/07,21",
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
