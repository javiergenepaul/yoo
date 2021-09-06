import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/take_orders_page.dart';
import 'package:yoo_rider_account_page/screens/log_in_page.dart';
import 'package:yoo_rider_account_page/screens/notifpage/notification_settings_page.dart';
import 'package:yoo_rider_account_page/screens/notifpage/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_account_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_income_summary_page.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

Future main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await UserPreferences.init();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Yoo',
      theme: ThemeData(
        primaryColor: Color(0xFF8C27FF),
      ),
      // home: RiderAccount(),
      // routes: {
      //   RiderAccount.routeName: (context) => RiderAccount(),
      //   ProfileSecurity.routeName: (context) => ProfileSecurity(),
      //   RiderIncomeSummary.routeName: (context) => RiderIncomeSummary(),
      //   NotificationsPage.routeName: (context) => NotificationsPage(),
      //   NotificationSettings.routeName: (context) => NotificationSettings(),
      //   HelpCentre.routeName: (context) => HelpCentre(),
      // },
      navigatorKey: RouteGenerator.navigatorKey,
      onGenerateRoute: RouteGenerator.generatorRoute,
      initialRoute: LogInPage.routeName,
    );
  }
}
