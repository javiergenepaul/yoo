import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary.dart';
import 'package:yoo_rider_account_page/widgets/rider_account_widgets.dart';

class AccountBodyDetails extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Column(
        children: <Widget>[
          SafeArea(
            child: Center(
              child: Column(
                children: [
                  SizedBox(
                    height: 20,
                  ),
                  avatar(),
                  SizedBox(
                    height: 10,
                  ),
                  username(),
                  Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        FlatButton(
                          child: Text('Profile & Security'),
                          onPressed: () {
                            Navigator.of(context)
                                .pushNamed(ProfileSecurity.routeName);
                          },
                        ),
                        Icon(Icons.arrow_forward_ios_outlined),
                      ],
                    ),
                  ),
                  Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        rating(),
                        followers(),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          SizedBox(
            height: 10,
          ),
          Divider(),
          SafeArea(
            child: Column(
              children: [
                ListTile(
                  title: Text(
                    'Income Summary',
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  trailing: Icon(Icons.arrow_forward_ios_outlined),
                  onTap: () => Navigator.of(context)
                      .pushNamed(RiderIncomeSummary.routeName),
                ),
                ListTile(
                  title: Text(
                    'Help Centre',
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  trailing: Icon(Icons.arrow_forward_ios_outlined),
                  onTap: () => Navigator.of(context)
                      .pushNamed(RiderIncomeSummary.routeName),
                ),
                ListTile(
                  title: Text(
                    'Notification Settings',
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  trailing: Icon(Icons.arrow_forward_ios_outlined),
                  onTap: () => Navigator.of(context)
                      .pushNamed(RiderIncomeSummary.routeName),
                ),
                ListTile(
                  title: Text(
                    'Privacy Policy',
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  trailing: Icon(Icons.arrow_forward_ios_outlined),
                  onTap: () => Navigator.of(context)
                      .pushNamed(RiderIncomeSummary.routeName),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
