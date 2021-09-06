import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/enum.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/orderspage/order_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_account_page.dart';
import 'package:yoo_rider_account_page/screens/walletpage/wallet_page.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

class MainDrawer extends StatelessWidget {
  const MainDrawer({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: Column(
        children: <Widget>[
          Container(
            width: double.infinity,
            padding: EdgeInsets.all(20),
            color: primaryColor,
            height: MediaQuery.of(context).size.height * .15,
            child: Align(
              alignment: Alignment.centerLeft,
              child: Text(
                'Menu',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
              ),
            ),
          ),
          Container(
            padding: EdgeInsets.all(20),
            child: Column(
              children: [
                ListTile(
                  title: Text('Profile'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {
                    // Navigator.push(
                    //     context,
                    //     MaterialPageRoute(
                    //         builder: (context) => RiderAccountPage()));
                    RouteGenerator.navigateTo(RiderAccountPage.routeName);
                  },
                ),
                ListTile(
                  title: Text('Orders'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {
                    // Navigator.push(context,
                    //     MaterialPageRoute(builder: (context) => OrderPage()));
                    RouteGenerator.navigateTo(OrderPage.routeName);
                  },
                ),
                ListTile(
                  title: Text('Wallet'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {
                    // Navigator.push(context,
                    //     MaterialPageRoute(builder: (context) => WalletPage()));
                    RouteGenerator.navigateTo(WalletPage.routeName);
                  },
                ),
                ListTile(
                  title: Text('Settings'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {
                    // Navigator.push(context,
                    //   MaterialPageRoute(builder: (context) => ()));
                  },
                ),
                ListTile(
                  title: Text('Help Center'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {
                    // Navigator.push(context,
                    //     MaterialPageRoute(builder: (context) => HelpCentre()));
                    RouteGenerator.navigateTo(HelpCentre.routeName);
                  },
                ),
                SizedBox(
                  height: 60,
                ),
                ListTile(
                  title: Text('Log out'),
                  trailing: Icon(Icons.navigate_next),
                  onTap: () {},
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
