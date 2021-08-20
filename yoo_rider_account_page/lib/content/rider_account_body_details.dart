import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary_page.dart';
import 'package:yoo_rider_account_page/widgets/profile_widgets.dart';
import 'package:yoo_rider_account_page/widgets/style_theme.dart';

class AccountBodyDetails extends StatefulWidget {
  @override
  State<AccountBodyDetails> createState() => _AccountBodyDetailsState();
}

class _AccountBodyDetailsState extends State<AccountBodyDetails> {
  @override
  Widget build(BuildContext context) {
    final user = UserPreferences.getUser();
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
                  ProfileWidget(
                    defaultImage: user.defaultImage,
                    onClicked: () async {
                      await RouteGenerator.navigateTo(
                          ProfileSecurity.routeName);
                      setState(() {});
                    },
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  username(user),
                  profileSecurityButton(),
                  Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: <Widget>[
                        buttonDetails(context, '4.8', 'Rating'),
                        Container(
                          height: 24,
                          child: VerticalDivider(
                            color: Colors.black,
                          ),
                        ),
                        buttonDetails(context, '100', 'Followers'),
                        // rating(context),
                        // followers(context),
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
                  incomeSummary(),
                  helpCentre(),
                  notificationSettings(),
                  privacyPolicy(),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget buttonDetails(BuildContext context, String value, String text) {
    return MaterialButton(
      onPressed: () {},
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.start,
        children: <Widget>[
          Text(
            value,
            style: TextStyle(fontWeight: FontWeight.w600),
          ),
          SizedBox(
            height: 2,
          ),
          Text(
            text,
            style: TextStyle(fontSize: 12),
          ),
        ],
      ),
    );
  }

  Widget avatar() {
    return CircleAvatar(
      radius: 50,
      child: Icon(Icons.person),
    );
  }

  Widget username(User user) {
    return Text(
      '${user.userName}',
      style: TextStyle(
        fontSize: 22,
        fontWeight: FontWeight.bold,
      ),
    );
  }

  Widget rating(BuildContext context) {
    return Container(
      width: MediaQuery.of(context).size.width * .2,
      height: MediaQuery.of(context).size.width * .2,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        border: Border.all(
          color: active,
          width: 3,
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              '4.9',
              style: TextStyle(
                  color: active, fontWeight: FontWeight.w500, fontSize: 18),
            ),
            Text(
              'Rating',
              style: TextStyle(fontSize: 13),
            ),
          ],
        ),
      ),
    );
  }

  Widget followers(BuildContext context) {
    return Container(
      width: MediaQuery.of(context).size.width * .2,
      height: MediaQuery.of(context).size.width * .2,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        border: Border.all(
          color: active,
          width: 3,
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              '15',
              style: TextStyle(
                  color: active, fontWeight: FontWeight.w500, fontSize: 18),
            ),
            Text(
              'Followers',
              style: TextStyle(fontSize: 13),
            ),
          ],
        ),
      ),
    );
  }

  Widget profileSecurityButton() {
    return Container(
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          FlatButton(
            child: Text('Profile & Security'),
            onPressed: () async {
              await RouteGenerator.navigateTo(ProfileSecurity.routeName);
              setState(() {});
            },
          ),
          Icon(Icons.arrow_forward_ios_outlined),
        ],
      ),
    );
  }

  Widget incomeSummary() {
    return ListTile(
      title: Text(
        'Income Summary',
        style: TextStyle(
          fontSize: 15,
          fontWeight: FontWeight.w700,
        ),
      ),
      trailing: Icon(Icons.keyboard_arrow_right_sharp),
      onTap: () => RouteGenerator.navigateTo(RiderIncomeSummary.routeName),
    );
  }

  Widget helpCentre() {
    return ListTile(
      title: Text(
        ' Help Centre',
        style: TextStyle(
          fontSize: 15,
          fontWeight: FontWeight.w700,
        ),
      ),
      trailing: Icon(Icons.arrow_forward_ios_outlined),
      onTap: () => RouteGenerator.navigateTo(HelpCentre.routeName),
    );
  }

  Widget notificationSettings() {
    return ListTile(
      title: Text(
        'Notification Settings',
        style: TextStyle(
          fontSize: 15,
          fontWeight: FontWeight.w700,
        ),
      ),
      trailing: Icon(Icons.arrow_forward_ios_outlined),
      onTap: () => RouteGenerator.navigateTo(NotificationsPage.routeName),
    );
  }

  Widget privacyPolicy() {
    return ListTile(
      title: Text(
        'Privacy Policy',
        style: TextStyle(
          fontSize: 15,
          fontWeight: FontWeight.w700,
        ),
      ),
      trailing: Icon(Icons.arrow_forward_ios_outlined),
      onTap: () => null,
    );
  }
}
