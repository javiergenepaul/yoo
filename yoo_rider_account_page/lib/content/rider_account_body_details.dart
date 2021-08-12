import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary_page.dart';
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
                  profileSecurityButton(context),
                  Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        rating(context),
                        followers(context),
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
          SingleChildScrollView(
            child: SafeArea(
              child: Column(
                children: [
                  incomeSummary(context),
                  helpCentre(context),
                  notificationSettings(context),
                  privacyPolicy(context),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
