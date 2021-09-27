import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

import 'package:yoo_rider_account_page/screens/homepage/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/orderspage/pages/order_details_page.dart';
import 'package:yoo_rider_account_page/services/enum.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

class OrderCompletedWidget extends StatelessWidget {
  final List<Completed?> completeds = sampleCompletedOrder; //mao naning OOP

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
      color: greyOpacity,
      elevation: 8.0,
      margin: EdgeInsets.all(8.0),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: <Widget>[
          ListTile(
            title: Padding(
              padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
              child: Column(
                children: <Widget>[
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      Icon(Icons.add_box),
                      SizedBox(
                        width: 10,
                      ),
                      Text('Item Type: Item Type'),
                      Spacer(),
                      Text(
                        ' PHP ' + completed.Rate.toStringAsFixed(2),
                        style: TextStyle(fontWeight: FontWeight.bold),
                      )
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
                      Icon(
                        Icons.location_on,
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Text(completed.Pickup),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(
                        Icons.location_on,
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Text(completed.DropOff),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.calendar_today),
                      SizedBox(
                        width: 10,
                      ),
                      Text(completed.Schedule),
                      Spacer(),
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
