import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profilepage/help_centre_details.dart';

class HelpCentre extends StatelessWidget {
  static const routeName = '/helpcentre';
  const HelpCentre({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Help Centre'),
      ),
      body: HelpCentreDetails(),
    );
  }
}
