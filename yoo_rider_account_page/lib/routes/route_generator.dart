import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/landingpage/pages/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/orderspage/pages/order_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/pages/home_page.dart';
import 'package:yoo_rider_account_page/screens/loginpage/pages/log_in_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/update_profile_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/rider_account_page.dart';
import 'package:yoo_rider_account_page/screens/walletpage/pages/wallet_page.dart';

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
      case UpdateProfile.routeName:
        return MaterialPageRoute(builder: (_) => UpdateProfile());
      case WalletPage.routeName:
        return MaterialPageRoute(builder: (_) => WalletPage());
      case OrderPage.routeName:
        return MaterialPageRoute(builder: (_) => OrderPage());
      case HomePage.routeName:
        return MaterialPageRoute(builder: (_) => HomePage());

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
