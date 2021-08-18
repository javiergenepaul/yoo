import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/order_details_page.dart';

class OrderCancelledWidget extends StatelessWidget {
  //Sample List Data
  final List<Cancelled> sampleCancelledOrder = [
    Cancelled(
        TransactionID: "1234-56789",
        Schedule: "07/07/21 ",
        Time: "2:12 PM",
        Pickup: "Pickup",
        DropOff: "Drop Off",
        Vehicle: "Motorcycle",
        Rate: 141.50,
        DateCancelled: '08/07/2021',
        TimeCancelled: '1:36 PM',
        Reason: 'Wrong Location'),
  ];

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleCancelledOrder.length,
        itemBuilder: (context, i) => OrderCancelledItems(
            sampleCancelledOrder[i].TransactionID,
            sampleCancelledOrder[i].Schedule,
            sampleCancelledOrder[i].Time,
            sampleCancelledOrder[i].Pickup,
            sampleCancelledOrder[i].DropOff,
            sampleCancelledOrder[i].Vehicle,
            sampleCancelledOrder[i].Rate,
            sampleCancelledOrder[i].DateCancelled,
            sampleCancelledOrder[i].TimeCancelled,
            sampleCancelledOrder[i].Reason,
            context),
      ),
    );
  }

  Widget OrderCancelledItems(
      String TransactionID,
      String Schedule,
      String Time,
      String Pickup,
      String DropOff,
      String Vehicle,
      double Rate,
      String DateCancelled,
      String TimeCancelled,
      String Reason,
      BuildContext context) {
    return Card(
      elevation: 8.0,
      margin: EdgeInsets.all(8.0),
      child: Column(
        children: <Widget>[
          ListTile(
            title: Padding(
              padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
              child: Column(
                children: <Widget>[
                  Row(
                    children: <Widget>[
                      Text(Schedule),
                      Text(Time),
                    ],
                  ),
                ],
              ),
            ),
            subtitle: Column(
              children: <Widget>[
                Padding(
                  padding: const EdgeInsets.only(top: 16.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.circle_outlined),
                      Text(' ' + Pickup),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.circle_outlined),
                      Text(' ' + DropOff),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.directions_car_filled),
                      Text(' ' + Vehicle),
                      Spacer(),
                      Icon(Icons.money),
                      Text(
                        ' PHP ' + Rate.toStringAsFixed(2),
                        style: TextStyle(fontWeight: FontWeight.bold),
                      )
                    ],
                  ),
                ),
              ],
            ),
            onTap: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => OrderDetailsPage(
                    TransactionID,
                    Schedule,
                    Time,
                    Pickup,
                    DropOff,
                    Vehicle,
                    Rate,
                    Order.CompletedPage,
                  ),
                ),
              );
            },
          )
        ],
      ),
    );
  }
}
