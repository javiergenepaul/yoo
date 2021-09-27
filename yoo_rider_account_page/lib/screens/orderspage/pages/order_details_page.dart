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
          orderDetailsPage,
          orderDetailsPage.displayPage, //App bar title
          TransactionID,
          Schedule,
          Time,
          Pickup,
          DropOff,
          Vehicle,
          Rate,
          context);
    } else if (orderDetailsPage == Order.CompletedPage) {
      return OrderCompletedDetailsPage(
        orderDetailsPage,
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
        context,
      );
    } else if (orderDetailsPage == Order.CancelledPage) {
      return OrderCancelledDetailsPage(
          orderDetailsPage,
          orderDetailsPage.displayPage, //App bar title
          TransactionID,
          Schedule,
          Time,
          Pickup,
          DropOff,
          Vehicle,
          Rate,
          // DateCancelled,
          // TimeCancelled,
          // Reason,
          context);
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
    orderDetailsPage,
    String AppbarTitle,
    String transactionID,
    String schedule,
    String time,
    String pickup,
    String dropOff,
    String vehicle,
    double rate,
    BuildContext context) {
  return Scaffold(
    // resizeToAvoidBottomInset: false,
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Column(
        children: <Widget>[
          Header(context, transactionID, rate),
          SizedBox(height: 8),
          BodyDetails(orderDetailsPage, context, transactionID, schedule, time,
              pickup, dropOff, vehicle, rate),
        ],
      ),
    ),
  );
}

//Widget for Ongoing Details Page
Widget OrderCompletedDetailsPage(
    orderDetailsPage,
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
    BuildContext context) {
  return Scaffold(
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Column(
        children: <Widget>[
          Header(context, transactionID, rate), //Header Widget
          SizedBox(height: 8),
          BodyDetails(orderDetailsPage, context, transactionID, schedule, time,
              pickup, dropOff, vehicle, rate, dateCompleted, timeCompleted),
        ],
      ),
    ),
  );
}

//Widget for Order Cancelled Page
Widget OrderCancelledDetailsPage(
    orderDetailsPage,
    AppbarTitle,
    String transactionID,
    String schedule,
    String time,
    String pickup,
    String dropOff,
    String vehicle,
    double rate,
    // String dateCancelled,
    // String timeCancelled,
    // String reason,
    BuildContext context) {
  return Scaffold(
    appBar: AppBar(
      title: Text(AppbarTitle),
    ),
    body: Container(
      padding: EdgeInsets.all(16),
      child: Column(
        children: [
          ListView(
            padding: const EdgeInsets.symmetric(vertical: 8.0),
            children: <Widget>[
              Header(context, transactionID, rate), //Header Widget
              SizedBox(height: 8),
              BodyDetails(
                orderDetailsPage,
                context,
                transactionID,
                schedule,
                time,
                pickup,
                dropOff,
                vehicle,
                rate,
                // dateCancelled,
                // timeCancelled,
                // reason,
              ),
            ],
          ),
        ],
      ),
    ),
  );
}

//Contents
Widget Header(BuildContext context, transactionID, rate) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
          //blurRadius: 0.0,
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.symmetric(vertical: 3.0, horizontal: 8),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.start,
        children: <Widget>[
          Text(
            "Transaction ID ",
            style: TextStyle(
              color: Theme.of(context).accentColor,
              fontSize: 18.0,
              fontWeight: FontWeight.bold,
            ),
          ),
          Text(
            transactionID,
            style: TextStyle(color: Colors.black38, fontSize: 15),
          ),
          Spacer(),
          Icon(
            Icons.money,
            color: Theme.of(context).accentColor,
            size: 30.0,
          ),
          Text(
            " PHP",
            style: TextStyle(
                color: Colors.black38,
                fontWeight: FontWeight.bold,
                fontSize: 15),
          ),
          Text(
            rate.toStringAsFixed(2),
            style: TextStyle(
                color: Colors.black38,
                fontWeight: FontWeight.bold,
                fontSize: 15),
          ),
        ],
      ),
    ),
  );
}

Widget DeliveryDetails(BuildContext context, pickup, dropOff) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Text(
            "Delivery Details",
            style: TextStyle(
                color: Theme.of(context).accentColor,
                fontSize: 18.0,
                fontWeight: FontWeight.bold),
          ),
          Padding(
            padding: const EdgeInsets.only(top: 10),
            child: Column(
              children: [
                Row(
                  children: [
                    Icon(
                      Icons.circle_outlined,
                      color: Theme.of(context).accentColor,
                    ),
                    Text(
                      "   " + pickup,
                      style: TextStyle(color: Colors.black38, fontSize: 15),
                    ),
                  ],
                ),
                Row(
                  children: [
                    Icon(
                      Icons.circle_outlined,
                      color: Theme.of(context).accentColor,
                    ),
                    Text(
                      "   " + dropOff,
                      style: TextStyle(color: Colors.black38, fontSize: 15),
                    ),
                  ],
                ),
                Row(
                  children: [
                    Icon(
                      Icons.circle_outlined,
                      color: Theme.of(context).accentColor,
                    ),
                    Text(
                      "   " + dropOff,
                      style: TextStyle(color: Colors.black38, fontSize: 15),
                    ),
                  ],
                ),
              ],
            ),
          )
        ],
      ),
    ),
  );
}

Widget CompletedDetails(
  context,
  dateCompleted,
  timeCompleted,
) {
  return Padding(
    padding: const EdgeInsets.symmetric(vertical: 8.0),
    child: Row(
      children: <Widget>[
        Text(
          "Completed ",
          style: TextStyle(
              color: Theme.of(context).accentColor,
              fontSize: 18.0,
              fontWeight: FontWeight.bold),
        ),
        Text(dateCompleted,
            style: TextStyle(color: Colors.black38, fontSize: 15)),
        Text(", ", style: TextStyle(color: Colors.black38, fontSize: 15)),
        Text(
          timeCompleted,
          style: TextStyle(color: Colors.black38, fontSize: 15),
        )
      ],
    ),
  );
}

Widget BodyDetails(
  orderDetailsPage,
  context,
  transactionID,
  schedule,
  time,
  pickup,
  dropOff,
  vehicle,
  rate, [
  dateCompleted,
  timeCompleted,
  dateCancelled,
  timeCancelled,
  reason,
]) {
  return Container(
    // height: MediaQuery.of(context).size.height,
    width: MediaQuery.of(context).size.width,
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
          //blurRadius: 0.0,
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          //Completed Details
          if (orderDetailsPage == Order.CompletedPage)
            CompletedDetails(context, dateCompleted, timeCompleted),
          //delivery Details
          DeliveryDetails(context, pickup, dropOff),
          //Schedule Details
          ScheduleDetails(context, schedule, time, vehicle),
          //Add ons Details
          AddOnsDetails(context),
          //payment details
          PaymentDetails(context),
          //total payment details
          TotalPaymentDetails(context, rate),
        ],
      ),
    ),
  );
}

Widget ScheduleDetails(BuildContext context, schedule, time, vehicle) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        children: <Widget>[
          Row(
            children: <Widget>[
              Icon(
                Icons.calendar_today_rounded,
                color: Theme.of(context).accentColor,
              ),
              Text("  Pick Up Schedule - ${schedule} ${time}",
                  style: TextStyle(color: Colors.black38, fontSize: 15)),
            ],
          ),
          Row(
            children: <Widget>[
              Icon(Icons.directions_car_filled,
                  color: Theme.of(context).accentColor),
              Text("  ${vehicle}",
                  style: TextStyle(color: Colors.black38, fontSize: 15)),
            ],
          ),
        ],
      ),
    ),
  );
}

Widget AddOnsDetails(BuildContext context) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        children: <Widget>[
          Row(
            children: <Widget>[
              Text(
                "Add - ons ",
                style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: Theme.of(context).accentColor),
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(" Puchase , Queue, Unloading Assitance,",
                      style: TextStyle(color: Colors.black38, fontSize: 15)),
                  Text(" Additional Assitanct",
                      style: TextStyle(color: Colors.black38, fontSize: 15))
                ],
              ),
            ],
          ),
          Row(
            children: <Widget>[
              Icon(Icons.check_box, color: Theme.of(context).accentColor),
              Text("  Favourite Driver first",
                  style: TextStyle(color: Colors.black38, fontSize: 15)),
            ],
          ),
        ],
      ),
    ),
  );
}

Widget PaymentDetails(BuildContext context) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Text("Payment Details",
              style: TextStyle(
                  color: Theme.of(context).accentColor,
                  fontSize: 18.0,
                  fontWeight: FontWeight.bold)),
          Row(
            children: [
              Icon(
                Icons.money,
                color: Theme.of(context).accentColor,
                size: 30.0,
              ),
              Text(" Recipient",
                  style: TextStyle(color: Colors.black38, fontSize: 15)),
            ],
          ),
          Row(
            children: <Widget>[
              Icon(
                Icons.price_change_rounded,
                color: Theme.of(context).accentColor,
                size: 30.0,
              ),
              Text(" Voucher",
                  style: TextStyle(color: Colors.black38, fontSize: 15))
            ],
          )
        ],
      ),
    ),
  );
}

Widget TotalPaymentDetails(BuildContext context, rate) {
  return Container(
    decoration: BoxDecoration(
      color: Colors.white,
      boxShadow: [
        BoxShadow(
          offset: const Offset(0.0, 0.0),
        )
      ],
    ),
    child: Padding(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                "Paid (Cash)",
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                  color: Colors.black38,
                ),
              ),
              Text(rate.toStringAsFixed(2),
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 20)),
            ],
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                "Paid (Online)",
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                  color: Colors.black38,
                ),
              ),
              Text(rate.toStringAsFixed(2),
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 20)),
            ],
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                "Total",
                style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                    color: Colors.black54),
              ),
              Text(
                rate.toStringAsFixed(2),
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 20),
              ),
            ],
          ),
        ],
      ),
    ),
  );
}
