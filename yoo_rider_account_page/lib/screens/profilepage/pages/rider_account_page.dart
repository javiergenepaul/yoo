import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profilepage/content/rider_account_body_details.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/update_profile_page.dart';

class RiderAccountPage extends StatelessWidget {
  static const String routeName = '/rideraccount';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('My Account'),
        automaticallyImplyLeading: false,
      ),
      body: AccountBodyDetails(),
    );
  }
}
