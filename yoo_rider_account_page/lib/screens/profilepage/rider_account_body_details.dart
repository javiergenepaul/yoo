import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/notifpage/notification_settings_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notifpage/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_income_summary_page.dart';
import 'package:yoo_rider_account_page/widgets/profile_widgets.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

class AccountBodyDetails extends StatefulWidget {
  @override
  State<AccountBodyDetails> createState() => _AccountBodyDetailsState();
}

class _AccountBodyDetailsState extends State<AccountBodyDetails> {
  @override
  Widget build(BuildContext context) {
    final user = UserPreferences.getUser();
    return Container(
      padding: EdgeInsets.all(15),
      child: Column(
        children: <Widget>[
          SafeArea(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(
                  height: 20,
                ),
                Container(
                  padding: EdgeInsets.all(10),
                  child: Row(
                    children: [
                      ProfileWidget(
                        defaultImage: user.defaultImage,
                        onClicked: () async {
                          await RouteGenerator.navigateTo(
                              ProfileSecurity.routeName);
                          setState(() {});
                        },
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Container(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              user.userName,
                              style: TextStyle(
                                  fontWeight: FontWeight.bold, fontSize: 16),
                            ),
                            Text(user.email),
                          ],
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: <Widget>[
                      rating(context),
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
          SizedBox(
            height: 10,
          ),
          Divider(),
          Container(
            alignment: Alignment.centerLeft,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                TextButton(
                  onPressed: () {},
                  child: Text('Driver ID'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Align(
                    alignment: Alignment.centerLeft,
                    child: Text('City'),
                  ),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Vehicle Type'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Driving License Number'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('License Plate Number'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Password'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                SizedBox(
                  height: 5,
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Log out'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
              ],
            ),
          ),
          profileSecurityButton(),
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

  Widget rating(BuildContext context) {
    return Column(
      children: [
        Text(
          'Rating  5.0',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        RatingBarIndicator(
          rating: 5,
          itemBuilder: (context, index) => Icon(
            Icons.star,
            color: Colors.amber,
          ),
          itemCount: 5,
          itemSize: 20.0,
          direction: Axis.horizontal,
        ),
      ],
    );
    // Container(
    //   width: MediaQuery.of(context).size.width * .2,
    //   height: MediaQuery.of(context).size.width * .2,
    //   decoration: BoxDecoration(
    //     shape: BoxShape.circle,
    //     border: Border.all(
    //       color: active,
    //       width: 3,
    //     ),
    //   ),
    //   child: Center(
    //     child: Column(
    //       mainAxisAlignment: MainAxisAlignment.center,
    //       children: [
    //         Text(
    //           '4.9',
    //           style: TextStyle(
    //               color: active, fontWeight: FontWeight.w500, fontSize: 18),
    //         ),
    //         Text(
    //           'Rating',
    //           style: TextStyle(fontSize: 13),
    //         ),
    //       ],
    //     ),
    //   ),
    // );
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
    return Center(
      child: Container(
          height: 45,
          width: MediaQuery.of(context).size.width,
          child: ElevatedButton(
            onPressed: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => ProfileSecurity()));
              setState(() {});
            },
            child: Text("Update Information"),
            style: ElevatedButton.styleFrom(
                primary: primaryColor,
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10))),
          )),
    );
    // return Container(
    //   child: Row(
    //     mainAxisAlignment: MainAxisAlignment.center,
    //     children: [
    //       FlatButton(
    //         child: Text('Profile & Security'),
    //         onPressed: () async {
    //           await RouteGenerator.navigateTo(ProfileSecurity.routeName);
    //           setState(() {});
    //         },
    //       ),
    //       Icon(Icons.navigate_next),
    //     ],
    //   ),
    // );
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
      trailing: Icon(Icons.navigate_next),
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
      trailing: Icon(Icons.navigate_next),
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
      trailing: Icon(Icons.navigate_next),
      onTap: () => RouteGenerator.navigateTo(NotificationSettings.routeName),
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
      trailing: Icon(Icons.navigate_next),
      onTap: () => null,
    );
  }
}
