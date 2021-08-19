import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';

class OrderDetailsPage extends StatelessWidget {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final String DateCompleted;
  final String TimeCompleted;
  final String DateCancelled;
  final String TimeCancelled;
  final String Reason;
  final Order orderDetailsPage;

  OrderDetailsPage(
    this.TransactionID,
    this.Schedule,
    this.Time,
    this.Pickup,
    this.DropOff,
    this.Vehicle,
    this.Rate,
    this.DateCompleted,
    this.TimeCompleted,
    this.DateCancelled,
    this.TimeCancelled,
    this.Reason,
    this.orderDetailsPage,
  );

  @override
  Widget build(BuildContext context) {
    if (orderDetailsPage == Order.OngoingPage) {
      return OrderOngoingDetailsPage(
        orderDetailsPage.displayPage, //App bar title
        TransactionID,
        Schedule,
        Time,
        Pickup,
        DropOff,
        Vehicle,
        Rate,
      );
    } else if (orderDetailsPage == Order.CompletedPage) {
      return OrderCompletedDetailsPage(
        orderDetailsPage.displayPage, //App bar title
        TransactionID,
        Schedule,
        Time,
        Pickup,
        DropOff,
        Vehicle,
        Rate,
        DateCompleted,
        TimeCompleted,
      );
    } else if (orderDetailsPage == Order.CancelledPage) {
      return OrderCancelledDetailsPage(
        orderDetailsPage.displayPage, //App bar title
        TransactionID,
        Schedule,
        Time,
        Pickup,
        DropOff,
        Vehicle,
        Rate,
        DateCancelled,
        TimeCancelled,
        Reason,
      );
    } else {
      return Scaffold(
        body: Center(
          child: Text("Page Not Found"),
        ),
      );
    }
  }
}

//Widget For Ongoing Details Page
Widget OrderOngoingDetailsPage(
  String AppbarTitle,
  String transactionID,
  String schedule,
  String time,
  String pickup,
  String dropOff,
  String vehicle,
  double rate,
) {
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

//Widget for Ongoing Details Page
Widget OrderCompletedDetailsPage(
  AppbarTitle,
  String transactionID,
  String schedule,
  String time,
  String pickup,
  String dropOff,
  String vehicle,
  double rate,
  String dateCompleted,
  String timeCompleted,
) {
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

//Widget for Order Cancelled Page
Widget OrderCancelledDetailsPage(
  AppbarTitle,
  String transactionID,
  String schedule,
  String time,
  String pickup,
  String dropOff,
  String vehicle,
  double rate,
  String dateCancelled,
  String timeCancelled,
  String reason,
) {
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
