import 'package:animations/animations.dart';
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
  @override
  PageController _pageController = PageController();
  int _selectedIndex = 0;

  void _onPageChanged(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  void _onItemTapped(int selectedIndex) {
    _pageController.jumpToPage(selectedIndex);
  }

  // final AppBarTitle = [
  //   Text("Home"),
  //   Text("My Order"),
  //   Text("My Wallet"),
  //   Text("Notification"),
  //   Text("My Account"),
  // ];

  List<Widget> _widgetOption = [
    HomePage(),
    OrderPage(),
    WalletPage(),
    NotificationsPage(),
    RiderAccountPage(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // appBar: AppBar(
      //   title: AppBarTitle[_currentIndex],
      // ),
      body: PageTransitionSwitcher(
        transitionBuilder: (child, primaryAnimation, secondaryAnimation) =>
            FadeThroughTransition(
          animation: primaryAnimation,
          secondaryAnimation: secondaryAnimation,
          child: child,
        ),
        child: PageView(
          controller: _pageController,
          children: _widgetOption,
          onPageChanged: _onPageChanged,
          physics: NeverScrollableScrollPhysics(),
        ),
      ),
      bottomNavigationBar: Container(
        child: BottomNavigationBar(
          selectedItemColor: Colors.amberAccent,
          onTap: _onItemTapped,
          currentIndex: _selectedIndex,
          type: BottomNavigationBarType.fixed,
          selectedFontSize: 15,
          selectedLabelStyle: TextStyle(fontWeight: FontWeight.bold),
          //iconSize: 30,
          items: [
            BottomNavigationBarItem(
                icon: Icon(Icons.home_outlined),
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
        ),
      ),
    );
  }
}
