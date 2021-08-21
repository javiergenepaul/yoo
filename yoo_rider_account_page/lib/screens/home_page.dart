import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/order_navigation_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/widgets/add_ons_widget.dart';

class HomePage extends StatefulWidget {
  static const routeName = '/homepage';
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final List<Active?> actives = sampleActiveOrder;
  var date;
  var time;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Active Orders"),
      ),
      body: Scrollbar(
        child: ListView.builder(
          padding: EdgeInsets.all(8.0),
          itemCount: sampleActiveOrder.length,
          itemBuilder: (context, i) {
            Active? active = actives[i];
            return OrderActiveItems(active!, context);
          },
        ),
      ),
    );
  }

  Widget OrderActiveItems(Active active, context) {
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
                      Text(active.Schedule),
                      Text(active.Time)
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
                      Text(' ' + active.Pickup),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.circle_outlined),
                      Text(' ' + active.DropOff),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.directions_car_filled),
                      Text(' ' + active.Vehicle),
                      Spacer(),
                      Icon(Icons.money),
                      Text(
                        ' PHP ' + active.Rate.toStringAsFixed(2),
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
                  builder: (context) => ActiveOrderDetails(active, context),
                ),
              );
            },
          )
        ],
      ),
    );
  }

  Widget ActiveOrderDetails(Active active, context) {
    return Scaffold(
        appBar: AppBar(
          title: Text("Active Order Details"),
        ),
        body: Container(
          padding: EdgeInsets.symmetric(vertical: 8.0),
          child: Column(
            children: <Widget>[
              Header(active, context),
              SizedBox(height: 8.0),
              BodyDetails(active, context),
            ],
          ),
        ));
  }

  Widget Header(Active active, context) {
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
              active.TransactionID,
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
              active.Rate.toStringAsFixed(2),
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

  Widget BodyDetails(Active active, context) {
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
            //delivery Details
            DeliveryDetails(context, active.Pickup, active.DropOff),
            //Schedule Details
            ScheduleDetails(context, active.Schedule, time, active.Vehicle),
            //Add ons Details
            AddOnsDetails(context),
            //payment details
            PaymentDetails(context),
            //total payment details
            TotalPaymentDetails(context, active.Rate),
            //TODO:
            takeOrderButton(),
          ],
        ),
      ),
    );
  }

  Widget DeliveryDetails(context, pickup, dropOff) {
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

  Widget ScheduleDetails(context, schedule, time, vehicle) {
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

  Widget AddOnsDetails(context) {
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

  Widget PaymentDetails(context) {
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

  Widget TotalPaymentDetails(context, rate) {
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
                    style:
                        TextStyle(fontWeight: FontWeight.bold, fontSize: 20)),
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
                    style:
                        TextStyle(fontWeight: FontWeight.bold, fontSize: 20)),
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

  //Button
  Widget takeOrderButton() {
    return Container(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: <Widget>[
          RaisedButton(
              child: Text('Take Order'),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(5),
              ),
              padding: const EdgeInsets.all(10),
              color: Theme.of(context).primaryColor,
              onPressed: () {
                RouteGenerator.navigateTo(OrderNavigation.routeName);
              }),
        ],
      ),
    );
  }
}
