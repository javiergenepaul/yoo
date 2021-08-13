import 'package:flutter/material.dart';

class OrderCompletedDetailsPage extends StatelessWidget {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;

  OrderCompletedDetailsPage(this.TransactionID, this.Schedule, this.Time,
      this.Pickup, this.DropOff, this.Vehicle, this.Rate);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Order Details Completed"),
      ),
    );
  }
}
