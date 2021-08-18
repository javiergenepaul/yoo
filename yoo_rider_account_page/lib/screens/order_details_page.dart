import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/services/enum.dart';

class OrderDetailsPage extends StatelessWidget {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final Order orderDetailsPage;

  OrderDetailsPage(
    this.TransactionID,
    this.Schedule,
    this.Time,
    this.Pickup,
    this.DropOff,
    this.Vehicle,
    this.Rate,
    this.orderDetailsPage,
  );

  @override
  Widget build(BuildContext context) {
    if (orderDetailsPage == Order.OngoingPage) {
      return OrderOngoingDetailsPage(orderDetailsPage.displayPage);
    } else if (orderDetailsPage == Order.CompletedPage) {
      return OrderCompletedDetailsPage(orderDetailsPage.displayPage);
    } else if (orderDetailsPage == Order.CancelledPage) {
      return OrderCancelledDetailsPage(orderDetailsPage.displayPage);
    } else {
      return Scaffold(
        appBar: AppBar(
          title: Text(orderDetailsPage.displayPage),
        ),
      );
    }
  }
}

Widget OrderOngoingDetailsPage(AppbarTitle) {
  return Scaffold(
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      child: Center(
        child: Text("Ongoing Details Page"),
      ),
    ),
  );
}

Widget OrderCompletedDetailsPage(AppbarTitle) {
  return Scaffold(
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      child: Center(
        child: Text("Completed Details Page"),
      ),
    ),
  );
}

Widget OrderCancelledDetailsPage(AppbarTitle) {
  return Scaffold(
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      child: Center(
        child: Text("Cancelled Details Page"),
      ),
    ),
  );
}
