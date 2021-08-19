import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';

import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/order_details_page.dart';

class OrderCompletedWidget extends StatelessWidget {
  final List<Completed?> completeds = sampleCompletedOrder;

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleCompletedOrder.length,
        itemBuilder: (context, i) {
          Completed? completed = completeds[i];
          return OrderCompletedItems(completed!, context);
        },
      ),
    );
  }

  Widget OrderCompletedItems(Completed completed, BuildContext context) {
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
                      Text(completed.Schedule),
                      Text(completed.Time)
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
                      Text(' ' + completed.Pickup),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.circle_outlined),
                      Text(' ' + completed.DropOff),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.directions_car_filled),
                      Text(' ' + completed.Vehicle),
                      Spacer(),
                      Icon(Icons.money),
                      Text(
                        ' PHP ' + completed.Rate.toStringAsFixed(2),
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
                    completed.TransactionID,
                    completed.Schedule,
                    completed.Time,
                    completed.Pickup,
                    completed.DropOff,
                    completed.Vehicle,
                    completed.Rate,
                    completed.DateCompleted,
                    completed.TimeCompleted,
                    '', //date cancelled
                    '', //time cancelled
                    '', //reason
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
