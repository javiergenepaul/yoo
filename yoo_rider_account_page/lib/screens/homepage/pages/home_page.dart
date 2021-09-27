import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/painting.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:yoo_rider_account_page/screens/homepage/pages/active_order_page.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

class HomePage extends StatefulWidget {
  static const String routeName = '/takeorders';
  HomePage({Key? key}) : super(key: key);
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  double rating = 5;
  bool value = true;
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        toolbarHeight: 70,
        title: Text(
          "Available Orders",
          style: appBarStyle,
        ),
        actions: [
          Container(
            padding: EdgeInsets.only(right: 10),
            child: Column(
              children: [
                Switch.adaptive(
                  activeColor: Colors.black,
                  value: value,
                  onChanged: (value) {
                    setState(() {
                      this.value = value;
                    });
                  },
                ),
                Center(
                  child: !value
                      ? Text(
                          'On Duty',
                          style: TextStyle(fontSize: 12),
                        )
                      : Text('Off Duty', style: TextStyle(fontSize: 12)),
                )
              ],
            ),
          )
        ],
        automaticallyImplyLeading: false,
      ),
      body: value
          ? Container(
              padding: const EdgeInsets.only(top: 80, left: 30, right: 30),
              child: Container(
                padding: EdgeInsets.all(20),
                height: MediaQuery.of(context).size.height * .4,
                color: tertiaryColor.withOpacity(.4),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: <Widget>[
                    SizedBox(
                      height: 40,
                    ),
                    Text(
                      'Yoo Rider',
                      style:
                          TextStyle(fontSize: 25, fontWeight: FontWeight.bold),
                    ),
                    Text('Service Type'),
                    SizedBox(
                      height: 50,
                    ),
                    Row(
                      children: [
                        Container(
                          height: 75,
                          width: 75,
                          child: Stack(
                            fit: StackFit.expand,
                            children: [
                              CircularProgressIndicator(
                                value: .75,
                                backgroundColor: Colors.grey,
                                valueColor:
                                    AlwaysStoppedAnimation(primaryColor),
                                strokeWidth: 8,
                              ),
                              Center(
                                child: Text(
                                  '03',
                                  style: TextStyle(fontSize: 18),
                                ),
                              )
                            ],
                          ),
                        ),
                        SizedBox(
                          width: 10,
                        ),
                        Text('Completed\n Delivery'),
                        SizedBox(
                          width: 30,
                        ),
                        Column(
                          children: [
                            Text(
                              'Rating  $rating',
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            RatingBarIndicator(
                              rating: rating,
                              itemBuilder: (context, index) => Icon(
                                Icons.star,
                                color: Colors.amber,
                              ),
                              itemCount: 5,
                              itemSize: 20.0,
                              direction: Axis.horizontal,
                            ),
                          ],
                        )
                      ],
                    )
                  ],
                ),
              ),
            )
          : ActiveOrdersPage(),
    );
  }
}
