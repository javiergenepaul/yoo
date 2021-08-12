import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notification_settings_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/rider_account_page.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: RiderAccount(),
      routes: {
        RiderAccount.routeName: (context) => RiderAccount(),
        ProfileSecurity.routeName: (context) => ProfileSecurity(),
        RiderIncomeSummary.routeName: (context) => RiderIncomeSummary(),
        NotificationsPage.routeName: (context) => NotificationsPage(),
        NotificationSettings.routeName: (context) => NotificationSettings(),
        HelpCentre.routeName: (context) => HelpCentre(),
      },
    );
  }
}
