import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/order_navigation_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/widgets/add_ons_widget.dart';
import 'package:yoo_rider_account_page/widgets/style_theme.dart';

class HomePage extends StatefulWidget {
  static const routeName = '/homepage';
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final List<Active?> actives = sampleActiveOrder;
  var date;
  var time;
  bool value = true;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          "Active Orders",
          style: appBarStyle,
        ),
        automaticallyImplyLeading: false,
      ),
      // drawer: DrawerSample(),
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
        body: SingleChildScrollView(
          child: Container(
            padding: EdgeInsets.symmetric(vertical: 8.0),
            child: Column(
              children: <Widget>[
                Header(active, context),
                SizedBox(height: 8.0),
                BodyDetails(active, context),
              ],
            ),
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
                color: primaryColor,
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
              color: primaryColor,
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
      padding: const EdgeInsets.all(8.0),
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
          UserRemarks(context, active.Remarks),
          takeOrderButton(),
        ],
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
                  color: primaryColor,
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
                        color: primaryColor,
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
                        color: primaryColor,
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
                        color: primaryColor,
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
                  color: primaryColor,
                ),
                Text("  Pick Up Schedule - ${schedule} ${time}",
                    style: TextStyle(color: Colors.black38, fontSize: 15)),
              ],
            ),
            Row(
              children: <Widget>[
                Icon(Icons.directions_car_filled, color: primaryColor),
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
                      color: primaryColor),
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
                Icon(Icons.check_box, color: primaryColor),
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
                    color: primaryColor,
                    fontSize: 18.0,
                    fontWeight: FontWeight.bold)),
            Row(
              children: [
                Icon(
                  Icons.money,
                  color: primaryColor,
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
                  color: primaryColor,
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

  Widget UserRemarks(context, remarks) {
    return Container(
      height: MediaQuery.of(context).size.height * .25,
      width: MediaQuery.of(context).size.width,
      padding: const EdgeInsets.all(16.0),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            offset: const Offset(0.0, 0.0),
          )
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Remarks',
            style: TextStyle(
                fontSize: 18, fontWeight: FontWeight.w800, color: primaryColor),
          ),
          SizedBox(
            height: 10,
          ),
          Container(
            padding: EdgeInsets.all(10),
            height: MediaQuery.of(context).size.height * .15,
            width: MediaQuery.of(context).size.width,
            decoration: BoxDecoration(
              border: Border.all(),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Text('$remarks'),
          ),
        ],
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
              child: Text(
                'Take Order',
                style: TextStyle(color: Colors.white),
              ),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(5),
              ),
              padding: const EdgeInsets.all(10),
              color: primaryColor,
              onPressed: () {
                RouteGenerator.navigateTo(OrderNavigation.routeName);
              }),
        ],
      ),
    );
  }
}
