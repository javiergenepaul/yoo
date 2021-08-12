import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/content/daily_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/monthly_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/weekly_income_summary_details.dart';
import 'package:yoo_rider_account_page/screens/help_centre_page.dart';
import 'package:yoo_rider_account_page/screens/notifications_page.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security_page.dart';
import 'package:yoo_rider_account_page/screens/rider_income_summary_page.dart';
import 'package:yoo_rider_account_page/widgets/style_theme.dart';

Widget avatar() {
  return CircleAvatar(
    radius: 50,
    child: Icon(Icons.person),
  );
}

Widget username() {
  return Text(
    'Rider Juan dela Cruz',
    style: TextStyle(
      fontSize: 22,
      fontWeight: FontWeight.bold,
    ),
  );
}

Widget accountinfo(BuildContext context) {
  return Container(
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: [
        rating(context),
        followers(context),
      ],
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

Widget profileSecurityButton(BuildContext context) {
  return Container(
    child: Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        FlatButton(
          child: Text('Profile & Security'),
          onPressed: () {
            Navigator.of(context).pushNamed(ProfileSecurity.routeName);
          },
        ),
        Icon(Icons.arrow_forward_ios_outlined),
      ],
    ),
  );
}

Widget incomeSummary(BuildContext context) {
  return ListTile(
    title: Text(
      'Income Summary',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(RiderIncomeSummary.routeName),
  );
}
// return ExpansionTile(
//   childrenPadding: EdgeInsets.all(10),
//   title: Text('Income Summary'),
//   trailing: Icon(Icons.expand_more),
//   children: [
//     Row(
//       mainAxisAlignment: MainAxisAlignment.spaceEvenly,
//       children: [
//         dailyIncomeExpand(context),
//         weeklyIncomeExpand(context),
//         monthlyIncomeExpand(context),
//       ],
//     )
//   ],
// );

Widget helpCentre(BuildContext context) {
  return ListTile(
    title: Text(
      ' Help Centre',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(HelpCentre.routeName),
  );
}

Widget notificationSettings(BuildContext context) {
  return ListTile(
    title: Text(
      'Notification Settings',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () => Navigator.of(context).pushNamed(NotificationsPage.routeName),
  );
}

Widget privacyPolicy(BuildContext context) {
  return ListTile(
    title: Text(
      'Privacy Policy',
      style: TextStyle(
        fontSize: 15,
        fontWeight: FontWeight.w700,
      ),
    ),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () {},
  );
}
