import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/content/rider_account_body_details.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/widgets/rider_account_widgets.dart';

class RiderAccountPage extends StatelessWidget {
  static const String routeName = '/rideraccount';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('My Account'),
      ),
      body: AccountBodyDetails(),
    );
  }
}
