import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/screens/homepage/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/orderspage/pages/order_details_page.dart';
import 'package:yoo_rider_account_page/services/enum.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

class OrderCancelledWidget extends StatelessWidget {
  final List<Cancelled?> cancelleds = sampleCancelledOrder;
  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleCancelledOrder.length,
        itemBuilder: (context, i) {
          Cancelled? cancelled = cancelleds[i];
          return OrderCancelledItems(cancelled!, context);
        },
      ),
    );
  }

  Widget OrderCancelledItems(Cancelled cancelled, BuildContext context) {
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
                        ' PHP ' + cancelled.Rate.toStringAsFixed(2),
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
                      Text(cancelled.Pickup),
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
                      Text(cancelled.DropOff),
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
                      Text(cancelled.Schedule),
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
                    cancelled.TransactionID,
                    cancelled.Schedule,
                    cancelled.Time,
                    cancelled.Pickup,
                    cancelled.DropOff,
                    cancelled.Vehicle,
                    cancelled.Rate,
                    '', //Date Completed
                    '', //Time Completed
                    cancelled.DateCancelled,
                    cancelled.TimeCancelled,
                    cancelled.Reason,
                    Order.CancelledPage,
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
