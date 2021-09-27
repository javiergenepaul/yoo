import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profilepage/content/profile_and_security_body_details.dart';

class ProfileSecurity extends StatelessWidget {
  static const String routeName = '/profile';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: AppBar(
        title: Text('Profile & Security'),
      ),
      body: ProfileSecurityBody(),
    );
  }
}
