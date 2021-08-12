import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/home_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/order_page.dart';
import 'package:yoo_rider_account_page/screens/rider_account_page.dart';
import 'package:yoo_rider_account_page/screens/wallet_page.dart';

class LandingPage extends StatefulWidget {
  static const String routeName = '/homepage';
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<LandingPage> {
  int _currentIndex = 0;

  final AppBarTitle = [
    Text("Home"),
    Text("Order"),
    Text("Wallet"),
    Text("Notification"),
    Text("Profile"),
  ];

  List<Widget> _widgetOption = <Widget>[
    HomePage(),
    OrderPage(),
    WalletPage(),
    NotificationsPage(),
    RiderAccountPage(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: AppBarTitle[_currentIndex],
      ),
      body: _widgetOption.elementAt(_currentIndex),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        type: BottomNavigationBarType.fixed,
        selectedFontSize: 15,
        selectedLabelStyle: TextStyle(fontWeight: FontWeight.bold),
        //iconSize: 30,
        items: [
          BottomNavigationBarItem(
              icon: Icon(Icons.home),
              title: Text("Home"),
              backgroundColor: Colors.blue),
          BottomNavigationBarItem(
              icon: Icon(Icons.add_shopping_cart),
              title: Text("Order"),
              backgroundColor: Colors.blue),
          BottomNavigationBarItem(
              icon: Icon(Icons.account_balance_wallet_outlined),
              title: Text("Wallet"),
              backgroundColor: Colors.blue),
          BottomNavigationBarItem(
              icon: Icon(Icons.circle_notifications_outlined),
              title: Text("Notifications"),
              backgroundColor: Colors.blue),
          BottomNavigationBarItem(
              icon: Icon(Icons.person_outline_outlined),
              title: Text("Profile"),
              backgroundColor: Colors.blue),
        ],
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
      ),
    );
  }
}