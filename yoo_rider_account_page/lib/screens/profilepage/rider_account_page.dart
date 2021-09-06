import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_account_body_details.dart';
import 'package:yoo_rider_account_page/screens/profilepage/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/widgets/drawer_widget.dart';

class RiderAccountPage extends StatelessWidget {
  static const String routeName = '/rideraccount';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('My Account'),
      ),
      drawer: MainDrawer(),
      body: AccountBodyDetails(),
    );
  }
}
