import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_phone_direct_caller/flutter_phone_direct_caller.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:slide_to_confirm/slide_to_confirm.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/homepage/arrive_dropoff_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/arrive_pickup_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/widgets/drawer_widget.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/widgets/order_ongoing_widgets.dart';

final pickUpNumberSample = '+639321721859';
final dropOffNumberSample = '+639396266482';

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
        title: Text(
          "Active Orders",
          style: appBarStyle,
        ),
        // automaticallyImplyLeading: false,
      ),
      drawer: MainDrawer(),
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
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      Text(
                        'Date: ${active.Schedule}',
                        style: TextStyle(fontSize: 15),
                      ),
                      Text(
                        'Time: ${active.Time}',
                        style: TextStyle(fontSize: 15),
                      ),
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
                      Icon(
                        Icons.location_on,
                      ),
                      Text(active.Pickup),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(
                        Icons.location_on,
                      ),
                      Text(active.DropOff),
                      Spacer()
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                  child: Row(
                    children: <Widget>[
                      Icon(Icons.directions_car_filled),
                      Text(active.Vehicle),
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
          title: Text("Order Details"),
        ),
        body: SingleChildScrollView(
          child: Container(
            color: Colors.grey.withOpacity(.2),
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
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        //delivery Details
        DeliveryDetails(context, active.Pickup, active.DropOff),
        SizedBox(
          height: 8,
        ),
        //Schedule Details
        ScheduleDetails(context, active.Schedule, active.Time, active.Vehicle),
        SizedBox(
          height: 8,
        ),
        //Add ons Details
        AddOnsDetails(context),
        SizedBox(
          height: 8,
        ),
        //payment details
        PaymentDetails(context),
        //total payment details
        TotalPaymentDetails(context, active.Rate),
        //TODO:
        UserRemarks(context, active.Remarks),
        takeOrderButton(active, context),
        cancelButton(),
      ],
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
                        Icons.location_on,
                        color: primaryColor,
                      ),
                      Text(
                        "   " + pickup,
                        style: TextStyle(fontSize: 15),
                      ),
                    ],
                  ),
                  Row(
                    children: [
                      Icon(
                        Icons.location_on,
                        color: primaryColor,
                      ),
                      Text(
                        "   " + dropOff,
                        style: TextStyle(fontSize: 15),
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
                    style: TextStyle(fontSize: 15)),
              ],
            ),
            Row(
              children: <Widget>[
                Icon(Icons.directions_car_filled, color: primaryColor),
                Text("  ${vehicle}", style: TextStyle(fontSize: 15)),
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
                    Text(" Puchase , Queue", style: TextStyle(fontSize: 15)),
                    Text(" Additional Assitanct",
                        style: TextStyle(fontSize: 15))
                  ],
                ),
              ],
            ),
            Row(
              children: <Widget>[
                Icon(Icons.check_box, color: primaryColor),
                Text("  Favourite Driver first",
                    style: TextStyle(fontSize: 15)),
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
                Text(" Recipient", style: TextStyle(fontSize: 15)),
              ],
            ),
            Row(
              children: <Widget>[
                Icon(
                  Icons.price_change_rounded,
                  color: primaryColor,
                  size: 30.0,
                ),
                Text(" Voucher", style: TextStyle(fontSize: 15))
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
                      color: Colors.black54),
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
                      color: Colors.black54),
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
                  ),
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

//SliderButton
  Widget takeOrderButton(Active active, context) {
    return Center(
      child: Padding(
        padding: EdgeInsets.all(10),
        child: ConfirmationSlider(
          height: 50,
          width: MediaQuery.of(context).size.width - 20,
          foregroundColor: Colors.grey,
          backgroundColor: secondaryColor,
          backgroundColorEnd: primaryColor,
          backgroundShape: BorderRadius.circular(50),
          text: 'Slide to Take Order',
          textStyle: TextStyle(color: Colors.white),
          onConfirmation: () {
            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => OrderPickUpPage(active, context),
              ),
            );
          },
        ),
      ),
    );
  }

//CancelButton
  Widget cancelButton() {
    return Center(
      child: AnimatedContainer(
          height: 65,
          width: MediaQuery.of(context).size.width - 20,
          padding: EdgeInsets.all(10),
          duration: Duration(seconds: 2),
          curve: Curves.easeInOut,
          child: OutlineButton(
            onPressed: () {},
            child: Text("Cancel"),
            borderSide: BorderSide(color: primaryColor),
            shape: StadiumBorder(),
          )),
    );
  }

//OrderPickUpPage
  Widget OrderPickUpPage(Active active, context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Order Pick up'),
      ),
      body: OrderPickUpDetails(
          context,
          active.Pickup,
          active.DropOff,
          active.Schedule,
          active.Time,
          active.TransactionID,
          active.Vehicle,
          active.Rate),
    );
  }

  Widget OrderPickUpDetails(
      context, pickup, dropOff, schedule, time, transactionId, vehicle, rate) {
    return Container(
      padding: EdgeInsets.all(10),
      color: Colors.grey.withOpacity(.1),
      child: Column(
        children: <Widget>[
          Container(
            padding: EdgeInsets.all(10),
            color: Colors.white,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text('Customer PickUp Contact',
                    style:
                        TextStyle(fontSize: 16, fontWeight: FontWeight.w700)),
                Row(
                  children: [
                    IconButton(
                      onPressed: () {},
                      icon: Icon(Icons.message),
                    ),
                    IconButton(
                      onPressed: () async {
                        await FlutterPhoneDirectCaller.callNumber(
                            pickUpNumberSample);
                      },
                      icon: Icon(Icons.phone),
                    ),
                  ],
                )
              ],
            ),
          ),
          SizedBox(
            height: 20,
          ),
          Container(
            padding: EdgeInsets.all(10),
            color: Colors.white,
            child: Column(
              children: <Widget>[
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: <Widget>[
                    Text(
                      'Schedule: $schedule  $time',
                      style: TextStyle(fontSize: 16),
                    ),
                    Text(
                      transactionId,
                      style: TextStyle(fontSize: 16),
                    ),
                  ],
                ),
                Container(
                  child: Column(
                    children: <Widget>[
                      ListTile(
                        contentPadding: EdgeInsets.all(5),
                        leading: Icon(Icons.location_on),
                        title: Text(
                          pickup,
                          style: header3,
                        ),
                        trailing: IconButton(
                            onPressed: () {
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => ArrivePickup()));
                            },
                            icon: Icon(
                              Icons.gps_fixed_rounded,
                              size: 30,
                              color: primaryColor,
                            )),
                      ),
                      ListTile(
                        contentPadding: EdgeInsets.all(5),
                        leading: Icon(Icons.location_on),
                        title: Text(
                          dropOff,
                          style: header3,
                        ),
                        trailing: IconButton(
                            onPressed: () {
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => ArriveDropOff()));
                            },
                            icon: Icon(
                              Icons.gps_fixed_rounded,
                              size: 30,
                              color: primaryColor,
                            )),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          SizedBox(
            height: 20,
          ),
          Container(
            color: Colors.white,
            padding: EdgeInsets.only(left: 10, right: 10, top: 20, bottom: 20),
            alignment: Alignment.centerLeft,
            child: Text('Type of Vehicle:   $vehicle',
                style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700)),
          ),
          SizedBox(
            height: 20,
          ),
          Container(
            color: Colors.white,
            padding: EdgeInsets.only(left: 10, right: 10, top: 20, bottom: 20),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[
                Text('Payable by Customer:',
                    style:
                        TextStyle(fontSize: 18, fontWeight: FontWeight.w700)),
                Text(
                  'P${rate.toString()}',
                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                ),
              ],
            ),
          ),
          Container(
            height: 50,
            width: MediaQuery.of(context).size.width - 20,
            child: ElevatedButton(
              onPressed: () async {
                await FlutterPhoneDirectCaller.callNumber(pickUpNumberSample);
                // launch('tel://$pickUpSample');
              },
              child: Text(
                'Call Customer',
                style: TextStyle(color: Colors.white),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
