import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profilepage/content/update_profile_details.dart';

class UpdateProfile extends StatelessWidget {
  static const String routeName = '/profile';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: AppBar(
        title: Text('Profile Update'),
      ),
      body: UpdateProfileDetails(),
    );
  }
}
