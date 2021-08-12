import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/log_in_page.dart';
import 'package:yoo_rider_account_page/screens/rider_account_page.dart';

class RouteGenerator {
  static final GlobalKey<NavigatorState> navigatorKey =
      GlobalKey<NavigatorState>();

  static Future<dynamic> navigateTo(String routeName, {Object? args}) {
    return navigatorKey.currentState!.pushNamed(routeName, arguments: args);
  }

  static goBack() {
    return navigatorKey.currentState!.pop();
  }

  static Route<dynamic> generatorRoute(RouteSettings settings) {
    final args = settings.arguments;

    switch (settings.name) {
      case RiderAccountPage.routeName:
        return MaterialPageRoute(builder: (_) => RiderAccountPage());

      case LogInPage.routeName:
        return MaterialPageRoute(builder: (_) => LogInPage());

      case LandingPage.routeName:
        return MaterialPageRoute(builder: (_) => LandingPage());

      default:
        return _noPageFound();
    }
  }

  static Route<dynamic> _noPageFound() {
    return MaterialPageRoute(
        builder: (_) => Scaffold(
              body: Center(
                child: Text('Page Not Found'),
              ),
            ));
  }
}
