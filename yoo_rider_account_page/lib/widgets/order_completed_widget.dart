import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/widgets/order_completed_items_widget.dart';

class OrderCompletedWidget extends StatelessWidget {
  final List<OrderModel> sampleOrder = [
    OrderModel(
        TransactionID: "1234-56789",
        Schedule: "07/07/21 ",
        Time: "2:12 PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Motorcycle",
        Rate: 141.50),
  ];

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleOrder.length,
        itemBuilder: (ctx, i) => OrderCompletedItem(
            sampleOrder[i].TransactionID,
            sampleOrder[i].Schedule,
            sampleOrder[i].Time,
            sampleOrder[i].Pickup,
            sampleOrder[i].DropOff,
            sampleOrder[i].Vehicle,
            sampleOrder[i].Rate,
            "Completed"),
      ),
    );
  }
}
