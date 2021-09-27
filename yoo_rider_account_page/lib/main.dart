import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/landingpage/pages/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/pages/home_page.dart';
import 'package:yoo_rider_account_page/screens/loginpage/pages/log_in_page.dart';
import 'package:yoo_rider_account_page/screens/notifpage/pages/notification_settings_page.dart';
import 'package:yoo_rider_account_page/screens/notifpage/pages/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/rider_account_page.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

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
        // primaryColor: primaryColor,
        // accentColor: primaryColor,
        appBarTheme: AppBarTheme(backgroundColor: primaryColor),
      ),
      navigatorKey: RouteGenerator.navigatorKey,
      onGenerateRoute: RouteGenerator.generatorRoute,
      initialRoute: LogInPage.routeName,
    );
  }
}
