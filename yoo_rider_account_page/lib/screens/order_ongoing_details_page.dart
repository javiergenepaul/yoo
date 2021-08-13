import 'package:flutter/material.dart';

class OrderOngoingDetailsPage extends StatelessWidget {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;

  OrderOngoingDetailsPage(
    this.TransactionID,
    this.Schedule,
    this.Time,
    this.Pickup,
    this.DropOff,
    this.Vehicle,
    this.Rate,
  );
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Order Details Ongoing'),
      ),
      body: Center(
        child: Column(
          children: [
            Text(TransactionID),
            Text(Schedule),
            Text(Time),
            Text(Pickup),
            Text(DropOff),
            Text(Vehicle),
          ],
        ),
      ),
    );
  }
}
