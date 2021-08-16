import 'package:flutter/material.dart';

class OrderDetailsPage extends StatelessWidget {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final String Status;

  OrderDetailsPage(this.TransactionID, this.Schedule, this.Time, this.Pickup,
      this.DropOff, this.Vehicle, this.Rate, this.Status);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("$Status"),
      ),
      body: Container(
        child: Column(
          children: <Widget>[
            Card(
              elevation: 8.0,
              margin: EdgeInsets.only(top: 2.0, bottom: 5.0),
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  children: <Widget>[
                    Text("Transaction ID ",
                        style: TextStyle(
                            color: Theme.of(context).accentColor,
                            fontWeight: FontWeight.bold,
                            fontSize: 18)),
                    Text(
                      TransactionID,
                      style: TextStyle(color: Colors.black38, fontSize: 15),
                    ),
                    Spacer(),
                    Icon(
                      Icons.money,
                      color: Theme.of(context).accentColor,
                    ),
                    Text(
                      " PHP " + Rate.toStringAsFixed(2),
                      style: TextStyle(
                          color: Colors.black38,
                          fontWeight: FontWeight.bold,
                          fontSize: 15),
                    ),
                  ],
                ),
              ),
            ),
            Expanded(
              child: Container(
                //color: Colors.amber,
                child: Column(
                  children: [
                    Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Row(
                        children: <Widget>[
                          Text(
                            "Completed ",
                            style: TextStyle(
                                color: Theme.of(context).accentColor,
                                fontWeight: FontWeight.bold,
                                fontSize: 18),
                          ),
                          Text(Schedule,
                              style: TextStyle(
                                  color: Colors.black38, fontSize: 15)),
                          Text(Time,
                              style: TextStyle(
                                  color: Colors.black38, fontSize: 15))
                        ],
                      ),
                    ),
                    Padding(
                      padding: EdgeInsets.all(8.0),
                      child: Column(
                        children: [
                          Padding(
                            padding: const EdgeInsets.only(bottom: 8.0),
                            child: Container(
                              decoration: BoxDecoration(
                                  color: Colors.white,
                                  boxShadow: [
                                    BoxShadow(
                                      offset: const Offset(0.0, 1.0),
                                      blurRadius: 1.0,
                                    )
                                  ]),
                              child: Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: Row(
                                  //mainAxisAlignment: MainAxisAlignment.start,
                                  children: [
                                    Column(
                                      children: [
                                        Text("Delivery Details"),
                                        Text("Pick Up")
                                      ],
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ),
                          Padding(
                            padding: const EdgeInsets.only(bottom: 8.0),
                            child: Container(
                              decoration: BoxDecoration(
                                  color: Colors.white,
                                  boxShadow: [
                                    BoxShadow(
                                      offset: const Offset(0.0, 1.0),
                                      blurRadius: 1.0,
                                    )
                                  ]),
                              child: Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: Row(
                                  children: [
                                    Column(
                                      children: [
                                        Text("sample"),
                                        Text("Sample")
                                      ],
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ),
                        ],
                      ),
                    )
                  ],
                ),
              ),
            )
          ],
        ),
      ),
    );
  }
}
