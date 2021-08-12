import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary_page.dart';

Widget avatar() {
  return CircleAvatar(
    radius: 50,
    child: Icon(Icons.person),
  );
}

Widget username() {
  return Text(
    'Rider Juan dela Cruz',
    style: TextStyle(
      fontSize: 22,
      fontWeight: FontWeight.bold,
    ),
  );
}

Widget accountinfo() {
  return Container(
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: [
        rating(),
        followers(),
      ],
    ),
  );
}

Widget rating() {
  return Column(
    children: [
      Text(
        '5.0',
        style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),
      ),
      Text(
        'Rating',
      ),
    ],
  );
}

Widget followers() {
  return Column(
    children: [
      Text(
        '100',
        style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),
      ),
      Text(
        'Followers',
      ),
    ],
  );
}

Widget profileSecurityButton(BuildContext context) {
  return Container(
    child: Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        FlatButton(
          child: Text('Profile & Security'),
          onPressed: () {
            Navigator.of(context).pushNamed(ProfileSecurity.routeName);
          },
        ),
        Icon(Icons.arrow_forward_ios_outlined),
      ],
    ),
  );
}

Widget incomeSummary(BuildContext context) {
  return ListTile(
    title: Text(
      'Income Summary',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(RiderIncomeSummary.routeName),
  );
}

Widget helpCentre(BuildContext context) {
  return ListTile(
    title: Text(
      ' Help Centre',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(HelpCentre.routeName),
  );
}

Widget notificationSettings(BuildContext context) {
  return ListTile(
    title: Text(
      'Notification Settings',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(NotificationsPage.routeName),
  );
}

Widget privacyPolicy(BuildContext context) {
  return ListTile(
    title: Text(
      'Privacy Policy',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(RiderIncomeSummary.routeName),
  );
}
