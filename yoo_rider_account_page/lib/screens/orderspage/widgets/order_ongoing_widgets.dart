import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/screens/homepage/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/orderspage/pages/order_details_page.dart';
import 'package:yoo_rider_account_page/services/enum.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

class OrderOngoingWidget extends StatelessWidget {
  final List<Ongoing?> ongoings = sampleOngoingOrder;
  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleOngoingOrder.length,
        itemBuilder: (context, i) {
          Ongoing? ongoing = ongoings[i];
          return OrderOngoingItems(ongoing!, context);
        },
      ),
    );
  }

  Widget OrderOngoingItems(Ongoing ongoing, BuildContext context) {
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
                        ' PHP ' + ongoing.Rate.toStringAsFixed(2),
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
                      Text(ongoing.Pickup),
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
                      Text(ongoing.DropOff),
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
                      Text(ongoing.Schedule),
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
                    ongoing.TransactionID,
                    ongoing.Schedule,
                    ongoing.Time,
                    ongoing.Pickup,
                    ongoing.DropOff,
                    ongoing.Vehicle,
                    ongoing.Rate,
                    '', //date Completed
                    '', //time completed
                    '', //Date Cancelled
                    '', //Time Cancelled
                    '', //Reason
                    Order.OngoingPage,
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
