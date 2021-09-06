import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/orderspage/order_details_page.dart';

class OrderCancelledWidget extends StatelessWidget {
  // final List<Cancelled?> cancelleds = sampleCancelledOrder;
  @override
  Widget build(BuildContext context) {
    return Container();
    //   return Scrollbar(
    //     child: ListView.builder(
    //       padding: EdgeInsets.all(8.0),
    //       itemCount: sampleCancelledOrder.length,
    //       itemBuilder: (context, i) {
    //         Cancelled? cancelled = cancelleds[i];
    //         return OrderCancelledItems(cancelled!, context);
    //       },
    //     ),
    //   );
    // }

    // Widget OrderCancelledItems(Cancelled cancelled, BuildContext context) {
    //   return Card(
    //     elevation: 8.0,
    //     margin: EdgeInsets.all(8.0),
    //     child: Column(
    //       children: <Widget>[
    //         ListTile(
    //           title: Padding(
    //             padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
    //             child: Column(
    //               children: <Widget>[
    //                 Row(
    //                   children: <Widget>[
    //                     Text(cancelled.Schedule),
    //                     Text(cancelled.Time),
    //                   ],
    //                 ),
    //               ],
    //             ),
    //           ),
    //           subtitle: Column(
    //             children: <Widget>[
    //               Padding(
    //                 padding: const EdgeInsets.only(top: 16.0, bottom: 8.0),
    //                 child: Row(
    //                   children: <Widget>[
    //                     Icon(Icons.circle_outlined),
    //                     Text(' ' + cancelled.Pickup),
    //                     Spacer()
    //                   ],
    //                 ),
    //               ),
    //               Padding(
    //                 padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
    //                 child: Row(
    //                   children: <Widget>[
    //                     Icon(Icons.circle_outlined),
    //                     Text(' ' + cancelled.DropOff),
    //                     Spacer()
    //                   ],
    //                 ),
    //               ),
    //               Padding(
    //                 padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
    //                 child: Row(
    //                   children: <Widget>[
    //                     Icon(Icons.directions_car_filled),
    //                     Text(' ' + cancelled.Vehicle),
    //                     Spacer(),
    //                     Icon(Icons.money),
    //                     Text(
    //                       ' PHP ' + cancelled.Rate.toStringAsFixed(2),
    //                       style: TextStyle(fontWeight: FontWeight.bold),
    //                     )
    //                   ],
    //                 ),
    //               ),
    //             ],
    //           ),
    //           onTap: () {
    //             Navigator.push(
    //               context,
    //               MaterialPageRoute(
    //                 builder: (context) => OrderDetailsPage(
    //                   cancelled.TransactionID,
    //                   cancelled.Schedule,
    //                   cancelled.Time,
    //                   cancelled.Pickup,
    //                   cancelled.DropOff,
    //                   cancelled.Vehicle,
    //                   cancelled.Rate,
    //                   '', //Date Completed
    //                   '', //Time Completed
    //                   cancelled.DateCancelled,
    //                   cancelled.TimeCancelled,
    //                   cancelled.Reason,
    //                   Order.CancelledPage,
    //                 ),
    //               ),
    //             );
    //           },
    //         )
    //       ],
    //     ),
    //   );
  }
}
