import 'package:flutter/material.dart';
import 'package:flutter_phone_direct_caller/flutter_phone_direct_caller.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

import 'active_order_page.dart';

class BillingPage extends StatefulWidget {
  const BillingPage({Key? key}) : super(key: key);

  @override
  _BillingPageState createState() => _BillingPageState();
}

class _BillingPageState extends State<BillingPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Billing Summary'),
      ),
      body: Container(
        padding: EdgeInsets.all(20),
        child: Column(
          children: [
            Flexible(
                flex: 4,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    SizedBox(
                      height: 20,
                    ),
                    Text(
                      'Completed Order',
                      style: TextStyle(
                          color: primaryColor,
                          fontSize: 18,
                          fontWeight: FontWeight.w600),
                    ),
                    SizedBox(
                      height: 30,
                    ),
                    Text('Order Details',
                        style: TextStyle(
                            fontSize: 16, fontWeight: FontWeight.w600)),
                    SizedBox(
                      height: 20,
                    ),
                    Row(
                      children: [
                        Icon(Icons.location_on, color: secondaryColor),
                        SizedBox(width: 5),
                        Text('Pickup',
                            style: TextStyle(
                                fontSize: 15, fontWeight: FontWeight.w600)),
                      ],
                    ),
                    SizedBox(
                      height: 15,
                    ),
                    Row(
                      children: [
                        Icon(Icons.location_on, color: secondaryColor),
                        SizedBox(width: 5),
                        Text('DropOff',
                            style: TextStyle(
                                fontSize: 15, fontWeight: FontWeight.w600)),
                      ],
                    ),
                    SizedBox(
                      height: 15,
                    ),
                    Row(
                      children: [
                        Icon(Icons.add_box, color: secondaryColor),
                        SizedBox(width: 5),
                        Text('Add Ons',
                            style: TextStyle(
                                fontSize: 15, fontWeight: FontWeight.w600)),
                      ],
                    ),
                    SizedBox(
                      height: 15,
                    ),
                    Row(
                      children: [
                        Icon(Icons.schedule, color: secondaryColor),
                        SizedBox(width: 5),
                        Text('Schedule',
                            style: TextStyle(
                                fontSize: 15, fontWeight: FontWeight.w600)),
                      ],
                    ),
                    SizedBox(
                      height: 50,
                      // height: MediaQuery.of(context).size.height * .1,
                    ),
                    Text('Total',
                        style: TextStyle(
                            fontSize: 16, fontWeight: FontWeight.w600)),
                    SizedBox(
                      height: 80,
                      // height: MediaQuery.of(context).size.height * .15,
                    ),
                    Row(
                      children: [
                        Text('Total Amount',
                            style: TextStyle(
                                fontSize: 16, fontWeight: FontWeight.w600)),
                        Spacer(),
                        Icon(
                          Icons.payment,
                          color: secondaryColor,
                        ),
                        SizedBox(width: 5),
                        Text('PHP 123.00',
                            style: TextStyle(
                                fontSize: 16, fontWeight: FontWeight.w600)),
                      ],
                    ),
                  ],
                )),
            Flexible(
                flex: 1,
                child: Column(
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        //Message Button
                        Container(
                          height: 45,
                          width: MediaQuery.of(context).size.height * .2,
                          child: OutlinedButton.icon(
                            onPressed: () {},
                            icon: Icon(Icons.chat_bubble_rounded),
                            label: Text('Message'),
                            style: OutlinedButton.styleFrom(
                                primary: primaryColor,
                                side: BorderSide(color: primaryColor),
                                shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(10))),
                          ),
                        ),
                        //Call Button
                        Container(
                          height: 45,
                          width: MediaQuery.of(context).size.height * .2,
                          child: ElevatedButton.icon(
                            onPressed: () {
                              FlutterPhoneDirectCaller.callNumber(
                                  pickUpNumberSample);

                              // launch('tel://$pickUpSample');
                            },
                            icon: Icon(Icons.call),
                            label: Text('Call'),
                            style: ElevatedButton.styleFrom(
                                primary: primaryColor,
                                shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(10))),
                          ),
                        ),
                      ],
                    ),
                    SizedBox(
                      height: 15,
                    ),
                    Container(
                        height: 45,
                        width: MediaQuery.of(context).size.width,
                        child: ElevatedButton(
                          onPressed: () {
                            // Navigator.push(context,
                            //     MaterialPageRoute(builder: (context) => ()));
                          },
                          child: Text("Get Recipient E-Signature"),
                          style: ElevatedButton.styleFrom(
                              primary: primaryColor,
                              shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(10))),
                        )),
                  ],
                ))
          ],
        ),
      ),
    );
  }
}
