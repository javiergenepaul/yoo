import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/order_details_page.dart';
import 'package:yoo_rider_account_page/data/enum.dart';

class OrderOngoingWidget extends StatelessWidget {
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

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleOngoingOrder.length,
        itemBuilder: (context, i) => OrderOngoingItems(
            sampleOngoingOrder[i].TransactionID,
            sampleOngoingOrder[i].Schedule,
            sampleOngoingOrder[i].Time,
            sampleOngoingOrder[i].Pickup,
            sampleOngoingOrder[i].DropOff,
            sampleOngoingOrder[i].Vehicle,
            sampleOngoingOrder[i].Rate,
            context),
      ),
    );
  }

  Widget OrderOngoingItems(
    String TransactionID,
    String Schedule,
    String Time,
    String Pickup,
    String DropOff,
    String Vehicle,
    double Rate,
    BuildContext context,
  ) {
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
                      Text("Scheduled: "),
                      Text(Schedule),
                      Text(Time)
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
                            Order.OngoingPage,
                          )));
            },
          )
        ],
      ),
    );
  }
}
