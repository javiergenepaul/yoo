import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/widgets/order_ongoing_items_widgets.dart';

class OrderOngoingWidget extends StatelessWidget {
  final List<OrderModel> sampleOrder = [
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/07/21 ",
        Time: "2:12PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Motorcycle",
        Rate: 141.50),
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/08/21 ",
        Time: "3:12PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Car",
        Rate: 101.50),
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/09/21 ",
        Time: "4:12PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Bus",
        Rate: 102.50),
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/09/21 ",
        Time: "4:12PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Bus",
        Rate: 102.50),
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/09/21 ",
        Time: "4:12PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Bus",
        Rate: 102.50),
  ];

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleOrder.length,
        itemBuilder: (ctx, i) => OrderOngoingItem(
          sampleOrder[i].TransactionID,
          sampleOrder[i].Schedule,
          sampleOrder[i].Time,
          sampleOrder[i].Pickup,
          sampleOrder[i].DropOff,
          sampleOrder[i].Vehicle,
          sampleOrder[i].Rate,
        ),
      ),
    );
  }
}
