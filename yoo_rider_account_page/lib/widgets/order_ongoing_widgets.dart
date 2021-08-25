import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/order_details_page.dart';

class OrderOngoingWidget extends StatelessWidget {
  final List<Ongoing?> ongoings = sampleOngoingOrder;
  @override
  Widget build(BuildContext context) {
    return Container();
//     return Scrollbar(
//       child: ListView.builder(
//         padding: EdgeInsets.all(8.0),
//         itemCount: sampleOngoingOrder.length,
//         itemBuilder: (context, i) {
//           Ongoing? ongoing = ongoings[i];
//           return OrderOngoingItems(ongoing!, context);
//         },
//       ),
//     );
//   }

//   Widget OrderOngoingItems(Ongoing ongoing, BuildContext context) {
//     return Card(
//       elevation: 8.0,
//       margin: EdgeInsets.all(8.0),
//       child: Column(
//         children: <Widget>[
//           ListTile(
//             title: Padding(
//               padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
//               child: Column(
//                 children: <Widget>[
//                   Row(
//                     children: <Widget>[
//                       Text("Scheduled: "),
//                       Text(ongoing.Schedule),
//                       Text(ongoing.Time)
//                     ],
//                   ),
//                 ],
//               ),
//             ),
//             subtitle: Column(
//               children: <Widget>[
//                 Padding(
//                   padding: const EdgeInsets.only(top: 16.0, bottom: 8.0),
//                   child: Row(
//                     children: <Widget>[
//                       Icon(Icons.circle_outlined),
//                       Text(' ' + ongoing.Pickup),
//                       Spacer()
//                     ],
//                   ),
//                 ),
//                 Padding(
//                   padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
//                   child: Row(
//                     children: <Widget>[
//                       Icon(Icons.circle_outlined),
//                       Text(' ' + ongoing.DropOff),
//                       Spacer()
//                     ],
//                   ),
//                 ),
//                 Padding(
//                   padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
//                   child: Row(
//                     children: <Widget>[
//                       Icon(Icons.directions_car_filled),
//                       Text(' ' + ongoing.Vehicle),
//                       Spacer(),
//                       Icon(Icons.money),
//                       Text(
//                         ' PHP ' + ongoing.Rate.toStringAsFixed(2),
//                         style: TextStyle(fontWeight: FontWeight.bold),
//                       )
//                     ],
//                   ),
//                 ),
//               ],
//             ),
//             onTap: () {
//               Navigator.push(
//                 context,
//                 MaterialPageRoute(
//                   builder: (context) => OrderDetailsPage(
//                     ongoing.TransactionID,
//                     ongoing.Schedule,
//                     ongoing.Time,
//                     ongoing.Pickup,
//                     ongoing.DropOff,
//                     ongoing.Vehicle,
//                     ongoing.Rate,
//                     '', //date Completed
//                     '', //time completed
//                     '', //Date Cancelled
//                     '', //Time Cancelled
//                     '', //Reason
//                     Order.OngoingPage,
//                   ),
//                 ),
//               );
//             },
//           )
//         ],
//       ),
//     );
  }
}
